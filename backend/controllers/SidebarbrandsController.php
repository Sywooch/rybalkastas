<?php

namespace backend\controllers;

use common\models\SCSidebarbrands;
use Yii;

class SidebarbrandsController extends \yii\web\Controller
{

    public function actionInsert()
    {

        if(!isset($_POST['SCSidebarbrands'])) return false;
        $model = new SCSidebarbrands;
        $model->scenario = 'insert';
        if ($model->load(Yii::$app->request->post())){
            $model->order = 0;
            if($model->save()){
                return $this->redirect(['/sidebarbrands/index']);
            } else {
                print_r($model->getErrors());
            }
        }
    }

    public function actionIndex()
    {
        $model = SCSidebarbrands::find()->orderBy('order ASC')->all();
        $newbrand = new SCSidebarbrands;
        return $this->render('index', ['model'=>$model, 'newbrand'=>$newbrand]);
    }

    public function actionSort()
    {
        $id = $_POST['id'];
        $sort = $_POST['sort'];
        $model = SCSidebarbrands::find()->where("id = $id")->one();
        $model->scenario = 'sort';
        $model->order = $sort;
        $model->save();
        return 'success';
    }

    public function actionEdit($id)
    {
        if(!isset($_POST['SCSidebarbrands'])) return false;
        $model = SCSidebarbrands::find()->where("id = $id")->one();
        $model->scenario =  'insert';
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['/sidebarbrands/index']);
            } else {
                print_r($model->getErrors());
            }
        } else {
            return "Ошибка при сохранении";
        }

    }

    public function actionDelete($id)
    {
        $model = SCSidebarbrands::find()->where("id = $id")->one();
        if ($model->delete()) {
            return $this->redirect(['/sidebarbrands/index']);
        } else {
            return "Ошибка при сохранении";
        }
    }

}
