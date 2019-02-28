<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 23.10.2015
 * Time: 12:03
 */

namespace backend\components;

use common\models\Alerts;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\web\Cookie;

class AlertComponent extends Widget
{
    public function alert()
    {
        $checkCookie = \Yii::$app->getRequest()->getCookies()->getValue('seen_alert2');

        if (empty($checkCookie)) {
            if(Yii::$app->user->id == 1){
                $cookie = new Cookie([
                    'name' => 'seen_alert2',
                    'value' => 1,
                    'expire' => time() + 86400 * 365,
                ]);
                \Yii::$app->getResponse()->getCookies()->add($cookie);

                $alert = Alerts::find()->one();

                return $this->render('alert', ['alert'=>$alert]);
            }
        }
    }

}