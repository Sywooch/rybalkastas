<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 04.07.2018
 * Time: 13:25
 */

namespace rest\modules\ut\controllers\connectors;

use common\models\mongout\Customers;
use common\models\mongout\Orders;
use common\models\mongout\Products;
use rest\modules\ut\components\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class CustomersController extends Controller
{
    public function actionReceive()
    {
        /*$n = preg_replace( "/\r|\n/", "", $_POST['data'] );
        $n = str_replace(['\n', '\\'], '', $n);*/
        \Yii::trace($_POST['data'], 'testing');
        $data = Json::decode($_POST['data']);
        $model = new Customers();
        $model->takeNeeded($data);
        if(!$model->save()){
            throw new \Exception(Json::encode($model->getErrors()));
        }
    }
}