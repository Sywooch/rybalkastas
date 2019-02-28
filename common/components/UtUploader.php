<?php
namespace common\components;

use common\models\SCCards;
use common\models\SCCustomers;
use common\models\SCOrders;
use common\models\SCOrderStatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class UtUploader {

    public $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
    public $client;

    public function __construct()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        ini_set('default_socket_timeout', 600);
        try{
            $this->client = new \SoapClient($this->url,
                [
                    'login'=>'siteabserver',
                    'password'=>'revresbaetis',
                    'cache_wsdl' => WSDL_CACHE_NONE,
                    'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                    'location' => str_replace('?wsdl', '', $this->url)
                ]
            );
        } catch (\Exception $e){
            $this->client = false;
        }

    }

    public function UploadCustomer(SCCustomers $customer)
    {
        if($this->client == null)return;


        $s_customer = ArrayHelper::toArray($customer);
        $s_customer['site_login'] = (!\Yii::$app->user->isGuest?"":\common\models\User::find()->where(['id'=>$customer['user_id']])->one()->username);
        if(!empty($s_customer['1c_id'])){
            $s_customer['id_ic'] = $s_customer['1c_id'];
        }
        if(empty($s_customer['Email'])){
            $s_customer['Email'] = \common\models\User::find()->where(['id'=>$customer['user_id']])->one()->email;
        }


        $s_customer = json_encode($s_customer);
        $ar = $this->client->createCustomer(['customer'=>$s_customer]);
        $data = $ar->return;
        $data = json_decode($data);
        if($data->customer_id_1c <> "false"){
            $customer->{'1c_id'} = $data->customer_id_1c;
            $customer->save();
        }

    }

    public function CheckCard($email)
    {
        if($this->client == null)false;

        $count = $this->client->checkCard(['Email'=>$email]);
        if($count->return < 1)return false;
        return true;
    }

    public function MoveCard($user){
        if($this->client == null)return;

        $req = [];
        $req['email'] = $user->email;
        $req['id_1c'] = $user->customer->{'1c_id'};
        $reqJson = json_encode($req);

        $newCard = $this->client->MoveCard(['user'=>$reqJson]);
        $data = $newCard->return;
        $data = json_decode($data);
        $number = $data->number;

        $card = SCCards::find()->where(['number'=>$number])->one();
        if(empty($card)){
            $card = new SCCards;
            $card->number = $number;
            $card->discount_percent = 5;
        }
        $card->customerID = $user->customer->customerID;
        $card->save(false);
    }

    public function MergeAccounts($user)
    {
        if($this->client == null)return;
        if(empty($user->customer))return;
        $req = [];
        $req['email'] = $user->email;
        $req['id_1c'] = $user->customer->{'1c_id'};
        $req['reset_id_1c'] = $user->customer->{'reset_id_1c'};
        $reqJson = \yii\helpers\Json::encode($req);

        print_r($reqJson);

        $newCard = $this->client->MergeAccounts(['user'=>$reqJson]);
        $data = $newCard->return;
        if(empty($data) || $data == null || $data == 'null'){
            $data = array(['msg'=>'SAME ACCOUNT']);
            return $data;
        }
        $data = json_decode($data);
        //$number = $data->number;

        if(!empty($data->code) || $data->code == null || $data->code == 'null'){
            $user->customer->{'1c_id'} = $data->code;
        }
        $user->customer->save();

        $card = SCCards::find()->where(['number'=>$data->card])->one();
        if(!empty($card)){
            $card->customerID = $user->customer->customerID;
        } else {
            $card = new SCCards;
            $card->customerID = $user->customer->customerID;
            $card->discount_percent = 5;
        }

        $card->save();

        return $data;
    }

    public function AssignCard($user, $card_number){
        if($this->client == null)return;

        $req['email'] = $user->email;
        $req['id_1c'] = $user->customer->{'1c_id'};
        $req['card'] = $card_number;
        $reqJson = \yii\helpers\Json::encode($req);

        $newCard = $this->client->AssignCard(['user'=>$reqJson]);
        $data = Json::decode($newCard->return);

        $card = SCCards::find()->where(['number'=>$data['number']])->one();
        if(!empty($card)){
            $card->customerID = $user->customer->customerID;
        } else {
            $card = new SCCards;
            $card->customerID = $user->customer->customerID;
            $card->discount_percent = 5;
            $card->number = $data['number'];
        }

        $card->save();

        return $data;
    }

    public function RepairOrder($id){
        if($this->client == null)return;
        $newCard = $this->client->repairOrder(['orderID'=>$id]);
        return $newCard->return;
    }

    public function getStatus(SCOrders $order){
        if($this->client == null)return;
        $newStatus = $this->client->getStatus(['orderID'=>$order->orderID]);
        $data = Json::decode($newStatus->return);
        if(empty($data['orderStatus'])){
            $id = 5;
        } else {
            $status = SCOrderStatus::find()->where(['status_name_ru'=>$data['orderStatus']])->one();
            $id = $status->statusID;
        }

        return $id;
    }

}