<?php

namespace backend\controllers;

use common\models\Trash;
use yii\data\Pagination;
use yii\web\Controller;
/**
 * @author mult1mate
 * Date: 20.12.15
 * Time: 20:56
 */
class TrashController extends Controller
{
    public function actionIndex()
    {
        $query = Trash::find();
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

    public function actionRemove($id)
    {
        Trash::findOne($id)->remove();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionRestore($id){
        Trash::findOne($id)->restoreInner();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionRemoveEverything()
    {
        $model = Trash::find()->all();
        foreach ($model as $m)
        {
            $m->remove();
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionRestoreEverything()
    {
        Trash::deleteAll();
        return $this->redirect(\Yii::$app->request->referrer);
    }
}