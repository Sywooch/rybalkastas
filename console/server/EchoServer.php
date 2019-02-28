<?php
namespace console\server;

use backend\components\ChatEventsComponent;
use backend\modules\im\models\Conversation;
use backend\modules\im\models\ConversationMessage;
use common\models\Profile;
use common\models\User;
use consik\yii2websocket\events\WSClientMessageEvent;
use consik\yii2websocket\WebSocketServer;
use MongoDB\BSON\ObjectID;
use Ratchet\ConnectionInterface;
use yii\helpers\Json;

class EchoServer extends WebSocketServer
{

    protected $clients;
    private $user_ids;
    private $user_data;
    private $users;

    public function __construct(array $config = [])
    {
        $this->clients = new \SplObjectStorage;
        $this->user_ids = [];
        $this->user_data = [];
        $this->users = [];
        parent::__construct($config);
    }

    /*public function init()
    {
        parent::init();

        $ce = new ChatEventsComponent();
        $ce->on(ChatEventsComponent::EVENT_HELLO, function($event){

        });

        $this->on(self::EVENT_CLIENT_MESSAGE, function (WSClientMessageEvent $e) {
            $e->client->send( $e->message );
        });
    }*/

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;
    }

    public function onMessage(ConnectionInterface $conn, $msg)
    {
        $uid = null;
        if(!empty($this->user_ids[$conn->resourceId])) $uid = $this->user_ids[$conn->resourceId];
        $data = json_decode($msg);
        switch ($data->type){
            case "auth":
                $decrypted_id_raw = base64_decode($data->cipher);
                $decrypted_id = preg_replace(sprintf('/%s/', \Yii::$app->params['chat_secret']), '', $decrypted_id_raw);
                $this->user_ids[$conn->resourceId] = $decrypted_id;

                $profile = Profile::find()->where(['user_id'=>$decrypted_id])->one();
                $this->user_data[$decrypted_id]['name'] = !empty($profile->name)?$profile->name:User::findOne($decrypted_id)->username;
                $this->user_data[$decrypted_id]['id'] = $decrypted_id;
                if(strpos($profile->getThumbUrl(30, 30), 'data:') !== false){
                    $this->user_data[$decrypted_id]['avatar_url'] = $profile->getThumbUrl(30, 30);
                } else {
                    $this->user_data[$decrypted_id]['avatar_url'] = 'http://rybalkashop.ru'.$profile->getThumbUrl(30, 30);
                }


                $msgto['type'] = 'auth';
                $msgto['msg'] = $decrypted_id;

                $this->users[$conn->resourceId]->send(json_encode($msgto));
                echo "Online: ".count($this->users).PHP_EOL;
                print_r($this->user_data);
                $this->sendOnline();
                break;
            case "msg":
                $conversation = $data->cid;
                if(empty(trim($data->msg)))break;
                $this->sendConvMsg($data->msg, $conversation, $uid);
                break;
            case "alert":
                $keys = array_keys($this->user_ids, $data->uid);
                //echo "KEY key $key";
                foreach($keys as $key){
                    if(!empty($this->users[$key])){
                        $msgto = [];
                        $msgto['type'] = 'alert';
                        $msgto['msg'] = $data->msg;
                        $this->users[$key]->send(json_encode($msgto));
                    }
                }

                //$this->users[$conn->resourceId]->send("asdaszxc");
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
        unset($this->user_ids[$conn->resourceId]);
        echo "Online: ".count($this->users).PHP_EOL;
        $this->sendOnline();
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getTraceAsString()}\n";
        $conn->close();
    }


    public function sendConvMsg($msg, $conv_id, $uid)
    {
        $conversation = Conversation::findOne($conv_id);

        $cmsg = new ConversationMessage();
        $cmsg->sender = $uid;
        $cmsg->conversation_id = new ObjectID($conv_id);
        $cmsg->content = $msg;
        $cmsg->timestamp = time();
        $cmsg->save();

        $conversation->last = $cmsg->timestamp;
        $conversation->save();

        //$profile = Profile::find()->where(['user_id'=>$uid])->one();
        foreach ($conversation['users'] as $u){

            $key = array_search($u, $this->user_ids);
            if(!empty($this->users[$key])){
                $msgto = [];
                $msgto['self'] = 0;
                if($uid == $u){
                    $msgto['self'] = 1;
                }
                $msgto['type'] = 'newmsg';
                $msgto['msg'] = $msg;
                $msgto['from'] = $this->user_data[$uid]['name'];
                $msgto['avatar_url'] = $this->user_data[$uid]['avatar_url'];
                $msgto['ts'] = date("Y-m-d H:i:s");

                $this->users[$key]->send(json_encode($msgto));
            }
        }
    }

    public function sendOnline()
    {
        foreach ($this->users as $user){
            $msgto = [];
            $msgto['type'] = "online";
            $msgto['users'] = $this->user_data;
            $user->send(json_encode($msgto));
        }
    }


}