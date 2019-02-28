<?php
namespace rest\controllers;

use common\models\SCCategories;
use common\models\SCCertificates;
use common\models\SCExperts;
use common\models\SCOrders;
use common\models\SCOrderStatus;
use common\models\SCProducts;
use common\models\SCProductsExtraPrice;
use Yii;
use yii\helpers\Json;
use yii\rest\Controller;


class SiteController extends Controller
{
    public function actionIndex()
    {
        return 123;
    }

    public function actionInf(){
        phpinfo();
    }

    public function actionChangeState()
    {
        $data = json_decode($_POST['data']);
        if(trim($data->orderStatus) == 'Новый'){
            return true;
        }
        //return $_POST['data'];
        $orderID = str_replace('BETA-', '', $data->orderID);
        $order = SCOrders::findOne($orderID);
        if(empty($order)) return true;
        $statusID = SCOrderStatus::find()->where(['status_name_ru'=>trim($data->orderStatus)])->one();
        if(empty($statusID)) return true;
        if(!empty($data->expert) && $data->expert <> " "){
            $expert_name = $data->expert;
            $expert_model = SCExperts::find()->where(['like','1c_id',trim($expert_name)])->one();
            if(!empty($expert_model)){
                $order->manager_id = $expert_model->expert_id;
            }
        }


        //$txt = "Статус заказа №$order->orderID изменен с $order->status на ".$data->orderStatus;
        //\Yii::$app->bot->sendMessage(-14068578, $txt);
        //\Yii::$app->bot->sendMessage(-14068578, print_r($_POST['data'], true));
        $order->statusID = $statusID->statusID;
        if(!$order->save(false)){
            \Yii::$app->bot->sendMessage(-14068578, print_r($_POST['data'], true));
        };
    }

    public function actionSetStock()
    {
        $data = json_decode($_POST['data']);
        $model = SCProducts::find()->select(['productID','product_code','in_stock','in_stock_provider'])->where(['product_code'=>$data->product_code])->one();
        if(!empty($model)){
            $stock = intval($data->in_stock);
            $provider = intval($data->in_stock_provider);
            $reserved = intval($data->in_stock_reserved);

            $fullStock = $stock + $provider;
            $actualStock = $fullStock - $reserved;
            if($actualStock < 0){
                $actualStock = 0;
                if(!empty($model->category->na_message)){
                    $model->category->na_message = null;
                }
            }
            if($fullStock == 0)$provider = 0;

            $model->in_stock = $actualStock;
            $model->in_stock_provider = $provider;
            $model->save(false);
        }

        return true;
    }

    public function actionSetStockBulk()
    {
        $datas = json_decode($_POST['data']);
        Yii::trace(count($datas));
        ini_set('max_execution_time', 65000);
        $multiQuery = '';
        foreach ($datas as $data){
            /*if($data->product_code == 'F0000075647'){
                \Yii::$app->bot->sendMessage(-14068578, "Выгружается: \"$data->product_code\"");
                \Yii::$app->bot->sendMessage(-14068578, Json::encode($data));
            }
            $model = SCProducts::find()->where(['product_code'=>$data->product_code])->one();
            if(!empty($model)){
                $stock = intval($data->in_stock);
                $provider = intval($data->in_stock_provider);
                $reserved = intval($data->in_stock_reserved);

                Yii::trace('running for '.$data->product_code);

                if(empty($provider))$provider = 0;

                $fullStock = $stock + $provider;
                $actualStock = $fullStock - $reserved;

                if($actualStock < 0){
                    $actualStock = 0;
                    if(!empty($model->category->na_message)){
                        $model->category->na_message = null;
                    }
                }
                if($fullStock == 0)$provider = 0;



                $model->in_stock = $actualStock;
                $model->in_stock_provider = $provider;

                if(!$model->save(false)){
                    \Yii::$app->bot->sendMessage(-14068578, "Товар не сохранен: \"$data->product_code\"");
                }
            } else {
                \Yii::$app->bot->sendMessage(-14068578, "Товар не найден на сайте: \"$data->product_code\"");
            }*/
            $stock = intval($data->in_stock);
            $provider = intval($data->in_stock_provider);
            $reserved = intval($data->in_stock_reserved);
            if(empty($provider))$provider = 0;
            $fullStock = $stock + $provider;
            if($fullStock == 0)$provider = 0;
            $actualStock = $fullStock - $reserved;

            $multiQuery .= Yii::$app->db->createCommand()->update('SC_products', ['in_stock'=>$actualStock, 'in_stock_provider'=>$provider], ['product_code'=>$data->product_code])->rawSql.';'.PHP_EOL;
        }

        Yii::trace($multiQuery);
        //Yii::$app->db->createCommand($multiQuery)->execute();
        $folder = Yii::getAlias('@frontend/sql/');
        file_put_contents($folder.time(), $multiQuery);
        return true;
        //\Yii::$app->bot->sendMessage(-14068578, "Выгружено позиций: ".count($datas));
    }

