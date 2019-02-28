<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Class PayMasterController
 *
 * @package frontend\controllers
 * @author  Dmitriy Mosolov
 * @version 1.0
 *
 */
class PayMasterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($id) {
        if (!empty(Yii::$app->request->post())) {
            Yii::$app->bot->sendMessage(-14068578, json_encode(Yii::$app->request->post()));
            $data = Yii::$app->request->post();
            $orderID = (int)preg_replace("/[^0-9]/", "", $data['LMI_PAYMENT_NO']);
            $amount = (float)preg_replace("/[^0-9.]/", "", $data['LMI_PAID_AMOUNT']);
            $ts = strtotime($data['LMI_SYS_PAYMENT_DATE']);
        }
    }
}
