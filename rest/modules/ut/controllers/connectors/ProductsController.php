<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 04.07.2018
 * Time: 13:25
 */

namespace rest\modules\ut\controllers\connectors;

use common\models\mongout\Products;
use rest\modules\ut\components\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class ProductsController extends Controller {

    public function actionReceive()
    {
        $product = json_decode($_POST['data']);
        $file = '/var/www/html/rest/modules/ut/messages/log.txt';
        \Yii::trace($_POST['data'], 'testing');
        $data = Json::decode($_POST['data']);
        $model = Products::findOne(['link'=>$data['link']]);
        if(empty($data['provider'])) $data['provider'] = [];
        if(empty($model)){
            $model = new Products();
            $model->link = $data['link'];
        }

        foreach($model->fillable() as $key){
            $model->{$key} = $data[$key];
        }

        $model->stock = $data['stock'];
        $model->reserved = $data['reserved'];
        $provider = [];
        $full_stock = 0;
        $full_reserved = 0;
        $full_provider = 0;
        foreach($data['stock'] as $stock){
            $full_stock += $stock['count'];
        }
        foreach($data['provider'] as $stockp){
            $full_provider += $stockp['count'];
            $provider[] = [
                'link'=>$stockp['provider_link'],
                'count'=>$stockp['count'],
            ];
        }
        foreach($data['reserved'] as $reserved){
            $full_reserved += $reserved['count'];
        }

        $model->stock_full = $full_stock;
        $model->reserved_full = $full_reserved;
        $model->provider_full = $full_provider;
        $model->stock_provider = $provider;

        $model->save();



        /*$stock = json_decode($_POST['stock']);

        */
    }

    public function actionReceivePartner(){
        $data = Json::decode($_POST['data']);
        $link = $data['link'];
        $partner = $data['partner'];
        $price = $data['price'];
        $model = Products::findOne(['link'=>$link]);
        if(empty($model)) return;
        $model->partner_purchase = [
            'partner_link'=>$partner,
            'price'=>$price
        ];
        $model->save();
    }

    public function actionByPartner(){
        $data = Json::decode($_POST['data']);
        $link = $data['link'];
        $partner = $data['partner'];
        $quantity = $data['count'];

        $model = Products::find()->where(['link'=>$link])->one();
        if(empty($model)) return;
        $stock_provider = $model->stock_provider;
        if(!is_array($stock_provider)) $stock_provider = [];
        $needed_key = -1;
        foreach($stock_provider as $k=>$v){
            if($v['link'] == $link) $needed_key = $k;
        }

        if($needed_key === -1){
            $stock_provider[] = [
                'link'=>$link,
                'count'=>$quantity
            ];
        } else {
            $stock_provider[$needed_key]['quantity'] = $quantity;
        }

        $model->stock_provider = $stock_provider;
        $model->save();
    }

    public function actionReceiveFullPartners(){
        $xml = $_POST['data'];
        file_put_contents('/var/www/html/uploads/data.xml', $xml);
    }
}
