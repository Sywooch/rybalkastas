<?php
/**
 * Created by PhpStorm.
 * User: tt
 * Date: 22.11.2018
 * Time: 22:45
 */

namespace console\controllers;


use common\models\SCCategories;
use common\models\SCProducts;
use common\models\SCProductsExtraPrice;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ReloadController extends Controller
{
    public function actionLoad(){
        $ar = SCProductsExtraPrice::find()->all();
        $madeCats = [];
        $c = count($ar);
        $i = 0;
        foreach($ar as $pr){
            $i++;
            echo $i.'/'.$c.PHP_EOL;
            $pr = SCProducts::findOne($pr->productID);
            if(empty($pr)) continue;
            if(in_array($pr->categoryID, $madeCats)) continue;
            if(!$pr->categoryID !== 103508) continue;
            echo 'here';die;
            $cat = $pr->getCategory();
            $ids = ArrayHelper::getColumn($cat->path,'id');
            $innerCats = SCCategories::find()->where(['in','categoryID',$ids])->all();
            $innerCats[] = $cat;
            foreach ($innerCats as $icat){
                $meta = $icat->meta_data;
                $metaAr = Json::decode($meta);
                $metaAr['hasAction'] = 1;
                $icat->meta_data = Json::encode($metaAr);
                if(!$cat->save()){
                    print_r($icat->getErrors());die;
                }
                $madeCats[] = $icat->categoryID;
            }
        }
    }

    public function actionReload(){
        $cats = SCCategories::find()->orderBy(['categoryID'=>SORT_DESC])->all();
        $c = count($cats);
        $i = 0;
        foreach($cats as $cat){
            $i++;
            echo $i.'/'.$c.PHP_EOL;
            $cat->generateMeta();
        }
    }

    public function actionResetActions(){
        $cats = SCCategories::find()->all();
        $c = count($cats);
        $i = 0;
        foreach($cats as $cat){
            $i++;
            echo $i.'/'.$c.PHP_EOL;
            if(empty($cat->meta_data)) continue;
            echo '1'.PHP_EOL;
            $meta = Json::decode($cat->meta_data);
            echo '2'.PHP_EOL;
            if($meta['minListPrice'] > $meta['minPrice']){
                $meta['hasAction'] = 1;
            } else {
                $meta['hasAction'] = 0;
            }
            echo '3'.PHP_EOL;

            $cat->meta_data = Json::encode($meta);
            echo '4'.PHP_EOL;
            $cat->save(false);
            echo '5'.PHP_EOL;
        }
    }
}