<?php
namespace frontend\behaviors;

use yii\base\Behavior;
use dvizh\cart\Cart;

class CartDiscount extends Behavior
{
    public $percent = 0;

    public function events()
    {
        return [
            Cart::EVENT_CART_COST => 'doDiscount'
        ];
    }

    public function doDiscount($event)
    {
        $certificate = \Yii::$app->session->get('certificateID');
        if(!empty($certificate)){
            $certificate = \common\models\SCCertificates::findOne($certificate);

            $event->cost = $event->cost - $certificate->certificateRating;

            if($event->cost <= 0){
                $event->cost = 0;
            }
        }




        return $this;
    }
}
