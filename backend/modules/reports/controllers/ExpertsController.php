<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.06.2018
 * Time: 12:56
 */


namespace backend\modules\reports\controllers;

use backend\modules\reports\assets\ExpertsAsset;
use common\models\SCExperts;
use common\models\SCOrders;
use common\models\SCShops;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\Controller;

class ExpertsController extends Controller
{
    public function actionIndex()
    {
        ExpertsAsset::register($this->view);
        $shops = SCShops::find()->all();
        return $this->render('index', ['shops'=>$shops]);
    }

    public function actionLoad($shop, $month){
        if(empty($month) || $month == 'null'){
            $begin = new \DateTime( date('Y-m-01 h:i:s') );
            $end = new \DateTime( date('Y-m-t h:i:s').' +1 day' );
        } else {
            $begin = new \DateTime( date($month.'-01 h:i:s') );
            $end = new \DateTime( date($month.'-t h:i:s').' +2 day' );
        }

        $odd = '#71514a';
        $even = '#cc3334';

        $experts = SCExperts::find()->where(['shop_id'=>$shop])->orderBy(['gang'=>SORT_ASC])->all();

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $orderStats = [];

        foreach ( $period as $dt ) {
            $beginOfDay = $dt->setTime(0, 0, 1)->format("Y-m-d H:i:s\n");
            $endOfDay = $dt->setTime(23, 59, 59)->format("Y-m-d H:i:s\n");
            $orderStats[$dt->format("Y-m-d H:i:s")] = SCOrders::find()->leftJoin('SC_experts', 'SC_experts.expert_id = manager_id')->select(['manager_id', 'gang', 'shop', 'COUNT(*) as cnt'])->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['shop_id'=>$shop])->groupBy(['manager_id'])->asArray()->all();
        }

        $datasets = [];
        foreach($experts as $expert){

            $code = '#'.substr(md5(Inflector::slug($expert->shop).$expert->gang.'_'.$expert->shop_id), 0, 6);
            $datasets[$expert->expert_id] = [
                'label'=>$expert->title,
                'data'=>[],
                'backgroundColor'=>$expert->gang%2==0?$odd.'30':$even.'30',
                'borderColor'=>$expert->gang%2==0?$odd:$even,
                'borderWidth'=>1,
                'fill'=>true,
                'hidden'=>false,
                'gang'=>$expert->gang,
                'shop'=>$expert->shop,
            ];
        }

        $datasets['all'] = [
            'label'=>'ВСЕГО',
            'data'=>[],
            'backgroundColor'=>'#ff940000',
            'borderColor'=>'#ff9400',
            'borderWidth'=>2,
            'fill'=>true,
            'hidden'=>false,
            'gang'=>0,
            'shop'=>SCShops::findOne($shop)->name,
        ];

        $i = 0;

        foreach($orderStats as $k=>$s){
            $labels[] = \Yii::$app->formatter->asDate($k, 'long');
            foreach($s as $ksv){
                if(empty($ksv['manager_id'])) continue;
                $datasets[$ksv['manager_id']]['data'][] = $ksv['cnt'];
                if(empty($datasets['all']['data'][$i])){
                    $datasets['all']['data'][$i] = $ksv['cnt'];
                } else {
                    $datasets['all']['data'][$i] += $ksv['cnt'];
                }
            }
            foreach($experts as $e){
                if(!isset($datasets[$e->expert_id]['data'][$i])) $datasets[$e->expert_id]['data'][$i] = 0;
            }
            $i++;
        }

        $sets = [];
        foreach($datasets as $v){
            $sets[] = $v;
        }

        return Json::encode(['labels'=>$labels, 'set'=>$sets]);
    }
}