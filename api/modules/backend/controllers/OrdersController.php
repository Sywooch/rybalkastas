<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 01.02.2019
 * Time: 11:28
 */

namespace api\modules\backend\controllers;


use common\models\SCCustomers;
use common\models\SCOrders;
use yii\helpers\Json;
use yii\rest\Controller;

class OrdersController extends \api\components\Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
            ]
        ]);
    }

    public function actionIndex($perpage = 30, $page = 1, $filters = null){
        ob_start('ob_gzhandler');
        $offset = $perpage * $page - ($perpage - ($perpage - 1));
        $needed = SCOrders::find()->offset($offset)->orderBy(['orderID'=>SORT_DESC]);

        $filters = Json::decode($filters);
        foreach($filters as $field=>$filter){
            if(empty($filter)) continue;
            $needed = $needed->andWhere(['like', $field, $filter]);
        }
        $count = $needed->count();
        $needed = $needed->limit($perpage)->all();
        $res = [];
        foreach($needed as $order){
            $manager = null;
            if(empty($order->manager_id)){
                $manager = '(Не найден)';
            } else {
                if(empty(\common\models\SCExperts::findOne($order->manager_id))) $manager = "Не найден";
                $manager = \common\models\SCExperts::findOne($order->manager_id)->expert_fullname;
            }

            $source = null;
            if(empty($order->source_ref)){
                $source =  'Обычный';
            } elseif($order->source_ref == "spdir"){
                $source =  'Direct';
            } elseif($order->source_ref == "dir"){
                $source =  'YDirect';
            } elseif($order->source_ref == "ymrkt"){
                $source =  'Market';
            } elseif($order->source_ref == "rf"){
                $source =  'RosFishing';
            }else {
                $source =  '<b class="text-danger">Неизвестно</b>';
            }

            $res[] = [
                'id'=>$order->orderID,
                'id_1c'=>$order->id_1c,
                'datetime'=>strtotime($order->order_time),
                'customer'=>$order->customer,
                'customerID'=>$order->customerID,
                'sum'=>$order->order_amount,
                'delivery'=>$order->shipping_type,
                'payment'=>$order->payment_type,
                'status'=>\common\models\SCOrderStatus::find()->where("statusID = $order->statusID")->one()->status_name_ru,
                'manager'=>$manager,
                'managerID'=>$order->manager_id,
                'source'=>$source
            ];
        }


        return ['count'=>$count, 'orders'=>$res];
    }

    public function actionOrder($id){
        $order = SCOrders::findOne($id);
        $res = $order->toArray();
        $res['status'] = $order->getStatus();
        $res['products'] = $order->products;
        return $res;
    }

    public function actionByUser($id, $email){
        $customer = SCCustomers::findOne($id);
        $q = SCOrders::find()->where(['customerID'=>$customer->getPrimaryKey()])->orWhere(['customer_email'=>$email]);
        $count = $q->count();
        $orders = $q->all();



        $res = [];

        foreach($orders as $order){
            $manager = null;
            if(empty($order->manager_id)){
                $manager = '(Не найден)';
            } else {
                if(empty(\common\models\SCExperts::findOne($order->manager_id))) $manager = "Не найден";
                $manager = \common\models\SCExperts::findOne($order->manager_id)->expert_fullname;
            }

            $source = null;
            if(empty($order->source_ref)){
                $source =  'Обычный';
            } elseif($order->source_ref == "spdir"){
                $source =  'Direct';
            } elseif($order->source_ref == "dir"){
                $source =  'YDirect';
            } elseif($order->source_ref == "ymrkt"){
                $source =  'Market';
            } elseif($order->source_ref == "rf"){
                $source =  'RosFishing';
            }else {
                $source =  '<b class="text-danger">Неизвестно</b>';
            }

            $res[] = [
                'id'=>$order->orderID,
                'id_1c'=>$order->id_1c,
                'datetime'=>strtotime($order->order_time),
                'customer'=>$order->customer,
                'customerID'=>$order->customerID,
                'sum'=>$order->order_amount,
                'delivery'=>$order->shipping_type,
                'payment'=>$order->payment_type,
                'status'=>\common\models\SCOrderStatus::find()->where("statusID = $order->statusID")->one()->status_name_ru,
                'manager'=>$manager,
                'managerID'=>$order->manager_id,
                'source'=>$source
            ];
        }

        return ['count'=>$count, 'orders'=>$res];
    }
}