    public function actionSetPrices()
    {
        try {

            $data = json_decode($_POST['data']);
            $model = SCProducts::find()->where(['product_code'=>$data->product_code])->one();
            if(empty($model)){
                $msg = "Товар не найден на сайте: \"$data->product_code\"";
                return false;
            }
            $model->list_price = $data->price;
            $model->maxDiscount = $data->max_discount_percent;
            $model->discount_for_reg = $data->discount_for_reg == 'true'?1:0;


            $model->maxDiscount = $data->max_discount_percent;

            if($data->list_price_percent <= 0){
                $model->Price = $data->price;
            } else {
                $percent = $data->list_price_percent;
                $asterisk = 100-$percent;
                $model->Price = $data->price/100*$asterisk;
            }
            if(!$model->save(false)){
                \Yii::$app->bot->sendMessage(-14068578, $model->name_ru.' Не сохранен');
            }


            //$model->category->generateMetaInPath();


        } catch (\Exception $e) {
            \Yii::$app->bot->sendMessage(-14068578, $e->getTraceAsString());
        }


    }

    public function actionSetPricesBulk()
    {
        $datas = json_decode($_POST['data']);

        try {
            $multiQuery = '';
            foreach ($datas as $data){
                /*$model = SCProducts::find()->select(['product_code','productID','list_price','Price','maxDiscount'])->where(['product_code'=>$data->product_code])->one();
                if(empty($model))continue;*/

                $insert = [
                    'list_price'=>$data->price,
                    'Price'=>$data->price,
                    'maxDiscount'=>$data->max_discount_percent
                ];

                if($data->list_price_percent <= 0){
                    $insert['Price'] = $data->price;
                } else {
                    $percent = $data->list_price_percent;
                    $asterisk = 100-$percent;
                    $insert['Price'] = $data->price/100*$asterisk;
                }

                if(!empty($data->key)){
                    //continue;
                }

                $multiQuery .= Yii::$app->db->createCommand()->update('SC_products', ['Price'=>$insert['Price'],'list_price'=>$insert['list_price'],'maxDiscount'=>$insert['maxDiscount']], ['product_code'=>$data->product_code])->rawSql.';'.PHP_EOL;

            }
            Yii::trace($multiQuery);
            $folder = Yii::getAlias('@frontend/sql/');
            file_put_contents($folder.time(), $multiQuery);
            return true;
        } catch (\Exception $e) {
            \Yii::$app->bot->sendMessage(-14068578, $e->getTraceAsString());
        }
    }

    public function actionSetPayed()
    {
        $id = $_POST['id'];
        $order = SCOrders::find()->where(['orderID'=>$id])->orderBy('orderID DESC')->one();
        $order->payed = 1;
        if(!$order->save(false)){
            echo 123;
        }
        echo Json::encode($order);die;

    }

    public function actionBarcode($param)
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/plain');

        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';

        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis',
                'trace' =>true,
                'cache_wsdl' => 0,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                'location' => str_replace('?wsdl', '', $url)
            ]
        );
        $ar = $client->getBarcode(['code'=>$param]);
        $data = json_decode($ar->return);
        return $data->name.PHP_EOL.number_format($data->price,2).' руб.';
    }

    public function actionBarcodex($param)
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/plain');

        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis',
                'trace' =>true,
                'cache_wsdl' => 0,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                'location' => str_replace('?wsdl', '', $url)
            ]
        );
        $ar = $client->getBarcode(['code'=>$param]);
        $data = json_decode($ar->return);
        return $data->name.PHP_EOL.number_format($data->price,2).' руб.';
    }

    public function actionUploadCertificate()
    {
        $datas = json_decode($_POST['data']);
        $model = SCCertificates::find()->where(['certificateNumber'=>$datas['number']])->one();
        if(empty($model)){
            $model = new SCCertificates();
            $model->certificateNumber = $datas->number;
            $model->certificateRating = $datas->rating;
        }
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $model->certificateCode = $randomString;
        $model->certificateUsed = 0;
        $model->save();

        return $model->certificateCode;
    }


}