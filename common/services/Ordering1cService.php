<?php

namespace common\services;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\SCCustomers;
use common\models\SCOrders;
use common\models\SCCertificates;
use common\models\SCExperts;
use common\models\User;
use common\models\SCCards;
use yii\web\Response;
use common\models\SCOrderedCarts;

/**
 *
 * Class Ordering1cService
 * @package common\services
 *
 * @author Dmitriy Mosolov
 * @version 1.0 / last modified 29.11.18
 *
 */
class Ordering1cService
{
    public static function sendOrderToUt(SCOrders $order, array $items, SCCustomers $customer, bool $external = false) : bool
    {
        $customer = ArrayHelper::toArray($customer);
        $order    = ArrayHelper::toArray($order);

        if (!empty($customer['1c_id'])) {
            $customer['id_ut'] = $customer['1c_id'];
        } else {
            $customer['id_ut'] = "";
        }

        $card = SCCards::find()
            ->where(['customerID' => $customer['customerID']])
              ->one();

        $customer['card'] = (!empty($card) ? $card->number : "");

        if (!$external) {
            $customer['site_login'] = (Yii::$app->user->isGuest ? "" : User::find()->where(['id' => $customer['user_id']])->one()->username);
        } else {
            $customer['site_login'] = (empty(User::find()->where(['id'=>$customer['user_id']])->one()) ? "" : User::find()->where(['id' => $customer['user_id']])->one()->username);
        }

        $manager = SCExperts::findOne($order['manager_id']);

        if (empty($manager)) {
            //Yii::$app->bot->sendMessage(-14068578, "Менеджер не выбран!");
            $order['manager_uid'] = "";
        } else {
            $order['manager_uid'] = $manager->{"1c_id"};
        }

        if (!empty(Yii::$app->session->get('certificateID'))) {
            $cert = SCCertificates::findOne(Yii::$app->session->get('certificateID'));

            $order['certificateNumber'] = $cert->certificateNumber;
            $order['certificateSum'] = $cert->certificateRating;
            $cert->certificateUsed = 1;

            $cert->save();

            SCCertificates::findOne(Yii::$app->session->remove('certificateID'));
        } else {
            $order['certificateNumber'] = 0;
        }

        if (empty($order['source_ref'])) {
            $orderSrc =  'Обычный';
        } elseif($order['source_ref'] == "spdir") {
            $orderSrc =  'Direct';
        } elseif($order['source_ref'] == "dir") {
            $orderSrc =  'YDirect';
        } elseif($order['source_ref'] == "ymrkt") {
            $orderSrc =  'Market';
        } elseif($order['source_ref'] == "rf") {
            $orderSrc =  'RosFishing';
        } else {
            $orderSrc =  'Неизвестно';
        }

        $order['src'] = $orderSrc;

        unset($customer['1c_id']);

        $s_order    = json_encode($order);
        $s_items    = json_encode(ArrayHelper::toArray($items));
        $s_customer = json_encode($customer);

        //Yii::$app->bot->sendMessage(-14068578, $s_order);

        $NUM_OF_ATTEMPTS = 1;

        $attempts = 0;

        do {
            try{
                ini_set("soap.wsdl_cache_enabled", "0");
                ini_set('default_socket_timeout', 20);

                $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
                //echo file_get_contents($url);

                $client = new \SoapClient($url, [
                    'login'      => 'siteabserver',
                    'password'   => 'revresbaetis',
                    'trace'      => true,
                    'cache_wsdl' => 0,
                    'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                    'location' => str_replace('?wsdl', '', $url)
                ]);

                $ar = $client->insertOrder([
                    'order'    => $s_order,
                    'items'    => $s_items,
                    'customer' => $s_customer
                ]);
            } catch (\Exception $e){
                $attempts++;
                Yii::$app->bot->sendMessage(-14068578, $e->getMessage());
                sleep(1);
                continue;
            }

            break;
        } while($attempts < $NUM_OF_ATTEMPTS);

        if (!empty($ar->return)) {
            $data = $ar->return;

            $data = json_decode($data);

            //Yii::$app->bot->sendMessage(-14068578, Json::encode($ar->return));

            if ($data == null) return false;

            if (!empty($data->customer_id_1c) && empty($customer->{'1c_id'})) {
                $customer = SCCustomers::findOne($customer['customerID']);
                $customer->{'1c_id'} = $data->customer_id_1c;
                $customer->save();
            }

            $order = SCOrders::findOne($order['orderID']);
            $order->id_1c = $data->order_id_1c;

            $order->save();
        }

        return true;
    }

    public static function uploadOrderToUt (int $id) : Response
    {
        $order      = SCOrders::findOne($id);
        $customer   = SCCustomers::findOne($order->customerID);
        $cart_items = SCOrderedCarts::find()
            ->where(['orderID' => $order->orderID])
              ->all();

        $cart_itemsAr = [];

        foreach ($cart_items as $ci) {
            $item = ArrayHelper::toArray($ci);
            preg_match('/\[(.*?)\]/', $ci->name, $matches);
            $name = $matches[1];
            $item['name'] = $name;
            $cart_itemsAr[] = $item;
        }

        self::sendOrderToUt($order, $cart_itemsAr, $customer, true);

        return Yii::$app->controller->redirect($_SERVER['HTTP_REFERER']);
    }
}
