<?php

namespace backend\modules\yandexexcel\controllers;

use common\models\SCOrders;
use common\models\SCProducts;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Default controller for the `excel` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if(empty($ordersMonth)){
            $begin = new \DateTime( date('Y-m-d h:i:s').' -3 weeks' );
            $end = new \DateTime( date('Y-m-d h:i:s').' +1 day' );
        } else {
            $begin = new \DateTime( date($ordersMonth.'-01 h:i:s') );
            $end = new \DateTime( date($ordersMonth.'-t h:i:s'));
        }

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $orderStats = [];
        foreach ( $period as $dt ){
            $beginOfDay = $dt->setTime(0,0,1)->format( "Y-m-d H:i:s\n" );
            $endOfDay = $dt->setTime(23,59,59)->format( "Y-m-d H:i:s\n" );
            $orderStats[$dt->format("Y-m-d H:i:s")]['all'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['source_ref'=>'ymrkt'])->sum('order_amount');
            $orderStats[$dt->format("Y-m-d H:i:s")]['done'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['source_ref'=>'ymrkt'])->andWhere(['statusID'=>5])->sum('order_amount');
            $orderStats[$dt->format("Y-m-d H:i:s")]['cancelled'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['source_ref'=>'ymrkt'])->andWhere(['statusID'=>1])->sum('order_amount');
            $orderStats[$dt->format("Y-m-d H:i:s")]['new'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['source_ref'=>'ymrkt'])->andWhere(['statusID'=>3])->sum('order_amount');
        }

        return $this->render('index', ['orderStats'=>$orderStats, 'begin'=>$begin->format( "Y-m-d H:i:s\n" ), 'end'=>$end->format( "Y-m-d H:i:s\n" )]);
    }

    public function actionDownload()
    {
        echo \moonland\phpexcel\Excel::widget([
            'models' => \common\models\SCProducts::find()->where(['upload2market'=>1])->all(),
            'mode' => 'export', //default value as 'export'
            'columns' => ['name_ru','product_code'], //without header working, because the header will be get label from attribute label.
            'headers' => ['name_ru' => 'Название товара','product_code' => 'Код товара'],
        ]);
    }

    public function actionUpload()
    {
        $uploadedFile = UploadedFile::getInstanceByName('newImageUpload');
        if(empty($uploadedFile)){
            echo Json::encode(['status'=>0,'msg'=>'Отсутствует файл']);
            return;
        }
        $ext = $uploadedFile->getExtension();
        $allowed_extensions = ['xls', 'xlsx', 'csv'];
        if(!in_array($ext, $allowed_extensions)){
            echo Json::encode(['status'=>0,'msg'=>'Недопустимый формат файла']);
            return;
        }
        $tempName = \Yii::getAlias('@backend/web/tmp/').md5(uniqid().time()).'.'.$ext;
        $uploadedFile->saveAs($tempName);
        $dataXls = \moonland\phpexcel\Excel::import($tempName,[
            'setFirstRecordAsKeys' => false,
        ]);
        if(!empty($dataXls[0][1])){
            $dataXls = $dataXls[0];
        }

        $validCountCols = 2;
        if(count($dataXls[1]) <> $validCountCols){
            echo Json::encode(['status'=>0,'msg'=>'Несоответствие количества столбцов']);
            return;
        }

        foreach ($dataXls as $d){
            if($d['B'] == 'Код товара')continue;
            if(empty($d['A']) || empty($d['B']))continue;

            $model = SCProducts::find()->where(['product_code'=>$d['B']])->one();
            if(empty($model))continue;
            $model->upload2market = 1;
            $model->save(false);
        }

        return $this->redirect(['index']);
    }
}
