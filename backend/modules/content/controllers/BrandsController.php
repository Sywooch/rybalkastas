<?php

namespace backend\modules\content\controllers;

use common\models\SCMonufacturers;
use yii\web\Controller;
use Yii;

class BrandsController extends Controller
{
    public function actionIndex()
    {
        $model = SCMonufacturers::find()->orderBy("name")->all();
        $newbrand = new SCMonufacturers;

        $request = Yii::$app->request;
        if ($newbrand->load($request->post()) && $newbrand->save()) {
            return $this->refresh();
        } else {
            return $this->render('index', ['model'=>$model, 'newbrand'=>$newbrand]);
        }
    }
}
