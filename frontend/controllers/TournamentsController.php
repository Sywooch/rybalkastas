<?php

namespace frontend\controllers;

use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\SCArticlesTournaments;

/**
 * Site controller
 */
class TournamentsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = SCArticlesTournaments::find()
              ->where(['published' => 1])
            ->orderBy(['sort_order' => SORT_DESC]);

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
              ->all();

        return $this->render('index', [
            'models' => $models,
            'pages'  => $pages,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionItem($id)
    {
        $model =  SCArticlesTournaments::findOne($id);

        if (empty($model)) throw new NotFoundHttpException;

        if (!empty($model->tpl)) {
            $view = 'tpls/' . $model->tpl;
        } else {
            $view = 'item';
        }

        return $this->render($view, [
            'model' => $model
        ]);
    }
}
