<?php

namespace rest\modules\ut\modules\order_point\controllers;

use common\models\mongout\Lists;
use common\models\mongout\Orders;
use common\models\mongout\Products;
use common\models\mongout\Warehouses;
use MongoDB\BSON\ObjectId;
use \rest\modules\ut\components\Controller;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Default controller for the `ut` module
 */
class DefaultController extends \rest\modules\ut\components\Controller
{

    public function actionIndex(){
        $order_points = Lists::findOne(['name'=>'order_point_points']);
        return ['order_points'=>$order_points['data']];
    }

    public function actionAdd($id){
        $model = Lists::findOne(['name'=>'order_point']);
        if(empty($model)){
            $model = new Lists();
            $model->name = 'order_point';
            $model->title = 'Точки заказа';
            $model->data = [];
            $model->save();
        }
        $ar = $model->data;
        $ar[] = $id;
        $ar = array_unique($ar);
        $model->data = $ar;
        $model->save();
    }

    public function actionGetProducts(){
        $model = Lists::findOne(['name'=>'order_point']);
        $ids = [];
        foreach($model['data'] as $id){
            $ids[] = new ObjectId($id);
        }
        $products = Products::find()->where(['in', '_id', $ids])->all();
        $products = array_reverse($products);
        $shop_links = Warehouses::mainWarehouses();
        return ['products'=>$products, 'shops'=>$shop_links];
    }

    public function actionSetPoint(){
        $data = Json::decode($_POST['data']);

        $model = Lists::findOne(['name'=>'order_point_points']);
        if(empty($model)){
            $model = new Lists();
            $model->name = 'order_point_points';
            $model->title = 'Точка заказа';
            $model->data = [];
        }

        $model->data = $data;
        $model->save();
    }
}
