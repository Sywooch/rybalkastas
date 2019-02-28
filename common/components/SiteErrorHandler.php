<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 15.03.2017
 * Time: 11:55
 */

namespace common\components;

use yii\base\Exception;
use yii\base\Response;
use yii\helpers\Url;
use Yii;

class SiteErrorHandler extends \yii\web\ErrorHandler
{

    /**
     * @inheridoc
     */

    protected function renderException($exception)
    {
        /*if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
        } else {
            $response = new \yii\web\Response();
        }

        $response->data = $this->convertExceptionToArray($exception);
        $response->setStatusCode($exception->statusCode);

        $response->send();*/


        //\Yii::$app->bot->sendMessage(-14068578, 'Обнаружено возникнование ошибки по адресу: '.Url::current());

        $m = 'Обнаружено возникнование ошибки по адресу: http://'.Yii::$app->request->serverName.Url::current().PHP_EOL.
        'Переход на страницу с ошибкой был осуществлен с адреса: '.$_SERVER['HTTP_REFERER'];
        //\Yii::$app->bot->sendMessage(-14068578, $m);

        parent::renderException($exception);
    }

    /**
     * @inheritdoc
     */

    protected function convertExceptionToArray($exception)
    {
        return [
            'meta'=>
                [
                    'status'=>'error',
                    'errors'=>[
                        ['message'=>$exception->getName(),'code'=>$exception->statusCode]
                    ]
                ]
        ];
    }
}