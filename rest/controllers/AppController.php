<?php

namespace rest\controllers;

use common\models\mongout\Barcodes;
use common\models\SCCategories;
use common\models\SCCertificates;
use common\models\SCOrders;
use common\models\SCOrderStatus;
use common\models\SCProducts;
use Yii;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\rest\Controller;


class AppController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS', 'POST', 'PUT'],
                'Access-Control-Allow-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept', 'Authorization'],
                'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => ['Authorization'],
            ]
        ];

        return $behaviors;
    }

    public function actionGetTree()
    {
        $model = \common\models\SCCategories::find()->select(['name_ru', 'categoryID'])->where(['parent' => 1])->andWhere('hidden <> 1')->orderBy('sort_order ASC')->all();
        return $model;
    }

    public function actionMainCatalog($id = 1)
    {
        $model = \common\models\SCCategories::find()->where(['parent' => $id])->andWhere('hidden <> 1')->orderBy('main_sort ASC')->orderBy('sort_order ASC')->all();
        return $model;
    }

    public function actionCategory($id)
    {
        $cat = SCCategories::findOne($id);
        $ar = $cat->toArray();
        $ar['path'] = $cat->path;

        $menutypes = ['0' => 'category', '1' => 'table', '2' => 'thumbnails', '3' => 'clothes', '4' => 'table', '5' => 'thumbnail_tabs', '6' => 'table'];
        if ($cat->menutype == 0) {
            return ['type' => 'category', 'data' => $ar, 'products'=>[]];
        } else {
            $products = SCProducts::find()->with('pics')->where(['categoryID'=>$id])->asArray()->all();
            return ['type' => $menutypes[$cat->menutype], 'data' => $ar, 'products'=>$products];
        }
    }

    public function actionProduct($id){
        $prd = SCProducts::find()->with('pics')->where(['productID'=>$id])->one();
        $product = $prd->toArray();
        $product['attrs'] = $prd->attrsNext;
        $product['pics'] = $prd->pics;
        return $product;
    }

    public function actionBarcode($code){
        $barcode = Barcodes::find()->where(['barcode'=>(string)$code])->one();
        $product = SCProducts::find()->where(['product_code'=>$barcode['product_id_1c']])->one();
        return ['product_id'=>$product->productID, 'category_id'=>$product->categoryID];
    }
}