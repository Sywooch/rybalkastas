<?php

namespace common\services;

use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use dvizh\cart\models\tools\CartQuery;
use common\models\SCProducts;
use common\models\SCPaymentTypes;
use common\models\SCPaymentTypesShippingMethods;

/**
 *
 * Class OrderingService
 * @package common\services
 *
 * @author Dmitriy Mosolov
 * @version 1.0 / last modified 29.11.18
 *
 */
class CartService
{
    /**
     * @param string $action
     * @param int $item
     * @throws NotFoundHttpException
     */
    public static function editCartItem(string $action, int $item) {
        $actions = ['increment', 'decrement', 'delete'];

        if (!in_array($action, $actions)) throw new NotFoundHttpException;

        $element = Yii::$app->cart->getElementById($item);

        if (empty($element)) throw new NotFoundHttpException;

        switch ($action) {
            case 'increment':
                $element->count++;

                $product = SCProducts::findOne($element->item_id);

                if ($element->count > $product->in_stock) {
                    $element->count = $product->in_stock;
                }

                if (!$element->save()) {
                    //print_r(debug_backtrace());
                }

                break;
            case 'decrement':
                $element->count--;

                if($element->count < 0){
                    $element->count = 1;
                }

                $element->save();

                break;
            case 'delete':
                $element->delete();

                unset($element);

                if (Yii::$app->cart->getCost() <= 0) {
                    if(!empty(Yii::$app->session['ref'])){
                        Yii::$app->controller->redirect(Yii::$app->session['ref']);
                    } else {
                        Yii::$app->controller->redirect('site/index');
                    }
                }

                break;
            default: break;
        }

        $return = [];

        if (isset($element)) {
            $product = SCProducts::findOne($element->item_id);

            $return['tr'] = Yii::$app->controller->renderAjax('_product_row', [
                'p'       => $element,
                'product' => $product
            ]);
        } else {
            $return['tr'] = '';
        }

        $return['sum'] = number_format(Yii::$app->cart->getCost(), 2) . '&nbsp;руб.';
        $return['sum_int'] = Yii::$app->cart->getCost();
        $return['count'] = Yii::$app->cart->count;
        $return['msg'] = Yii::$app->controller->renderPartial('_cart_msg');

        CartQuery::invalidateCache();

        echo json_encode($return);
    }

    public static function checkShipping()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                $ship_id = $parents[0];

                $connection = SCPaymentTypesShippingMethods::find()
                    ->select('PID')
                     ->where(['SID' => $ship_id]);

                $payments = SCPaymentTypes::find()
                      ->where(['in', 'PID', $connection])
                    ->orderBy('sort_order')
                        ->all();

                foreach ($payments as $payment) {
                    $out[] = [
                        'id'   => $payment->PID,
                        'name' => $payment->Name_ru
                    ];
                }

                echo Json::encode(['output' => $out, 'selected' => 1]);

                return;
            }
        }

        //CartQuery::invalidateCache();

        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public static function cartClear() {
        Yii::$app->cart->truncate();

        if(!empty(Yii::$app->session['ref'])){
            Yii::$app->controller->redirect(Yii::$app->session['ref']);
        } else {
            Yii::$app->controller->redirect(['site/index']);
        }
    }

    public static function isOrderPriceValid() : bool
    {
        return self::getOrderCost() >= self::getMinOrderPrice();
    }

    public static function setMinimumOrderPriceFlash()
    {
        Yii::$app->session->setFlash('notify', [
            'msg'  => 'Сумма заказа не может быть меньше ' . Yii::$app->settings->get('cart', 'minprice').' руб.',
            'icon' => 'fa fa-exclamation'
        ]);
    }

    //================================================================================================================

    private static function getMinOrderPrice() : int
    {
        return Yii::$app->settings->get('cart', 'minprice') - (empty(Yii::$app->session->get('certificateID')) ? 0 : Yii::$app->settings->get('cart', 'minprice'));
    }

    private static function getOrderCost() : int
    {
        return Yii::$app->cart->getCost();
    }
}
