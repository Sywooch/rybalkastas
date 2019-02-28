<?php

namespace backend\controllers;

use common\models\SCProductHighlighted;
use common\models\SCProducts;
use common\models\SCSpecials;
use common\models\SCSpecialsSlider;
use common\models\UserNotifications;
use Yii;
use common\models\SCCategories;
use common\models\SCCategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * CategoriesController implements the CRUD actions for SCCategories model.
 */
class ListsController extends Controller
{

    public function actionHighlight(){

        if(isset($_POST['do_resort'])){
            foreach($_POST['resort'] as $k=>$v){
                //echo 'lol';
                $model = SCProductHighlighted::find()->where("product_id = $k")->one();
                $model->sort_order = $v;
                $model->save(false);
                //return true;
            }
        }

        $list = SCProductHighlighted::find()->orderBy("sort_order")->all();
        $model = $data = SCProducts::find()
            ->select(['name_ru as value', 'name_ru as  label','productID as id'])
            ->asArray()
            ->all();
        return $this->render("highlight", ["model"=>$model, "list"=>$list]);
    }

    public function actionLoadProductList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = Yii::$app->db_rs->createCommand("SELECT productID as id, name_ru as text FROM SC_products WHERE (name_ru LIKE \"%$q%\" OR product_code LIKE \"%$q%\")")->queryAll();

            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => SCProducts::find($id)->name];
        }
        return $out;
    }

    public function actionInsertHighlighted(){
        $id = $_POST['id'];
        $model = new SCProductHighlighted();
        $model->product_id = $id;
        $model->sort_order = SCProductHighlighted::find()->max("sort_order") + 1;
        if($model->save()){
            $list = SCProductHighlighted::find()->orderBy("sort_order")->all();
            return $this->renderAjax("chunks/_highlight_list", ["list"=>$list]);
        }
    }

    public function actionDeleteHighlighted(){
        $id = $_POST['id'];
        $model = SCProductHighlighted::find()->where("product_id = $id")->one();
        if($model->delete()){
            $list = SCProductHighlighted::find()->orderBy("sort_order")->all();
            return $this->renderAjax("chunks/_highlight_list", ["list"=>$list]);
        }
    }

    //***********************************************************//

    public function actionSpecials(){

        if(isset($_POST['do_resort'])){
            foreach($_POST['resort'] as $k=>$v){
                //echo 'lol';
                if(!empty($model)){
                    $model = SCSpecials::find()->where("productID = $k")->one();
                    $model->sort_order =
                        $v;
                    $model->save(false);
                }
                //return true;
            }
        }

        $remspecials = SCSpecials::find()->orderBy("sort_order")->all();
        foreach ($remspecials as $rem){
            if(empty($rem->product) || $rem->product->list_price == 0  ){
                $rem->delete();
            }
        }

        $list = SCSpecials::find()->orderBy("sort_order")->all();
        $model = $data = SCProducts::find()
            ->select(['name_ru as value', 'name_ru as  label','productID as id'])
            ->asArray()
            ->all();

        $allSpecs = SCProducts::find()->where("list_price > Price AND list_price <> 0")->orderBy("name_ru ASC")->all();
        return $this->render("special", ["model"=>$model, "list"=>$list, "specials"=>$allSpecs]);
    }

    public function actionLoadSpecialList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = Yii::$app->db_rs->createCommand("SELECT SC_specials.productID as id, SC_products.name_ru as text FROM SC_specials INNER JOIN SC_products ON SC_specials.productID = SC_products.productID WHERE (name_ru LIKE \"%$q%\" OR product_code LIKE \"%$q%\")")->queryAll();

            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => SCProducts::find($id)->name];
        }
        return $out;
    }


    public function actionInsertSpecials(){
        $id = $_POST['id'];
        $model = new SCSpecials();
        $model->productID = $id;
        $model->sort_order = SCSpecials::find()->max("sort_order") + 1;
        if($model->save()){
            $list = SCSpecials::find()->orderBy("sort_order")->all();
            return $this->renderAjax("chunks/_special_list", ["list"=>$list]);
        }
    }

    public function actionInsertSpecialsAll(){
        if(isset($_POST['all'])){
            $model = SCProducts::find()->where("list_price > Price")->all();

            foreach($model as $m){
                $modelx = new SCSpecials();
                $modelx->productID = $m->productID;
                $modelx->sort_order = SCSpecials::find()->max("sort_order") + 1;
                $modelx->save();
            }
        }
        $list = SCSpecials::find()->orderBy("sort_order")->all();
        return $this->renderAjax("chunks/_special_list", ["list"=>$list]);
    }

    public function actionDeleteSpecials(){
        $id = $_POST['id'];
        $model = SCSpecials::find()->where("productID = $id")->one();
        if($model->delete()){
            $list = SCSpecials::find()->orderBy("sort_order")->all();
            return $this->renderAjax("chunks/_special_list", ["list"=>$list]);
        }
    }

    public function actionClearSpecials()
    {
        $model = SCSpecials::find()->all();
        foreach($model as $m){
            $m->delete();
        }
        $this->redirect(["/lists/specials"]);
    }

    //***********************************************************//

    public function actionSpecialsSlider(){
        //return 'asd';
        if(isset($_POST['do_resort'])){
            foreach($_POST['resort'] as $k=>$v){
                echo 'lol';
                $model = SCSpecialsSlider::find()->where("product_id = $k")->one();
                $model->sort_order = $v;
                $model->save(false);
                //return true;
            }
        }
        $remsliders = SCSpecialsSlider::find()->orderBy("sort_order")->all();
        foreach ($remsliders as $rem){
            if($rem->product->list_price == 0){
                $rem->delete();
            }
        }

        $list = SCSpecialsSlider::find()->orderBy("sort_order")->all();
        $model = SCSpecials::find()->asArray()->all();
        $specials = SCSpecials::find()->all();
        return $this->render("specialslider", ["model"=>$model, "list"=>$list, "specials"=>$specials]);
    }


    public function actionInsertSpecialsSlider(){
        $id = $_POST['id'];
        $model = new SCSpecialsSlider();
        $model->product_id = $id;
        $model->sort_order = SCSpecialsSlider::find()->max("sort_order") + 1;
        if($model->save()){
            $list = SCSpecialsSlider::find()->orderBy("sort_order")->all();
            return $this->renderAjax("chunks/_slider_list", ["list"=>$list]);
        }
    }

    public function actionDeleteSpecialsSlider(){
        $id = $_POST['id'];
        $model = SCSpecialsSlider::find()->where("product_id = $id")->one();
        if($model->delete()){
            $list = SCSpecialsSlider::find()->orderBy("sort_order")->all();
            return $this->renderAjax("chunks/_slider_list", ["list"=>$list]);
        }
    }

    public function actionFillSpecials()
    {
        $products = SCProducts::find()->select(['productID'])->where("list_price > Price")->all();
        $i = 1;
        foreach ($products as $product){
            $m = new SCSpecials;
            $m->productID = $product->productID;
            $m->sort_order = $i;
            $m->save();
            $i++;
        }

        echo 'done';
    }
}