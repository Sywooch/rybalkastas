<?php
namespace frontend\controllers;

use common\models\SCNewsTable;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
/**
 * Site controller
 */
class NewsController extends Controller
{
    public function actionIndex()
    {
        $query = SCNewsTable::find()->where(['published'=>1])->orderBy('published_at DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionItem($id)
    {
        $model =  SCNewsTable::findOne($id);
        if(empty($model))throw new NotFoundHttpException;

        if(!empty($model->tpl)){
            $view = 'tpls/'.$model->tpl;
        } else {
            $view = 'item';
        }

        return $this->render($view,['model'=>$model]);
    }


}