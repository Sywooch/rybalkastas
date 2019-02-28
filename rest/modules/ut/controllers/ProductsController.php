<?php

namespace rest\modules\ut\controllers;

use common\models\mongout\Products;
use \rest\modules\ut\components\Controller;
use yii\web\Response;

/**
 * Default controller for the `ut` module
 */
class ProductsController extends \rest\modules\ut\components\Controller
{

    public function actionGetTree($id)
    {
        $models = Products::find()->where(['parent'=>$id])->andWhere(['<>', 'link', $id])->all();
        $current = Products::find()->where(['link'=>$id])->one();
        return ['tree'=>$models, 'current'=>$current];
    }

    public function actionSearch($str){
        $models = Products::find()->where(['like', 'name', $str])->orWhere(['like', 'id_1c', $str])->limit(50)->all();
        return ['tree'=>$models];
    }
}
