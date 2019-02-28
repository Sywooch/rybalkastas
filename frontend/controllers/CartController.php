<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use dvizh\cart\models\tools\CartQuery;
use common\models\CartElement;
use common\models\SCCertificates;
use common\models\SCCities;
use common\models\SCLaterProducts;
use common\models\SCExperts;
use common\models\SCShippingMethods;
use common\models\SCProducts;
use common\services\CartService;
use common\services\OrderingService;
use common\models\SCOrders;
use frontend\models\ApplyCertificateForm;
use frontend\models\OrderingForm;
use frontend\models\OrderingFormQuick;

/**
 * Site controller
 */
class CartController extends Controller
{
    public function actions()
    {
        /*return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'foreColor' => 0x2040A0,
                'backColor' => 0xefefef,
            ],
        ];*/
    }

    public function actionIndex()
    {
        if (!empty(Yii::$app->request->referrer)) {
            Yii::$app->session->set('ref', Yii::$app->request->referrer);
        }

        $cart = Yii::$app->cart->cart;

        if (!empty($cart)) {
            $els = CartElement::find()->where(['cart_id' => $cart->id])->all();

            foreach ($els as $e) {
                $product_price = SCProducts::find()->where(['productID' => $e->item_id])->one();

                if (empty($product_price)) continue;
                //if ($product_price->actualPrice == $e->price) continue;

                $e->price = $product_price->actualPrice;

                $e->save();
            }
        }

        // Выравнивание наличия
        $elements = Yii::$app->cart->elements;

        if (empty($elements)) {
            if (!empty(Yii::$app->session['ref'])) {
                $this->redirect(Yii::$app->session['ref']);
            } else {
                $this->redirect(['site/index']);
            }
        }

        foreach ($elements as $e) {
            $item = SCProducts::findOne($e->item_id);
            if (empty($item)) continue;

            if ($e->count > $item->in_stock) {
                $e->count = $item->in_stock;

                $e->save();
            }

            if ($e->count <= 0) {
                $e->delete();
            }
        }
        // --

        $this->view->params['hide_sidebar'] = 1;

        $model      = new OrderingForm();
        $modelQuick = new OrderingFormQuick();

        if (!Yii::$app->user->isGuest) {
            $model->attributes = Yii::$app->user->identity->customer->attributes;

            if (!empty($model->phone) && $model->phone[0] == '8') {
                $model->phone[0] = 7;
                $model->phone = '+' . $model->phone;
            }

            if (!empty(Yii::$app->user->identity->customer->city)) {
                $model->city = SCCities::findOne(Yii::$app->user->identity->customer->city)->cityID;
            }

            $model->email = Yii::$app->user->identity->email;
        }

        return $this->render('index', [
            'model'           => $model,
            'modelQuick'      => $modelQuick,
            'certForm'        => new ApplyCertificateForm,
            'cities'          => SCCities::find()->orderBy('cityName')->all(),
            'experts'         => SCExperts::find()->orderBy('RAND()')->all(),
            'shippingMethods' => SCShippingMethods::find()->where(['!=', 'SID', 30])
                ->orderBy('sort_order')->all(),
        ]);
    }

    public function actionCreateOrder()
    {
        OrderingService::creatOrder(Yii::$app->request->post(), OrderingService::ORDER);
    }

    public function actionCreateQuickOrder()
    {
        OrderingService::creatOrder(Yii::$app->request->post(), OrderingService::ORDER_QUICK);
    }

    public function actionOrderFormValidate()
    {
        return OrderingService::formValidation(new OrderingForm(), Yii::$app->request->post());
    }

    public function actionOrderQuickFormValidate()
    {
        return OrderingService::formValidation(new OrderingFormQuick(), Yii::$app->request->post());
    }

    public function actionSuccess()
    {
        $order = Yii::$app->session->get(SCOrders::ORDER_SUCCESS);

        if ($order) {
            return $this->render('success_order', [
                'order' => $order
            ]);
        }

        return $this->redirect(['site/index']);
    }

    public function actionItemEdit($action, $item)
    {
        try {
            CartService::editCartItem($action, $item);
        } catch (NotFoundHttpException $exception) {
            echo $exception->getMessage();
        }
    }

    public function actionCheckShipping()
    {
        CartService::checkShipping();
    }

    public function actionApplyCertificate()
    {
        $model = new ApplyCertificateForm;

        CartQuery::invalidateCache();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            Yii::$app->session->set('certificateID', SCCertificates::find()->where(['certificateNumber'=>$model->number])->one()->certificateID);

            return ActiveForm::validate($model);
        } else {
            $this->redirect(['cart/index']);
        }
    }

    public function actionClear()
    {
        CartService::cartClear();
    }

    public function actionAddLaterCart($item)
    {
        if (!Yii::$app->user->isGuest) {
            $element = Yii::$app->cart->getElementById($item);
            if (empty($element)) return true;

            $product = SCProducts::findOne($element->item_id);

            if (!empty($product)) {
                $check = SCLaterProducts::find()
                       ->where(['userID' => Yii::$app->user->identity->customer->customerID])
                    ->andWhere(['productID'=>$product->productID])
                         ->one();

                if (!empty($check)) return true;

                $later = new SCLaterProducts;

                $later->productID = $product->productID;
                $later->userID = Yii::$app->user->identity->customer->customerID;

                if (!$later->save()) {
                    print_r($later->getErrors());
                };

                $element->delete();

                unset($element);
            }
        }

        if (Yii::$app->cart->getCost() <= 0) {
            if (!empty(Yii::$app->session['ref'])) {
                $this->redirect(Yii::$app->session['ref']);
            } else {
                $this->redirect(['site/index']);
            }
        }

        $return['sum'] = number_format(Yii::$app->cart->getCost(), 2) .'&nbsp;руб.';
        $return['count'] = Yii::$app->cart->count;

        CartQuery::invalidateCache();

        echo json_encode($return);
    }
}
