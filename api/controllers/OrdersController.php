<?php
namespace api\controllers;
use common\models\SCOrders;
use common\models\User;
use dektrium\user\helpers\Password;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;


class OrdersController extends Controller
{

    public static function allowedDomains()
    {
        return [
            '*',                        // star allows all domains
            'http://localhost:8080',
            'http://test1.example.com',
            'http://test2.example.com',
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
            ]
        ]);
    }

    public function actionIndex()
    {
        $query = SCOrders::find()->where(['status' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
    }

}