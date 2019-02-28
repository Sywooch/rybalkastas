<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 05.05.2017
 * Time: 7:25
 */

namespace common\traits;

use common\models\mongo\UserMeta;

trait UserMongoTrait
{
    public function viewProductF($user_id, $product_id)
    {
        $selection = UserMeta::find()->where(['user_id'=>$user_id])->count();
        if(empty($selection)){
            $newMeta = new UserMeta;
            $newMeta->user_id = $user_id;
            $newMeta->product_views = [['productID'=>$product_id, 'views'=>1]];
            $newMeta->save();
        } else {

            if(!UserMeta::updateAll(
                ['$inc' => ["product_views.$.views" => 1]],
                ['user_id'=>$user_id, "product_views.productID"=>$product_id]
            )){
                UserMeta::updateAll(
                    ['$addToSet' => ['product_views' => ['productID'=>$product_id, 'views'=>1]]],
                    ['user_id' => $user_id],
                    ['upsert'=>true]);
            }



        }
    }

    public function addToWaiting($user_id, $product_id)
    {
        $selection = UserMeta::find()->where(['user_id'=>$user_id])->count();
        if(empty($selection)){
            $newMeta = new UserMeta;
            $newMeta->user_id = $user_id;
            $newMeta->waitingProducts = [['productID'=>$product_id, 'added'=>\Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'))]];
            $newMeta->save();
        } else {

            UserMeta::updateAll(
                ['$addToSet' => ['waitingProducts' => ['productID'=>$product_id, 'added'=>\Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'))]]],
                ['user_id' => $user_id],
                ['upsert'=>true]);



        }
    }
//...
}