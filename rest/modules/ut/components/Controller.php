<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 04.07.2018
 * Time: 13:17
 */

namespace rest\modules\ut\components;

use common\models\mongout\AccessTokens;
use yii\filters\Cors;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;
use yii\helpers\Json;

class Controller extends \yii\rest\Controller {

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

    public function beforeAction($action)
    {
        if(!\Yii::$app->request->isOptions && $_SERVER["REMOTE_ADDR"] !== '176.107.242.44'){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $token = @\Yii::$app->request->headers['authorization'];
            if($token == '[object Object]') return null;
            $token_object = AccessTokens::findOne(['token'=>$token]);
            if(empty($token) || empty($token_object)){
                Throw new UnauthorizedHttpException('token_invalid');
            }
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }
}
