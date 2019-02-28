<?php

namespace frontend\controllers;

use common\models\SCAuxPages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class PageController extends Controller
{
    public function actionIndex($slug)
    {
        $model = SCAuxPages::find()->where(['aux_page_slug'=>$slug])->one();
        if(empty($model))Throw new NotFoundHttpException;

        return $this->render('index', ['model'=>$model]);
    }

    /*
    public function actionShops($shop = null)
    {
        if (empty($shop))
            return $this->render('shops/main');

        return $this->render('shops/' . $shop);
    }

    public function actionComments(){ }
    */
}
