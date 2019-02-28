<?php

namespace common\services;

use Yii;
use yii\base\Model;
use yii\base\InvalidConfigException;
use common\models\SCOrders;
use frontend\models\OrderingForm;
use frontend\models\OrderingFormQuick;

/**
 *
 * Class MailerService
 * @package common\services
 *
 * @author Dmitriy Mosolov
 * @version 1.0 / last modified 29.11.18
 *
 */
class MailerService
{
    /**
     * @param SCOrders $order
     * @param $form OrderingForm|OrderingFormQuick|Model
     */
    public static function newOrderMailAlert(SCOrders $order, Model $form)
    {
        $mailer = Yii::$app->mailer_no_reply;

        try {
            $mail = $mailer->compose(
                ['html' => '@frontend/views/mail/order'], ['order' => $order]
            );
            $mail->setTo([$form->email]);
            $mail->setSubject("Новый заказ №" . $order->orderID);

            if ($mail->send()) {
                /*Yii::$app->bot->sendMessage(-14068578,
                    "Новый Заказ #" . $order->orderID .
                    "\n\nПокупателю отправлено сообщение на почту:\n" . $form->email .
                    "\n\nОтправитель - noreply@rybalkashop.ru"
                );*/
            } else {
                Yii::$app->bot->sendMessage(-14068578,
                    "Новый Заказ #" . $order->orderID .
                    "\n\nПокупателю НЕ отправлено сообщение на почту:\n" . $form->email .
                    "\n\nОтправитель - noreply@rybalkashop.ru"
                );
            }
        } catch (\Exception $e) {
            try {
                $sendTime = Yii::$app->formatter->asDatetime(time(), 'php:H:i:s');
            } catch (InvalidConfigException $e) {
                $sendTime = "не определено";
            }

            Yii::$app->bot->sendMessage(-14068578,
                "Новый Заказ #" . $order->orderID .
                "\n\nОшибка:\n" . $e->getMessage() .
                "\n\nВремя отправки - " . $sendTime
            );
        }
    }
}
