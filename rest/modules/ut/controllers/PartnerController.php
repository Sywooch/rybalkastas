<?php

namespace rest\modules\ut\controllers;

use common\models\mongout\Customers;
use common\models\mongout\Products;
use \rest\modules\ut\components\Controller;
use yii\web\Response;

/**
 * Default controller for the `ut` module
 */
class PartnerController extends \rest\modules\ut\components\Controller
{

    public function actionGetTree($id)
    {
        if(empty($id)) $id = null;
        $models = Customers::find()->where(['parent'=>$id])->andWhere(['<>', 'link', $id])->all();
        $current = Customers::find()->where(['link'=>$id])->one();
        return ['tree'=>$models, 'current'=>$current];
    }

    public function actionSearch($str){
        $models = Customers::find()->where(['like', 'name', $str])->orWhere(['like', 'id_1c', $str])->limit(50)->all();
        return ['tree'=>$models];
    }
}
