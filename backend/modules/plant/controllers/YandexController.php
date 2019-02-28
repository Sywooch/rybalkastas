<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 16.05.2016
 * Time: 8:06
 */

namespace backend\modules\plant\controllers;

use common\models\SCProducts;
use yii\web\Controller;
use common\models\SCCategories;
use common\models\UserActivity;
use common\models\UserNotifications;

class YandexController extends Controller
{
    public function actionIndex(){
        ini_set('memory_limit', '16G');
        if(isset($_POST['CheckProduct'])){
            foreach ($_POST['CheckProduct'] as $k=>$v){
                if($v <> 1)continue;
                $model = SCProducts::findOne($k);
                $model->upload2market = 0;
                if(!$model->save(false)){
                    print_r($model->getErrors());
                }
            }
        }
        $model = SCProducts::find()->where("upload2market = 1")->orderBy("name_ru")->all();
        return $this->render('index', ['model'=>$model]);
    }

    public function actionLoad(){
        $rootCats = SCCategories::find()->where("parent = 1")->orderBy('main_sort')->all();
        return $this->render('load', ['rootCats'=>$rootCats]);
    }

    public function actionApply(){
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

        $products = SCProducts::find()->where(['in', 'productiD', $prdar])->all();

        return $this->render('apply', ['products'=>$products]);
    }

    public function actionSet(){
        ini_set('memory_limit', '-1');

        $prds = $_POST['products'];
        $prdar = array();
        foreach($prds as $p){
            $prdar[] = $p;
        }

        $products = SCProducts::find()->where(['in', 'productID', $prdar])->all();
        $productStr = '';
        foreach($products as $p){
            $p->upload2market = 1;
            $p->save(false);
            $log[] = "Выгружен в маркет: $p->name_ru";
            $productStr .= "<b>$p->name_ru</b><br>";
            $log[] = "____________________";
        }

        $act = new UserActivity;
        $act->putCustom("Выгрузил в Yandex маркет ".count($products)." позиций: $productStr");
        $notify = new UserNotifications;
        $notify->putMassNotify(\Yii::$app->user->id, "Установил типы товаров для ".count($products)." позиций.");
        return $this->render('set', ['log'=>$log]);
    }
}