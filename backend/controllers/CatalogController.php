<?php

namespace backend\controllers;

use common\models\SCParentalConnections;
use common\models\SCProductOptions;
use common\models\SCProductOptionsValues;
use common\models\SCProductPictures;
use common\models\SCProducts;
use common\models\SCRelatedCategories;
use common\models\SCSameCategories;
use common\models\Trash;
use common\models\UserActivity;
use common\models\UserNotifications;
use Yii;
use common\models\SCCategories;
use common\models\SCCategoriesSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\UploadedFile;
use yii\web\Session;
use yii\web\View;
use yii\imagine\Image;
use zxbodya\yii2\elfinder\ConnectorAction;


/**
 * CategoriesController implements the CRUD actions for SCCategories model.
 */
class CatalogController extends Controller
{

    public function actionIndex()
    {
        $id1 = !empty(Yii::$app->session->get('catalog_id1'))?Yii::$app->session->get('catalog_id1'):1;
        $id2 = !empty(Yii::$app->session->get('catalog_id2'))?Yii::$app->session->get('catalog_id2'):1;


        $left = SCCategories::find()->where(['parent'=>$id1])->orderBy('sort_order ASC')->all();
        $right = SCCategories::find()->where(['parent'=>$id2])->orderBy('sort_order ASC')->all();
        $left_p = SCProducts::find()->where(['categoryID'=>$id1])->orderBy('sort_order ASC')->all();
        $right_p = SCProducts::find()->where(['categoryID'=>$id2])->orderBy('sort_order ASC')->all();

        return $this->render('index', ['left'=>$left, 'id1'=>$id1, 'id2'=>$id2, 'right'=>$right, 'left_p'=>$left_p, 'right_p'=>$right_p]);
    }

    public function actionReRender($id, $id2)
    {
        echo $this->reRender($id, $id2);
    }

    public function actionLoad($id, $window)
    {

        if(Yii::$app->request->isAjax){
            $output = [];
            $model = SCCategories::find()->where(['parent'=>$id])->all();
            $output['window'] = $window;
            $output['html'] = $this->renderAjax('_sideblock', ['model'=>$model]);

            echo Json::encode($output);
        }
    }

    public function actionMove()
    {
        $id = $_POST['id'];
        $category = $_POST['category'];
        $left = $_POST['left'];
        $right = $_POST['right'];

        $model = SCCategories::findOne($id);
        $model->parent = $category;
        $model->save();

        echo $this->reRender($left, $right);
    }

    public function actionMoveProduct()
    {
        $id = $_POST['id'];
        $category = $_POST['category'];
        $left = $_POST['left'];
        $right = $_POST['right'];

        $model = SCProducts::findOne($id);
        $model->categoryID = $category;
        $model->save(false);

        echo $this->reRender($left, $right);
    }


    function reRender($id, $id2){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->session->set('catalog_id1', $id);
        Yii::$app->session->set('catalog_id2', $id2);


        $left = SCCategories::find()->where(['parent'=>$id])->orderBy('sort_order ASC')->all();
        $right = SCCategories::find()->where(['parent'=>$id2])->orderBy('sort_order ASC')->all();

        $left_p = SCProducts::find()->where(['categoryID'=>$id])->orderBy('sort_order ASC')->all();
        $right_p = SCProducts::find()->where(['categoryID'=>$id2])->orderBy('sort_order ASC')->all();

        $output = [];
        $output['left'] = $this->renderAjax('_sideblock', ['model'=>$left, 'id'=>$id, 'products'=>$left_p, 'window'=>'left']);
        $output['right'] = $this->renderAjax('_sideblock', ['model'=>$right, 'id'=>$id2, 'products'=>$right_p, 'window'=>'right']);

        \Yii::$app->response->data  =  $output;

        //return Json::encode($output);
    }

    public function actionNewFolder()
    {
        $parentID = $_POST['category'];
        $name = $_POST['name'];

        $left = $_POST['left'];
        $right = $_POST['right'];

        $model = new SCCategories;
        $model->name_ru = $name;
        $model->parent = $parentID;
        if(!$model->save(false)){
            print_r($model->getErrors());
        }
        echo $this->reRender($left, $right);
    }

}