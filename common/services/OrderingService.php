<?php

namespace common\services;

use Yii;
use yii\web\Response;
use yii\base\Model;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use frontend\models\OrderingForm;
use frontend\models\OrderingFormQuick;
use dvizh\cart\models\tools\CartQuery;
use common\models\SCOrders;
use common\models\SCShippingMethods;
use common\models\SCPaymentTypes;
use common\models\SCCustomers;
use common\models\SCCities;
use common\models\SCCertificates;
use common\models\SCOrderedCarts;

/**
 *
 * Class OrderingService
 * @package common\services
 *
 * @author Dmitriy Mosolov
 * @version 1.0 / last modified 29.11.18
 *
 */
class OrderingService
{
    const ORDER       = 'order';
    const ORDER_QUICK = 'quick_order';

    public static function creatOrder(array $postData, string $orderType) : Response
    {
        switch ($orderType) {
            case self::ORDER:
                $form = new OrderingForm();
                break;
            case self::ORDER_QUICK:
                $form = new OrderingFormQuick();
                break;
            default:
                return null;
        }

        if ($form->load($postData)) {
            if (CartService::isOrderPriceValid()) {
                if ($form instanceof OrderingForm) {
                    $order = self::createFullOrder($form);
                } elseif ($form instanceof OrderingFormQuick) {
                    $order = self::createQuickOrder($form);
                }

                if (empty($order)) return null;

                CartQuery::invalidateCache();

                Yii::$app->session->set(SCOrders::ORDER_SUCCESS, $order);

                return Yii::$app->controller->redirect('/cart/success');
            } else {
                CartService::setMinimumOrderPriceFlash();
            }
        }

        return Yii::$app->controller->redirect(['/cart/index']);
    }

    /**
     * @param OrderingForm|OrderingFormQuick|Model $form
     * @param $postData
     * @return array
     */
    public static function formValidationAjax(Model $form, $postData) : array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form->load($postData);

