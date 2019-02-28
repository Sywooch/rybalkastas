<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 04.10.2018
 * Time: 15:32
 */

namespace rest\modules\ut\controllers\connectors;

use common\models\mongout\Sales;
use MongoDB\BSON\UTCDateTime;
use yii\helpers\Json;
use yii\web\Controller;

class SalesController extends Controller
{
    public function actionReceive(){
        $this->enableCsrfValidation = false;

        $data = Json::decode($_POST['data']);
        $date = new UTCDateTime((new \DateTime($data['date']))->getTimestamp().'000');
        $model = Sales::find()->where(['link'=>$data['link']])->one();
        if(empty($model)){
            $model = new Sales();
            $model->link = $data['link'];
        }
        $items = [];
        foreach($data['items'] as $item){
            $items[] = $item;
        }
        $model->items = $items;
        $model->warehouse = $data['warehouse'];
        $model->document_id = $data['document_id'];
        $model->is_retail = $data['is_retail'];
        $model->date = $date;
        $model->save();
    }

    public function beforeAction($action)
    {
        if ($action->id == 'receive') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
}