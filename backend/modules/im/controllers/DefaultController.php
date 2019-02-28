<?php

namespace backend\modules\im\controllers;

use backend\components\ChatEventsComponent;
use backend\modules\im\models\Conversation;
use backend\modules\im\models\ConversationMessage;
use yii\web\Controller;

/**
 * Default controller for the `im` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $session = \Yii::$app->session;
        $convid = isset($_SESSION['conv_id']) ? $_SESSION['conv_id'] : null;



        $ce = new ChatEventsComponent();
        $ce->trigger(ChatEventsComponent::EVENT_HELLO);

        $conversations = Conversation::find()->where(['users'=>1])->orderBy('last DESC')->all();
        if(!empty($convid)){
            $conv = Conversation::findOne($convid);
            $msgs = ConversationMessage::find()->where(['conversation_id'=>$conv->_id])->orderBy("timestamp DESC");
        } else {
            $conv = Conversation::find()->where(['users'=>1])->orderBy(['_id'=>SORT_DESC])->one();
            $msgs = ConversationMessage::find()->where(['conversation_id'=>$conv->_id])->orderBy("timestamp DESC");
        }

        $msgs = $msgs->limit(20)->all();
        //print_r($msgs);
        return $this->render('index', ['conversations'=>$conversations,'conv'=>$conv, 'msgs'=>$msgs]);
    }

    public function actionLoad()
    {
        $conv = $_POST['conv'];
        $session = \Yii::$app->session;
        $session->set('conv_id', $conv);
        $conv = Conversation::findOne($conv);
        $msgs = ConversationMessage::find()->where(['conversation_id'=>$conv->_id])->all();
        return $this->renderAjax('_chat', ['conv'=>$conv, 'msgs'=>$msgs]);
    }

    public function actionMaster()
    {
        return $this->render('master');
    }

}
