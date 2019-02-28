<?php

namespace console\controllers;

use common\models\SCOrders;
use yii\console\Controller;
use console\server\EchoServer;

class BurnhartController extends Controller{

    public function actionRunEcho($port = 8001)
    {
        $server = new EchoServer();
        if ($port) {
            $server->port = $port;
        }
        $server->start();
    }

    public function actionStopEcho($port = 8001)
    {
        $server = new EchoServer();
        if ($port) {
            $server->port = $port;
        }
        $server->stop();
    }

    public function actionTestMail()
    {
        $order = SCOrders::findOne(119285);
        $mailer = \Yii::$app->mailer_s;
        try {
            $mail = $mailer->compose(['html'=>'@frontend/views/mail/status_change'],['order'=>$order])
                ->setFrom(['contacts@rybalkashop.ru' => 'Rybalkashop.ru Рыболов на "Птичке"']);
            $mail->setTo('denvolin@gmail.com');
            $mail->setSubject("Изменение статуса заказа №".$order->orderID);
            if(!$mail->send()){
                \Yii::$app->bot->sendMessage(-14068578, "Сообщение не отправлено!");
            }
            //\Yii::$app->bot->sendMessage(-14068578, '!!! Смена статуса заказа №'.$this->orderID.' от '.$this->order_time.". C \"$oldname->status_name_ru\" на \"$newname->status_name_ru\"");
        } catch (\Exception $e){
            \Yii::$app->bot->sendMessage(-14068578, $e->getTraceAsString());
        }
    }

}