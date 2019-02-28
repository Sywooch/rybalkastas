<?php
namespace frontend\controllers;

use common\models\SCAuxPages;

use common\models\SCLaterProducts;
use common\models\SCOrders;
use common\models\SCProductRequest;
use frontend\models\CustomerForm;
use Yii;

use yii\web\Controller;

use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use dektrium\user\controllers\SettingsController as SController;

/**
 * Site controller
 */
class PrivateController extends SController
{
    public function actionOrders()
    {
        $orders = Yii::$app->user->identity->customer->orders;
        return $this->render('orders', ['orders'=>$orders]);
    }

    public function actionOrder($id)
    {
        $model = SCOrders::find()->where(['customerID'=>Yii::$app->user->identity->customer->customerID])->andWhere(['orderID'=>$id])->orWhere(['customer_email'=>Yii::$app->user->identity->email])->andWhere(['orderID'=>$id])->one();
        if(empty($model)){
            return $this->redirect(['user/settings/orders']);
        }
        return $this->render('order', ['model'=>$model]);
    }

    public function actionConfirmOrder($id){
        $model = SCOrders::find()->where(['customerID'=>Yii::$app->user->identity->customer->customerID])->andWhere(['orderID'=>$id])->orWhere(['customer_email'=>Yii::$app->user->identity->email])->andWhere(['orderID'=>$id])->andWhere(['statusID'=>5])->one();
        if(empty($model)){
            return $this->redirect(['user/settings/orders']);
        }
        $model->statusID = 26;
        $model->discount_description = "Скидка по карте";
        $model->save();
        return $this->redirect(['/user/settings/order', 'id'=>$id]);
    }

    public function actionCustomer()
    {
        $customer = new CustomerForm();
        $this->performAjaxValidation($customer);
        if ($customer->load(\Yii::$app->request->post())) {
            $thisCustomer = Yii::$app->user->identity->customer;
            $thisCustomer->attributes = $customer->attributes;
            $thisCustomer->save();
            return $this->refresh();
        }

        $customer->attributes = Yii::$app->user->identity->customer->attributes;

        return $this->render('customer', ['model'=>$customer]);
    }

    public function actionLaterproducts()
    {
        $model = SCLaterProducts::find()->where(['userID'=>\Yii::$app->user->identity->customer->customerID])->all();
        return $this->render('laterproducts', ['model'=>$model]);
    }

    public function actionRequestedproducts()
    {
        $model = \Yii::$app->user->identity->customer->requestedProducts;
        //$_COOKIE['requestedCookieShow_n2'] = true;
        setcookie('requestedCookieShow_n2', true,  time()+86400, '/');
        return $this->render('requestedproducts', ['model'=>$model]);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile', 'account', 'networks', 'disconnect', 'delete', 'orders', 'order','confirm-order', 'customer', 'laterproducts', 'requestedproducts'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['confirm'],
                        'roles'   => ['?', '@'],
                    ],
                ],
            ],
        ];
    }
}