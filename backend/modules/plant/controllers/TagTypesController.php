<?php

namespace backend\modules\plant\controllers;

use common\models\SCProductOptionsCategoryes;
use common\models\SCProductOptionsValues;
use common\models\SCProducts;
use yii\web\Controller;
use common\models\SCCategories;
use common\models\UserActivity;
use common\models\UserNotifications;

class TagTypesController extends Controller
{
    public function actionIndex()
    {
        $tags = SCCategories::find()->select('tags')->asArray()->all();
        $model = array();
        foreach($tags as $t){
            if($t['tags'] == '')continue;
            if (substr($t['tags'], 0, 1) === ',') {
                $t['tags'] = trim($t['tags'],',');
            }
            if (strpos($t['tags'],',') !== false) {
                foreach(explode(',', $t['tags']) as $e){
                    $model[] = $e;
                }
            } else {
                $model[] = $t['tags'];
            }


        }
        $model = array_unique($model);
        sort($model, SORT_FLAG_CASE);
        return $this->render('index', ['model'=>$model]);
    }

    public function actionStep11(){
        if(!isset($_POST['tag']))$this->redirect(['index']);
        $tag = $_POST['tag'];
        $model = SCProductOptionsCategoryes::find()->orderBy("category_name_ru")->all();
        return $this->render('step11', ['model'=>$model, 'tag'=>$tag]);
    }

    public function actionStep2()
    {
        if(!isset($_POST['tag']))$this->redirect(['index']);
        if(!isset($_POST['attrCat']))$this->redirect(['index']);
        $tag = $_POST['tag'];
        $cat = $_POST['attrCat'];
        $cat = SCProductOptionsCategoryes::find()->where("categoryID = $cat")->one();

        $cats = SCCategories::find()->where(['like', 'tags', $tag])->all();


        return $this->render('step2', ['model'=>$cats, 'tag'=>$tag, 'cat'=>$cat]);

        //print_r($model);
    }



    public function actionStep3()
    {
        if(!isset($_POST['tag']))$this->redirect(['index']);
        if(!isset($_POST['attrCat']))$this->redirect(['index']);
        $cat = $_POST['attrCat'];
        $cat = SCProductOptionsCategoryes::find()->where("categoryID = $cat")->one();
        $tag = $_POST['tag'];

        $cats = $_POST['connect'];
        $hasSelected = false;
        $catsar = array();
        foreach($cats as $k=>$v){
            if($v == 0)continue;
            $catsar[] = $k;
            $hasSelected = true;
        }

        if(!$hasSelected)$this->redirect(['index']);

        $products = SCProducts::find()->where(['in', 'categoryID', $catsar])->andWhere("attr_cat = ".$_POST['attrCat'])->all();

        return $this->render('step3', ['model'=>$cats, 'tag'=>$tag, 'cat'=>$cat, 'products'=>$products]);
    }

    public function actionStep4()
    {
        if(!isset($_POST['attrCat']))$this->redirect(['index']);
        if(!isset($_POST['tag']))$this->redirect(['index']);
        if(!isset($_POST['optionToTag']))$this->redirect(['index']);
        $cat = $_POST['attrCat'];
        $cat = SCProductOptionsCategoryes::find()->where("categoryID = $cat")->one();
        $option = $_POST['optionToTag'];
        $prds = $_POST['products'];
        $prdar = array();
        $tag = $_POST['tag'];
        foreach($prds as $p){
            $prdar[] = $p;
        }
        $attrs = SCProductOptionsValues::find()->where(['in', 'productiD', $prdar])->andWhere("option_value_ru <> ''")->groupBy("optionID")->all();
        $products = SCProducts::find()->where(['in', 'productID', $prdar])->all();

        $log = array();

        foreach($products as $prd){
            $model = SCProductOptionsValues::find()->where("optionID = $option AND productID = $prd->productID")->one();
            if(empty($model)){
                $model = new SCProductOptionsValues;
                $model->optionID = $option;
                $model->productID = $prd->productID;
                $model->option_type = 0;

                $log[] = "В товаре $prd->name_ru отсутствовало значение атрибута $cat->category_name_ru... Значение установлено";
            } else {
                $log[] = "В товаре $prd->name_ru уже имелось значение атрибута $cat->category_name_ru... Значение заменено";
            }
            $newVal = $_POST['tag'];
            $char=mb_strtoupper(substr($newVal,0,2),"utf-8"); // это первый символ
            $newVal[0]=$char[0];
            $newVal[1]=$char[1];

            $model->option_value_ru = $newVal;
            $model->save();
        }

        return $this->render('step4', ['log'=>$log]);
    }

    public function actionFinish(){
        $cat = $_POST['attrCat'];
        $cat = SCProductOptionsCategoryes::find()->where("categoryID = $cat")->one();

        $log = array();

        $prds = $_POST['products'];
        $prdar = array();
        foreach($prds as $p){
            $prdar[] = $p;
        }
        $products = SCProducts::find()->where(['in', 'productID', $prdar])->all();
        $productStr = '';
        foreach($products as $p){
            $p->attr_cat = $cat->categoryID;
            $p->save(false);
            $log[] = "Установлен тип на продукт $p->name_ru";
            if(isset($_POST['reconnect'])){
                $connectData = $_POST['reconnect'];
                foreach($connectData as $d){
                    $con = explode('|', $d);
                    $old = $con[0];
                    $new = $con[1];
                    if($old==$new){
                        $log[] = "Атрибут $new совпал со старым. Пропуск.";
                        continue;
                    }
                    $checkVal = SCProductOptionsValues::find()->where("optionID = $new AND productID = $p->productID")->one();
                    if(!empty($checkVal)){
                        $log[] = "Атрибут $new уже существует, но пуст. Удаляем.";
                        if(empty($checkVal->option_value_ru)){
                            $checkVal->delete();
                        }

                    }

                    $optionVal = SCProductOptionsValues::find()->where("optionID = $old AND productID = $p->productID AND option_value_ru <> ''")->one();
                    if(!empty($optionVal)){
                        $optionVal->optionID = $new;
                        $optionVal->save(false);
                    }
                }
            }
            $productStr .= "<b>$p->name_ru</b><br>";
            $log[] = "____________________";
        }




        $act = new UserActivity;
        $act->putCustom("Установил типы товаров для ".count($products)." позиций: $productStr");
        $notify = new UserNotifications;
        $notify->putMassNotify(\Yii::$app->user->id, "Установил типы товаров для ".count($products)." позиций.");
        return $this->render('finish', ['log'=>$log]);
    }
}
