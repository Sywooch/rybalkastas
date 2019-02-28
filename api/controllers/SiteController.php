<?php
namespace api\controllers;
use common\models\User;
use dektrium\user\helpers\Password;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;


class SiteController extends Controller
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
        $user = User::find()->where(['username'=>\Yii::$app->request->post('login')])->one();
        if(!empty($user) && Password::validate(\Yii::$app->request->post('password'), $user->password_hash)){
            return \Yii::$app->params['tempAuth'];
        }
        return 'error';
    }

}