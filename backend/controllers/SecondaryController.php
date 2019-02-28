<?php

namespace backend\controllers;

use common\models\SCSecondaryPages;
use common\models\SCSecondaryPagesContainers;
use common\models\SCSecondaryPagesLinks;
use Yii;
use common\models\SCCategories;
use common\models\SCParentalConnections;
use yii\web\UploadedFile;

class SecondaryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = SCSecondaryPages::find()->all();
        return $this->render('index', ['model'=>$model]);
    }

    public function actionCreate()
    {
        $model = new SCSecondaryPages();
        if ($model->load(Yii::$app->request->post())){
            if(!$model->save()){
                print_r($model->getErrors());die;
            }
            return $this->redirect(['item', 'id'=>$model->getPrimaryKey()]);
        }

        return $this->render('create', ['model'=>$model]);
    }

    public function actionItem($id, $tab = null)
    {
        $model = SCSecondaryPages::find()->where("id = $id")->one();
        $beforeHeadpirture = $model->head_image;
        $beforeBrandpirture = $model->link_image;


        if ($model->load(Yii::$app->request->post())){
            $hp_image = UploadedFile::getInstance($model, 'head_image');
            if(!empty($hp_image)){
                $filename = explode(".", $hp_image->name);
                $ext = $filename[1];
                $model->head_image = Yii::$app->security->generateRandomString(26).".{$ext}";
                $path = Yii::getAlias('@frontend').'/web/img/products_pictures/' . $model->head_image;
                $hp_image->saveAs($path);
            } else {
                $model->head_image = $beforeHeadpirture;
            }

            $bp_image = UploadedFile::getInstance($model, 'link_image');
            if(!empty($bp_image)){
                $filename = explode(".", $bp_image->name);
                $ext = $filename[1];
                $model->link_image = Yii::$app->security->generateRandomString(26).".{$ext}";
                $path = Yii::getAlias('@frontend').'/web/img/brand_pictures/' . $model->link_image;
                $bp_image->saveAs($path);
            } else {
                $model->link_image = $beforeBrandpirture;
            }

            if(isset($_POST['LinkSort'])){
                foreach ($_POST['LinkSort'] as $k=>$v){
                    $link = SCSecondaryPagesLinks::findOne($k);
                    if(empty($link))continue;
                    $link->sort_order = (int)$v;
                    $link->save();
                }
            }

            if($model->save()){
                return $this->render('item', ['model'=>$model, 'tab'=>$tab]);
            }
        }
        return $this->render('item', ['model'=>$model, 'tab'=>$tab]);
    }

    public function actionLink(){
        $container_id = $_POST['c_id'];
        $item = $_POST['item'];
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $model = SCSecondaryPagesLinks::find()->where("link_id = $id")->one();
        } else {
            $model = new SCSecondaryPagesLinks;
            //$model->categoryID = $container_id;
        }

        return $this->renderAjax('_modal', ['model'=>$model, 'container'=>$container_id, 'item'=>$item]);
    }

    public function actionLoadsubcatsajax(){
        $root = $_POST['root'];
        $type = $_POST['type'];
        $main = $_POST['main'];

        $model = SCCategories::find()->where("parent = ".$root)->orderBy('sort_order')->all();

        return $this->renderAjax('modaltree', [
            'rootCats'=>$model,
            'type' =>$type,
            'main' =>$main,
        ]);
    }

    public function actionSave($id = null){
        if($id == null){
            $model = new SCSecondaryPagesLinks();
            $model->scenario = 'insert';
        } else {
            $model = SCSecondaryPagesLinks::find()->where("link_id = $id")->one();
            if(empty($_FILES)){
                $model->scenario = 'updateWoImage';
            } else {
                $model->scenario = 'update';
            }
        }



        if ($model->load(Yii::$app->request->post())){
            if($model->save()){
                return $this->redirect(['/secondary/item', 'id'=>$_POST['item'], 'tab'=>'linksset']);
            } else {
                print_r($model->getErrors());
            }
        }
    }

    public function actionDelete(){
        if(!isset($_POST['id']))return;
        $id = $_POST['id'];
        $model = SCSecondaryPagesLinks::find()->where("link_id = $id")->one();
        $model->delete();
    }

    public function actionContainer(){
        $item = $_POST['item'];
        if(isset($_POST['c_id'])){
            $id = $_POST['c_id'];
            $model = SCSecondaryPagesContainers::find()->where("id = $id")->one();
        } else {
            $model = new SCSecondaryPagesContainers;
        }

        return $this->renderAjax('_c_modal', ['model'=>$model, 'item'=>$item]);
    }

    public function actionSaveContainer($id = null){
        if($id == null){
            $model = new SCSecondaryPagesContainers;
        } else {
            $model = SCSecondaryPagesContainers::find()->where("id = $id")->one();
        }

        $model->pageid = $_POST['item'];

        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['/secondary/item', 'id'=>$_POST['item'], 'tab'=>'linksset']);
        }
    }

    public function actionDeleteContainer(){
        if(!isset($_POST['id']))return;
        $id = $_POST['id'];
        $model = SCSecondaryPagesContainers::find()->where("id = $id")->one();
        $model->delete();
    }

    public function actionReorderContainers(){
        if(!isset($_POST['id']))return;
        $id = $_POST['id'];
        $model = SCSecondaryPagesContainers::find()->where("id = $id")->one();
        $model->order = $_POST['order'];
        $model->save();
    }

    public function actionReorderItems(){
        if(!isset($_POST['id']))return;
        $id = $_POST['id'];
        $model = SCSecondaryPagesLinks::find()->where("link_id = $id")->one();
        $model->sort_order = $_POST['order'];
        $model->save();
    }

}
