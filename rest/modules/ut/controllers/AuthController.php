<?php

namespace rest\modules\ut\controllers;

use common\models\mongout\AccessTokens;
use common\models\mongout\Orders;
use common\models\mongout\Users;
use \rest\modules\ut\components\Controller;
use yii\base\Security;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

/**
 * Default controller for the `ut` module
 */
class AuthController extends \yii\rest\Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS', 'POST', 'PUT'],
                'Access-Control-Allow-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept', 'Authorization', 'Link'],
                'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Expose-Headers' => ['Authorization', 'Access-Control-Allow-Origin'],
            ]
        ];
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    public function actionLogin(){
        $model = Users::find()->where(['login'=>$_POST['login']])->one();
        if(!empty($model)){
            $password = $_POST['password'];
            if(\Yii::$app->getSecurity()->validatePassword($password, $model->password_hash)){
                $token = new AccessTokens();
                $token->user_id = $model->_id;
                $token->token = bin2hex(random_bytes(64));
                $dt = new \DateTime();
                $dt->add(new \DateInterval('P30D'));
                $token->active_to = $dt->getTimestamp();
                $token->save();

                $payload = [
                    'token'=>$token->token,
                    'login'=>$model->login,
                    'name'=>$model->name,
                    'link'=>$model->link,
                    'valid_to'=>$token->active_to
                ];
                return $payload;
            }
        }
        throw new UnauthorizedHttpException();
    }
}
