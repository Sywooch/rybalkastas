<?php

namespace backend\modules\plant\controllers;

use common\models\SCProductOptionsCategoryes;
use common\models\SCProductOptionsValues;
use common\models\SCProducts;
use yii\web\Controller;
use common\models\SCCategories;
use common\models\UserActivity;
use common\models\UserNotifications;

class TypesController extends Controller
{
    public function actionIndex()
    {
        ini_set('max_input_vars', 100000);
        $model = SCProductOptionsCategoryes::find()->orderBy("category_name_ru")->all();
        return $this->render('index', ['model'=>$model]);
    }

    public function actionStep2()
    {
        ini_set('max_input_vars', 100000);
        if(!isset($_POST['attrCat']))$this->redirect(['index']);
        $cat = $_POST['attrCat'];
        $cat = SCProductOptionsCategoryes::find()->where("categoryID = $cat")->one();

        $rootCats = SCCategories::find()->where("parent = 1")->orderBy('main_sort')->all();

        return $this->render('step2', ['rootCats'=>$rootCats, 'cat'=>$cat]);
    }

    public function actionStep3()
    {
        ini_set('max_input_vars', 100000);
        if(!isset($_POST['attrCat']))$this->redirect(['index']);
        $cats = $_POST['connect'];
        $hasSelected = false;
        $catsar = array();
        foreach($cats as $k=>$v){
            if($v == 0)continue;
            $catsar[] = $k;
            $hasSelected = true;
        }


        if(!$hasSelected)$this->redirect(['index']);

        $cats = SCCategories::find()->where(['in', 'categoryID', $catsar])->all();
        $prdar = array();
        foreach($cats as $c){
            foreach($c->products as $p){
                $prdar[] = $p->productID;
            }
        }

        $cat = $_POST['attrCat'];
        $cat = SCProductOptionsCategoryes::find()->where("categoryID = $cat")->one();

        $products = SCProducts::find()->where(['in', 'productiD', $prdar])->all();
        $attrs = SCProductOptionsValues::find()->where(['in', 'productiD', $prdar])->andWhere("option_value_ru <> ''")->groupBy("optionID")->all();

        return $this->render('step3', ['products'=>$products, 'cat'=>$cat, 'attrs'=>$attrs]);
    }

    public function actionStep4()
    {
        ini_set('max_input_vars', 100000);
        if(!isset($_POST['attrCat']))$this->redirect(['index']);
        $cat = $_POST['attrCat'];
        $cat = SCProductOptionsCategoryes::find()->where("categoryID = $cat")->one();

        $prds = $_POST['products'];
        print_r(count($prds));
        $prdar = array();
        foreach($prds as $p){
            $prdar[] = $p;
        }
        $attrs = SCProductOptionsValues::find()->where(['in', 'productiD', $prdar])->groupBy("optionID")->all();
        $products = SCProducts::find()->where(['in', 'productID', $prdar])->all();

        return $this->render('step4', ['cat'=>$cat, 'products'=>$products, 'attrs'=>$attrs]);
    }

    public function actionFinish(){
        ini_set('max_input_vars', 100000);
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
                        $todel = SCProductOptionsValues::find()->where("optionID = $new AND productID = $p->productID")->one();
                        if(!empty($todel))$todel->delete();
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
