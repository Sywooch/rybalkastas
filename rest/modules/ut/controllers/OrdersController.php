<?php

namespace rest\modules\ut\controllers;

use common\models\mongout\Customers;
use common\models\mongout\Lists;
use common\models\mongout\Orders;
use common\models\mongout\Products;
use common\models\mongout\Sales;
use common\models\mongout\Users;
use common\models\mongout\Warehouses;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use \rest\modules\ut\components\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Default controller for the `ut` module
 */
class OrdersController extends \rest\modules\ut\components\Controller

{
    public function actionIndex(){
        $model = Orders::find()->with('customer')->with('user')->with('status')->select(['link','payment_type', 'shipping_type', 'id_1c', 'site_id', 'sum', 'user_link','customer_link', 'class', 'status', 'created_at'])->orderBy(['created_at'=>SORT_DESC])->limit(200)->asArray()->all();
        /*foreach($model as &$m){
            $m['user'] = Users::findOne(['link'=>$m['user_link']]);
        }*/
        return $model;
    }

    public function actionOrder($link){
        $model = Orders::find()->with('user')->with('customer')->where(['link'=>$link])->one();
        $order = $model->toArray();
        foreach($order['products'] as &$product){
            $product['model'] = Products::findOne($product['link'])->toArray();
        }
        return $model;
    }

    public function actionPoint(){
        $partners = Json::decode($_POST['partners']);
        $warehouses = Json::decode($_POST['warehouses']);
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];


        $whObjects = Warehouses::find()->where(['in', 'link', ArrayHelper::getColumn($warehouses,'link')])->asArray()->all();
        $partner_ids = [];
        $orderPoints = Lists::findOne(new ObjectId('5bbdb1436526526f30060da2'));

        $provAr = [];
        foreach($partners as $partner){
            $provAr[] = ['stock_provider_obj.'.$partner['link'] => ['$exists'=>true]];
        }
        $productsByProviders = Products::find()->where(['$or'=>$provAr])->asArray()->all();

        $prdAr = [];
        $prdIds = [];
        foreach($productsByProviders as $k=>$product){
            $hasStock = false;
            foreach($partners as $partner){
                if(empty($product['stock_provider_obj'][$partner['link']])) continue;
                if($product['stock_provider_obj'][$partner['link']] <= 0) continue;
                if($product['stock_provider_obj'][$partner['link']] > 0) $hasStock = true;
            }
            if(!$hasStock) {
                unset($productsByProviders[$k]);
                continue;
            }
            $prdAr[] = ['items' => ['$elemMatch'=>['id'=>$product['link']]]];
            $prdIds[] = $product['link'];
            foreach($product['stock_provider_obj'] as $k=>$v){
                $partner_ids[] = $k;
            }
        }
        $pObjects = Customers::find()->where(['in', 'link', $partner_ids])->asArray()->all();
        $partnerObjects = [];
        foreach($pObjects as $pobject){
            $partnerObjects[$pobject['link']] = $pobject;
        }
        //array_unique($prdIds);
        $salesByWarehouses = [];
        foreach(ArrayHelper::getColumn($warehouses,'link') as $whLink){
            if(empty($prdAr)){
                $salesByWarehouses[$whLink] = 0;
                continue;
            }

            $sales = Sales::find()
                ->where(['between', 'date', new UTCDateTime(strtotime($dateFrom)*1000), new UTCDateTime(strtotime($dateTo)*1000)])
                ->andWhere(['is_retail'=>true])
                ->andWhere(['warehouse'=>$whLink])
                ->andWhere(['$or'=>$prdAr])
                ->asArray()->all();
            $salesByProducts = [];
            foreach($prdIds as $pItem){
                $count = 0;
                foreach($sales as $sale){
                    foreach($sale['items'] as $sold){
                        if($sold['id'] == $pItem) $count = $count+$sold['quantity'];
                    }
                }
                $salesByProducts[$pItem] = $count;
            }
            $salesByWarehouses[$whLink] = $salesByProducts;
        }




        return ['table'=>$productsByProviders, 'order_points'=>$orderPoints['data'], 'sales'=>$salesByWarehouses, 'partners'=>$partnerObjects];
    }

    public function actionSend(){
        $partner_id = $_POST['partner'];
        $payload = Json::decode($_POST['payload']);
        $client = new \SoapClient('http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl',
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis',
                'cache_wsdl' => WSDL_CACHE_NONE,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                'location' => str_replace('?wsdl', '', $url)

            ]);

        foreach($payload as $wh=>$items){
            $itemsToSend = [];

            foreach($items as $item){
                if($item['order'] <= 0) continue;
                $itemsToSend[] = [
                    'id_1c'=>$item['code'],
                    'count'=>$item['order'],
                ];
            }

            $client->insertPartnerOrder(['warehouse'=>$wh, 'partner'=>$partner_id, 'items'=>Json::encode($itemsToSend)]);
        }

    }
}