        return ActiveForm::validate($form);
    }

    /**
     * @param OrderingForm|OrderingFormQuick|Model $form
     * @param $postData
     * @return array
     */
    public static function formValidation(Model $form, $postData) : array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form->load($postData);

        return ActiveForm::validate($form);
    }

    //================================================================================================================

    private static function createFullOrder(OrderingForm $form) : SCOrders
    {
        $session = Yii::$app->session;

        if (Yii::$app->user->isGuest) {
            $customer = new SCCustomers;

            $customer->Login         = "";
            $customer->Email         = $form->email;
            $customer->cust_password = "";
            $customer->first_name    = $form->first_name;
            $customer->last_name     = $form->last_name;
            $customer->street        = $form->street;
            $customer->city          = $form->city;
            $customer->house         = $form->house;
            $customer->flat          = $form->flat;
            $customer->phone         = PhoneService::formatPhone($form->phone, $form->phonecode);

            $customer->save();
        } else {
            $customer = Yii::$app->user->identity->customer;
        }

        $order = new SCOrders;

        $order->customerID           = $customer->getPrimaryKey();
        $order->customer_ip          = $_SERVER['REMOTE_ADDR'];
        $order->shipping_type        = SCShippingMethods::findOne($form->shipping)->Name_ru;
        $order->shipping_module_id   = 0;
        $order->payment_type         = SCPaymentTypes::findOne($form->payment)->Name_ru;
        $order->payment_module_id    = 0;

        if (!empty($form->patron_name)) {
            $order->customers_comment = "[ОТЧЕСТВО ПОЛЬЗОВАТЕЛЯ: $form->patron_name] " . $form->comment;
        } else {
            $order->customers_comment = $form->comment;
        }

        if (!empty($form->boxberry_info) && $form->shipping == 34) {
            $ar = $form->boxberry_info;
            $order->additional_info  = Json::encode(['boxberry' => $ar]);
        }

        $order->statusID             = 2;
        $order->order_time           = date("Y-m-d H:i:s");
        $order->shipping_cost        = 0;
        $order->order_discount       = 0;
        $order->discount_description = "Нет";
        $order->order_amount         = floatval(Yii::$app->cart->getCost());
        //$order->order_amount       = number_format(Yii::$app->cart->getCost(),2);
        $order->currency_code        = "RUR";
        $order->currency_value       = 1;
        $order->customer_firstname   = $form->first_name;
        $order->customer_lastname    = $form->last_name;
        $order->customer_email       = $form->email;
        $order->shipping_firstname   = $form->first_name;
        $order->shipping_lastname    = $form->last_name;
        $order->shipping_country     = "Россия";
        $order->shipping_state       = SCCities::findOne($form->city)->cityName;
        $order->shipping_zip         = $form->zip;
        $order->shipping_address     = SCCities::findOne($form->city)->cityName . ' ' . $form->street . ' ' . $form->house . ' ' . $form->flat;
        $order->billing_firstname    = $form->first_name;
        $order->billing_lastname     = $form->last_name;
        $order->billing_country      = "Россия";
        $order->billing_state        = SCCities::findOne($form->city)->cityName;
        $order->billing_zip          = $form->zip;
        $order->billing_city         = SCCities::findOne($form->city)->cityName;
        $order->billing_address      = SCCities::findOne($form->city)->cityName . ' ' . $form->street . ' ' . $form->house . ' ' . $form->flat;
        $order->user_phone           = PhoneService::formatPhone($form->phone, $form->phonecode);
        $order->manager_id           = $form->manager;
        $order->customer_patronname  = $form->patron_name;

        if (isset($session['srcref'])) {
            $order->source_ref = $session['srcref'];
        }

        if (isset($session['certificateID'])) {
            $certificate = SCCertificates::findOne(Yii::$app->session->get('certificateID'));

            if ($certificate->certificateUsed == 0) {
                $order->certificate_id = $session['certificateID'];
            }
        }

        if ($order->save()) {
            $elements = Yii::$app->cart->elements;

            $cart_items = [];

            $i = 0;

            foreach ($elements as $el) {
                $product = \common\models\SCProducts::findOne($el->item_id);

                if (empty($product)) continue;

                $cart_item = new SCOrderedCarts;

                $cart_item->itemID       = $el->id;
                $cart_item->orderID      = $order->getPrimaryKey();
                $cart_item->name         = "[$product->product_code] $product->name_ru";
                $cart_item->Price        = $el->price;
                $cart_item->Quantity     = $el->count;
                $cart_item->tax          = 0;
                $cart_item->DefaultPrice = floatval($product->normalPrice);
                $cart_item->Discount     = !empty($customer->card) ? $product->maxDiscount : 0;

                if (!$cart_item->save()) return null;

                $cart_item_ar = ArrayHelper::toArray($cart_item);
                $cart_item_ar['name'] = $product->product_code;

                // Добавлена выгрузка процента цены от старой цены
                if ($product->Price < $product->list_price) {
                    $percent = 100 - (($product->Price * 100) / $product->list_price);
                    //$cart_item['Price'] = $cart_item['Discount'] + $percent;
                    $cart_item_ar['Discount'] = $percent;
                }

                $cart_items[] = $cart_item_ar;

                $product->in_stock = ($product->in_stock - $el->count);

                $product->save();

                $i++;
            }

            if (empty($cart_items)) return null;

            Ordering1cService::sendOrderToUt($order, $cart_items, $customer);

            $form->orderID = $order->orderID;

            Yii::$app->cart->truncate();

            MailerService::newOrderMailAlert($order, $form);

            $session->remove('srcref');

            return $order;
        } else {
            Yii::$app->bot->sendMessage(-14068578, Json::encode($order->errors));

            return null;
        }
    }

    private static function createQuickOrder(OrderingFormQuick $form) : SCOrders
    {
        $session = Yii::$app->session;

        if (Yii::$app->user->isGuest) {
            $customer = new SCCustomers;

            $customer->Login         = "";
            $customer->Email         = $form->email;
            $customer->cust_password = "";
            $customer->first_name    = $form->first_name;
            $customer->last_name     = $form->last_name;
            $customer->street        = "";
            $customer->city          = "";
            $customer->house         = "";
            $customer->phone         = "";

            $customer->save();
        } else {
            $customer = Yii::$app->user->identity->customer;
        }

        $order = new SCOrders;

        $order->customerID           = $customer->getPrimaryKey();
        $order->customer_ip          = $_SERVER['REMOTE_ADDR'];
        $order->shipping_type        = SCShippingMethods::findOne($form->shipping)->Name_ru;
        $order->shipping_module_id   = 0;
        $order->payment_type         = null;
        $order->payment_module_id    = 0;

        $order->statusID             = 2;
        $order->order_time           = date("Y-m-d H:i:s");
        $order->shipping_cost        = 0;
        $order->order_discount       = 0;
        $order->discount_description = "Нет";
        $order->order_amount         = floatval(Yii::$app->cart->getCost());
        //$order->order_amount       = number_format(Yii::$app->cart->getCost(),2);
        $order->currency_code        = "RUR";
        $order->currency_value       = 1;
        $order->customer_firstname   = $form->first_name;
        $order->customer_lastname    = $form->last_name;
        $order->customer_email       = $customer->Email;
        $order->shipping_firstname   = $form->first_name;
        $order->shipping_lastname    = $form->last_name;
        $order->shipping_country     = "Россия";
        $order->shipping_state       = "";
        $order->shipping_zip         = "";
        $order->shipping_address     = "";
        $order->billing_firstname    = $form->first_name;
        $order->billing_lastname     = $form->last_name;
        $order->billing_country      = "";
        $order->billing_state        = "";
        $order->billing_zip          = "";
        $order->billing_city         = "";
        $order->billing_address      = "";
        $order->user_phone           = PhoneService::formatPhone($form->phone, $form->phonecode);
        $order->manager_id           = "";
        $order->customer_patronname  = "";

        if (isset($session['srcref'])) {
            $order->source_ref = $session['srcref'];
        }

        if (isset($session['certificateID'])) {
            $certificate = SCCertificates::findOne(Yii::$app->session->get('certificateID'));

            if ($certificate->certificateUsed == 0) {
                $order->certificate_id = $session['certificateID'];
            }
        }

        if ($order->save()) {
            $elements = Yii::$app->cart->elements;

            $cart_items = [];

            $i = 0;

            foreach ($elements as $el) {
                $product = \common\models\SCProducts::findOne($el->item_id);

                if (empty($product)) continue;

                $cart_item = new SCOrderedCarts;

                $cart_item->itemID       = $el->id;
                $cart_item->orderID      = $order->getPrimaryKey();
                $cart_item->name         = "[$product->product_code] $product->name_ru";
                $cart_item->Price        = $el->price;
                $cart_item->Quantity     = $el->count;
                $cart_item->tax          = 0;
                $cart_item->DefaultPrice = floatval($product->normalPrice);
                $cart_item->Discount     = $product->maxDiscount;

                if (!$cart_item->save()) {
                    print_r($cart_item->getErrors());
                    return null;
                }

                $cart_item_ar = ArrayHelper::toArray($cart_item);
                $cart_item_ar['name'] = $product->product_code;

                if($product->Price < $product->list_price){
                    $percent = 100 - (($product->Price * 100) / $product->list_price);
                    //$cart_item['Price'] = $cart_item['Discount'] + $percent;
                    $cart_item_ar['Discount'] = $percent;
                }

                $cart_items[] = $cart_item_ar;

                $product->in_stock = ($product->in_stock - $el->count);
                $product->save();

                $i++;
            }

            if (empty($cart_items)) {
                print_r($elements);
                return null;
            }

            Ordering1cService::sendOrderToUt($order, $cart_items, $customer);

            $form->orderID = $order->orderID;

            Yii::$app->cart->truncate();

            MailerService::newOrderMailAlert($order, $form);

            $session->remove('srcref');

            return $order;
        } else {
            Yii::$app->bot->sendMessage(-14068578, Json::encode($order->errors));

            return null;
        }
    }
}
