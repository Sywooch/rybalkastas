<?php
namespace frontend\controllers;

use common\models\SCSecondaryPages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BrandsController extends Controller
{

    public function actionIndex($alias){
        $model = SCSecondaryPages::find()->where(['alias'=>$alias])->one();
        if(empty($model))Throw new NotFoundHttpException;

        return $this->render('index', ['model'=>$model]);
    }

}