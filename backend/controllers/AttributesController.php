<?php

namespace backend\controllers;

use common\models\SCProductOptions;
use Yii;
use common\models\SCProductOptionsCategoryes;
use common\models\SCProductOptionsCategoryesSearch;
use yii\caching\TagDependency;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AttributesController implements the CRUD actions for SCProductOptionsCategoryes model.
 */
class AttributesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SCProductOptionsCategoryes models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(isset($_POST['do_resort'])){
            foreach($_POST['resort'] as $k=>$v){
                //echo 'lol';
                $model = SCProductOptionsCategoryes::find()->where("categoryID = $k")->one();
                $model->sort = $v;
                $model->save(false);
                //return true;
            }
        }

        $model = SCProductOptionsCategoryes::find()->orderBy("sort")->all();

        if (isset($_POST['hasEditable'])) {
            if(isset($_POST['category_name_ru'])){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                foreach($_POST['category_name_ru'] as $k=>$v){
                    $category = SCProductOptionsCategoryes::find()->where("categoryID = $k")->one();
                    if($v == '' || empty($v)){
                        $v = $category->category_name_ru;
                    } else {
                        $category->category_name_ru = $v;
                    }

                    if($category->save(false)){
                        return ['output' => $v, 'message' => ''];
                    } else {
                        return ['output' => '', 'message' => ''];
                    }

                }
            }

            if(isset($_POST['name_ru'])){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                foreach($_POST['name_ru'] as $k=>$v){
                    $category = SCProductOptions::find()->where("optionID = $k")->one();
                    if($v == '' || empty($v)){
                        $v = $category->name_ru;
                    } else {
                        $category->name_ru = $v;
                    }

                    if($category->save(false)){
                        return ['output' => $v, 'message' => ''];
                    } else {
                        return ['output' => '', 'message' => ''];
                    }

                }
            }
            // use Yii's response format to encode output as JSON
            TagDependency::invalidate(Yii::$app->cache, 'filter_vars');
        }

        return $this->render('index', [
            'model'=>$model
        ]);
    }

    public function actionLoadAttrs(){
        $id = $_POST['id'];
        $model = SCProductOptions::find()->where('optionCategory = '.$id)->all();
        $main = SCProductOptionsCategoryes::find()->where("categoryID = $id")->one();
        return $this->renderAjax('_attrs',[
            'model'=>$model,
            'name'=>$main->category_name_ru
        ]);
    }

    public function actionCreatecat(){
        if(!empty($_POST['newCat'])){
            $maxSort = SCProductOptionsCategoryes::find()->max('sort');

            $cat = new SCProductOptionsCategoryes();
            $cat->category_name_ru = $_POST['newCat'];
            $cat->sort = $maxSort+1;
            if($cat->save(false)){
                $model = SCProductOptionsCategoryes::find()->orderBy("sort")->all();
                return $this->renderAjax('_category',[
                    'model'=>$model,
                ]);
            } else {
                return 'empty';
            };
        } else {
            return 'empty';
        }

    }


    public function actionDeletecat(){
        $id = $_POST['id'];
        $model = SCProductOptionsCategoryes::find()->where('categoryID = '.$id)->one();
        $model->delete();
        $tree = SCProductOptionsCategoryes::find()->orderBy("sort")->all();
        return $this->renderAjax('_category',[
            'model'=>$tree,
        ]);
    }

    public function actionCreateattr(){
        $id = $_POST['id'];
        $main = SCProductOptionsCategoryes::find()->where("categoryID = $id")->one();
        $attr = new SCProductOptions;
        $attr->optionCategory = $id;
        $attr->name_ru = $_POST['newAttr'];
        TagDependency::invalidate(Yii::$app->cache, ["option_category_options_" . $attr->optionCategory]);
        if($attr->save(false)){
            $category = SCProductOptions::find()->where('optionCategory = '.$id)->all();
            return $this->renderAjax('_attrs',[
                'model'=>$category,
                'name'=>$main->category_name_ru
            ]);
        }
    }

    public function actionDeleteattr(){
        $id = $_POST['id'];
        $model = SCProductOptions::find()->where('optionID = '.$id)->one();
        $catID = $model->optionCategory;
        $model->delete();
        $category = SCProductOptions::find()->where('optionCategory = '.$catID)->all();
        TagDependency::invalidate(Yii::$app->cache, ["option_category_options_" . $catID]);
        $main = SCProductOptionsCategoryes::find()->where("categoryID = $catID")->one();
        return $this->renderAjax('_attrs',[
            'model'=>$category,
            'name'=>$main->category_name_ru
        ]);
    }

    public function actionOpenFilter(){
        if(!isset($_POST['id'])){
            return 'none';
        }
        $id = $_POST['id'];
        $model = SCProductOptions::find()->where("optionID = $id")->one();
        return $this->renderAjax("filter", ['model'=>$model]);
    }

    public function actionUpdateFilter($id)
    {
        $model = SCProductOptions::find()->where("optionID = $id")->one();
        if ($model->load(Yii::$app->request->post())){
            $model->save();
        } else {
            return false;
        }
    }

    /**
     * Displays a single SCProductOptionsCategoryes model.
     * @param integer $id
     * @return mixed
     */
}
