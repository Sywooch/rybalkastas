<?php

namespace console\controllers;

use common\components\UtUploader;
use common\models\SCCategories;
use common\models\SCExperts;
use common\models\SCNewsTable;
use common\models\SCOrders;
use common\models\SCOrderStatus;
use common\models\SCProducts;
use common\models\CartElement;
use yii\console\Controller;
use \Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\Application;
use yii\web\User;

class ArnsteinController extends Controller
{
    public function actionRemAll()
    {
        while (!empty(array_slice(scandir('/mnt/images/img/cacheToRemove/cathead'), 2)))
        {
            $this->actionRemAll();
            sleep(1);
        }
    }

    public function actionRemOld()
    {
        $dir = '/mnt/images/img/cacheToRemove/common';
        $data = array_diff(scandir($dir), ['.','..']);
        //print_r($data);
        while (!empty($data)) {
            $data = array_diff(scandir($dir), ['.','..']);
            $data2 = array_diff(scandir($dir . '/' . array_values($data)[0]), ['.','..']);
            //print_r($data2);
            $data3 = array_diff(scandir($dir . '/' . array_values($data)[0] . '/' . array_values($data2)[0]), ['.','..']);
            //print_r($data3);
            foreach ($data3 as $d) {
                if($d == '.' || $d == '..')continue;
                unlink($dir . '/' . array_values($data)[0] . '/' . array_values($data2)[0] . '/' . $d);
                echo $d . PHP_EOL;
            }
            @rmdir($dir . '/' . array_values($data)[0] . '/' . array_values($data2)[0]);
            @rmdir($dir . '/' . array_values($data)[0]);
            sleep(2);
        }
    }

    public function actionRecart()
    {
        $els = CartElement::find()->all();
        $count = count($els);
        $i = 0;
        foreach ($els as $e)
        {
            $i++;
            $product_price = SCProducts::find()->select(['Price'])->where(['productID'=>$e->item_id])->one();
            if(empty($product_price))continue;
            $e->price = $product_price->Price;
            $e->save();
            echo $i.'/'.$count.PHP_EOL;
        }
    }

    public function actionUpdateStatuses()
    {
        $statuses = SCOrderStatus::find()->all();
        $reverse = [];
        foreach ($statuses as $s){
            $reverse[$s->status_name_ru] = $s->statusID;
        }
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis',
                'cache_wsdl' => WSDL_CACHE_NONE,
            ]
        );

        $orders = SCOrders::find()->select(['orderID','statusID'])->where(['in','statusID',[2,3]])->orderBy(['orderID'=>SORT_DESC])->limit(10000)->all();
        $ids = ArrayHelper::getColumn($orders, 'orderID');
        $return = $client->getStatuses(['ids'=>Json::encode($ids)]);
        $data = Json::decode($return->return);
        $countData = count($data);
        $i = 0;
        foreach ($data as $d){
            $i++;
            if($reverse[$d['orderStatus']] == 3) {
                echo $i.'/'.$countData.' UNCHANGED'.PHP_EOL;
                continue;
            }
            $statusID = $reverse[$d['orderStatus']];
            $order = SCOrders::findOne($d['orderID']);
            $order->statusID = $statusID;
            $order->save(false);
            echo $i.'/'.$countData.' CHANGED'.PHP_EOL;
        }
    }

    public function actionMassInwork(){
        $model = SCOrders::find()->where('orderID > 123683')->all();
        foreach($model as $m){
            if($m->statusID <> 2) continue;
            $m->statusID = 3;
            $m->save();
        }
    }

    public function actionRefreshManagers()
    {
        $experts = SCExperts::find()->all();
        $reverse = [];
        foreach ($experts as $s){
            $reverse[Inflector::slug($s->{'1c_id'})] = $s->expert_id;
        }

        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis',
                'cache_wsdl' => WSDL_CACHE_NONE,
            ]
        );


        $orders = SCOrders::find()->select(['orderID', 'manager_id'])->where('manager_id IS NULL')->orderBy('RAND()')->limit(10000)->all();
        $ids = ArrayHelper::getColumn($orders, 'orderID');
        $return = $client->getManagers(['ids'=>Json::encode($ids)]);
        $data = Json::decode($return->return);
        $countData = count($data);
        $i = 0;
        foreach ($data as $d){
            if(empty($reverse[Inflector::slug($d['managerName'])])) continue;
            $i++;
            $expert_id = $reverse[Inflector::slug($d['managerName'])];
            $order = SCOrders::findOne($d['orderID']);
            $order->manager_id = $expert_id;
            $order->save(false);
            echo $i.'/'.$countData.' CHANGED'.PHP_EOL;
        }
    }

    public function actionSetNews()
    {
        $model = SCNewsTable::find()->all();
        foreach($model as $m){
            $m->created_at = strtotime($m->add_date);
            $m->updated_at = strtotime($m->add_date);
            if($m->published == 1){
                $m->published_at = strtotime($m->add_date);
            }
            $m->save();
        }
    }

}