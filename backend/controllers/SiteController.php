<?php

namespace backend\controllers;

use common\models\mongo\IpsByDate;
use common\models\mongo\UserMeta;
use common\models\SCCards;
use common\models\SCCategories;
use common\models\SCCustomers;
use common\models\SCExperts;
use common\models\SCOrderedCarts;
use common\models\SCOrders;
use common\models\SCProducts;
use common\models\SCRelatedCategories;
use common\models\SCSecondaryPagesContainers;
use common\models\SCSecondaryPagesLinks;
use dektrium\user\models\User;
use common\models\UserActivity;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use common\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex2()
    {
        return $this->render('index2');
    }

/*    public function actionIndex($ordersMonth = null, $ordersSumMonth = null, $usersMonth = null)
    {


        // ЗАКАЗЫ ЗА МЕСЯЦ
        if(empty($ordersMonth)){
            $begin = new \DateTime( date('Y-m-01 h:i:s') );
            $end = new \DateTime( date('Y-m-t h:i:s').' +1 day' );
        } else {
            $begin = new \DateTime( date($ordersMonth.'-01 h:i:s') );
            $end = new \DateTime( date($ordersMonth.'-t h:i:s').' +2 day' );
        }

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $orderStats = [];
        foreach ( $period as $dt ){
            $beginOfDay = $dt->setTime(0,0,1)->format( "Y-m-d H:i:s\n" );
            $endOfDay = $dt->setTime(23,59,59)->format( "Y-m-d H:i:s\n" );
            $orderStats[$dt->format("Y-m-d H:i:s")]['all'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->sum('order_amount');
            $orderStats[$dt->format("Y-m-d H:i:s")]['done'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['statusID'=>5])->sum('order_amount');
            $orderStats[$dt->format("Y-m-d H:i:s")]['cancelled'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['statusID'=>1])->sum('order_amount');
            $orderStats[$dt->format("Y-m-d H:i:s")]['new'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['statusID'=>3])->sum('order_amount');
            //echo $dt->format('Y-m-d').'<br/>';

        }



        // ПОСЕТИТЕЛИ ЗА МЕСЯЦ
        if(empty($usersMonth)){
            $begin = new \DateTime( date('01-m-Y') );
            $end = new \DateTime( date('d-m-Y').' +1 day' );
        } else {
            $begin = new \DateTime( date('01-'.$usersMonth) );
            $end = new \DateTime( date('t-'.$usersMonth));
        }
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $userStats = [];
        foreach ( $period as $dt ){
            $date = $dt->format('d-m-Y');
            $model = IpsByDate::find()->where(['date'=>$date])->one();
            $userStats[$date]=count($model['ips']);
        }

        $collectionTopProducts = Yii::$app->mongodb->getCollection('userMeta');
        $productViews = $collectionTopProducts->aggregate([
            [
                '$unwind'=>'$product_views'
            ],
            [
                '$group'=> [
                    "_id"=>'$product_views.productID',
                    'sum'=>['$sum'=>'$product_views.views']
                ]
            ],
            [
                '$sort'=>['sum'=>-1]
            ],
            [
                '$limit'=>10
            ]
        ]);

        $topProducts = [];
        foreach ($productViews as $productView){
            $product = SCCategories::findOne($productView['_id']);
            $topProducts[] = ['model'=>$product, 'sum'=>$productView['sum']];
        }

        $topSelling = SCOrderedCarts::find()->select('name, count(*) as num')->where('Price > 1000')->groupBy('name')->orderBy('num DESC')->limit(10)->asArray()->all();



        return $this->render('index', ['orderStats'=>$orderStats, 'userStats'=>$userStats, 'topProducts'=>$topProducts, 'topSelling'=>$topSelling]);
    }*/

    public function actionIndex()
    {
        return $this->render('index_vue');

    }

    public function actionLoadOrders($type = 'all', $ordersMonth = null)
    {
        if(empty($ordersMonth)){
            $begin = new \DateTime( date('Y-m-01 h:i:s') );
            $end = new \DateTime( date('Y-m-t h:i:s').' +1 day' );
        } else {
            $begin = new \DateTime( date($ordersMonth.'-01 h:i:s') );
            $end = new \DateTime( date($ordersMonth.'-t h:i:s').' +2 day' );
        }

        $experts = null;
        if($type == 'experts'){
            $experts = SCExperts::find()->all();
        }

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $orderStats = [];
        foreach ( $period as $dt ){
            $beginOfDay = $dt->setTime(0,0,1)->format( "Y-m-d H:i:s\n" );
            $endOfDay = $dt->setTime(23,59,59)->format( "Y-m-d H:i:s\n" );

            switch ($type){
                case 'all':
                    $orderStats[$dt->format("Y-m-d H:i:s")]['all'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->sum('order_amount');
                    break;
                case 'done':
                    $orderStats[$dt->format("Y-m-d H:i:s")]['done'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['statusID'=>5])->sum('order_amount');
                    break;
                case 'cancelled':
                    $orderStats[$dt->format("Y-m-d H:i:s")]['cancelled'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['statusID'=>1])->sum('order_amount');
                    break;
                case 'new':
                    $orderStats[$dt->format("Y-m-d H:i:s")]['new'] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['statusID'=>3])->sum('order_amount');
                    break;
                case 'experts':
                    foreach($experts as $expert){
                        $orderStats[$dt->format("Y-m-d H:i:s")]['experts'][$expert->expert_id] = SCOrders::find()->where(['between', 'order_time', $beginOfDay, $endOfDay])->andWhere(['manager_id'=>$expert->expert_id])->sum('order_amount');
                    }
                    break;
            }
        }

        $labels = [];
        $sets = [];

        foreach($orderStats as $k=>$s){
            $labels[] = Yii::$app->formatter->asDate($k, 'long');
            foreach ($s as $ks=>$ksv){
                $sets[$ks][] = $ksv;
            }
        }

        return Json::encode(['labels'=>$labels, 'set'=>$sets[$type]]);
    }

    public function actionLoadExpertsData($ordersMonth = null)
    {
        if(empty($ordersMonth)){
            $begin = new \DateTime( date('Y-m-01 h:i:s') );
            $end = new \DateTime( date('Y-m-t h:i:s').' +1 day' );
        } else {
            $begin = new \DateTime( date($ordersMonth.'-01 h:i:s') );
            $end = new \DateTime( date($ordersMonth.'-t h:i:s').' +2 day' );
        }

        $experts = SCExperts::find()->orderBy(['gang'=>SORT_ASC])->all();

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $orderStats = [];

        foreach ( $period as $dt ) {
            $beginOfDay = $dt->setTime(0, 0, 1)->format("Y-m-d H:i:s\n");
            $endOfDay = $dt->setTime(23, 59, 59)->format("Y-m-d H:i:s\n");
            $orderStats[$dt->format("Y-m-d H:i:s")] = SCOrders::find()->leftJoin('SC_experts', 'SC_experts.expert_id = manager_id')->select(['manager_id', 'gang', 'shop', 'COUNT(*) as cnt'])->where(['between', 'order_time', $beginOfDay, $endOfDay])->groupBy(['manager_id'])->asArray()->all();
        }

        $datasets = [];
        foreach($experts as $expert){

            $code = '#'.substr(md5(Inflector::slug($expert->shop).$expert->gang.'_'.$expert->shop_id), 0, 6);
            $datasets[$expert->expert_id] = [
                'label'=>$expert->title,
                'data'=>[],
                'backgroundColor'=>$code.'30',
                'borderColor'=>$code,
                'borderWidth'=>1,
                'fill'=>true,
                'hidden'=>true,
                'gang'=>$expert->gang,
                'shop'=>$expert->shop,
            ];
        }

        $i = 0;

        foreach($orderStats as $k=>$s){
            $labels[] = \Yii::$app->formatter->asDate($k, 'long');
            foreach($s as $ksv){
                if(empty($ksv['manager_id'])) continue;
                $datasets[$ksv['manager_id']]['data'][] = $ksv['cnt'];
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

    public function actionLoadGangData($ordersMonth = null){
        if(empty($ordersMonth)){
            $begin = new \DateTime( date('Y-m-01 h:i:s') );
            $end = new \DateTime( date('Y-m-t h:i:s').' +1 day' );
        } else {
            $begin = new \DateTime( date($ordersMonth.'-01 h:i:s') );
            $end = new \DateTime( date($ordersMonth.'-t h:i:s').' +2 day' );
        }

        $experts = SCExperts::find()->orderBy(['gang'=>SORT_ASC])->all();
        $gangs = [];

        foreach($experts as $exp){
            $gangs[$exp->gang]['gang_name'] = $exp->shop.' '.$exp->gang;
            $gangs[$exp->gang]['shop'] = $exp->shop;
            $gangs[$exp->gang]['experts'][] = $exp->expert_last_name;
            $gangs[$exp->gang]['expert_ids'][] = $exp->expert_id;
        }


        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $orderStats = [];

        foreach ( $period as $dt ) {
            $beginOfDay = $dt->setTime(0, 0, 1)->format("Y-m-d H:i:s\n");
            $endOfDay = $dt->setTime(23, 59, 59)->format("Y-m-d H:i:s\n");
            $orderStats[$dt->format("Y-m-d H:i:s")] = SCOrders::find()->leftJoin('SC_experts', 'SC_experts.expert_id = manager_id')->select(['manager_id', 'gang', 'COUNT(*) as cnt'])->where(['between', 'order_time', $beginOfDay, $endOfDay])->groupBy(['gang'])->asArray()->all();
        }

        $datasets = [];
        foreach($gangs as $k=>$gang){

            $code = '#'.substr(md5(Inflector::slug($gang['shop'].$gang['shop'])), 0, 6);
            $datasets[$k] = [
                'label'=>implode(', ', $gang['experts']),
                'data'=>[],
                'backgroundColor'=>$code.'30',
                'borderColor'=>$code,
                'borderWidth'=>1,
                'fill'=>true,
                'hidden'=>true,
            ];
        }

        $i = 0;

        foreach($orderStats as $k=>$s){
            $labels[] = \Yii::$app->formatter->asDate($k, 'long');
            foreach($s as $ksv){
                if(empty($ksv['gang'])) continue;
                $datasets[$ksv['gang']]['data'][] = $ksv['cnt'];
            }
            foreach($experts as $e){
                if(!isset($datasets[$e->gang]['data'][$i])) $datasets[$e->gang]['data'][$i] = 0;
            }
            $i++;
        }

        $sets = [];
        foreach($datasets as $v){
            $sets[] = $v;
        }

        return Json::encode(['labels'=>$labels, 'set'=>$sets]);
    }

    public function actionLoadActivity($usersMonth = null)
    {
        if(empty($usersMonth)){
            $begin = new \DateTime( date('01-m-Y') );
            $end = new \DateTime( date('d-m-Y').' +1 day' );
        } else {
            $begin = new \DateTime( date('01-'.$usersMonth) );
            $end = new \DateTime( date('t-'.$usersMonth));
        }
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $userStats = [];
        foreach ( $period as $dt ){
            $date = $dt->format('d-m-Y');
            $model = IpsByDate::find()->where(['date'=>$date])->one();
            $userStats[$date]=count($model['ips']);
        }
        $labels = [];
        $sets = [];

        foreach($userStats as $k=>$s){
            $labels[] = Yii::$app->formatter->asDate($k, 'long');
            $sets[] = $s;
        }
        return Json::encode(['labels'=>$labels, 'set'=>$sets]);
    }







    public function actionLogin()
    {
        return Yii::$app->runAction('user/security/login');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPair($card = null, $email = null){

        $model = null;

        if($card <> null){
            $cardModel = SCCards::find()->where("number = $card")->one();
            if(!empty($cardModel)){
                $customer = SCCustomers::findOne($cardModel->customerID);
                if(empty($customer->Login)){
                    echo "Логин не указан";
                } else {
                    $model = $customer;
                }
            } else {
                echo "Карта не выгружена";
            }
        } elseif ($email <> null){
            $model = SCCustomers::find()->where("Email = '$email'")->andWhere('Login <> ""')->one();
        } else {
            echo 'asdasd';
        }

        if(!empty($model)){
            echo $model->Login." | ".base64_decode($model->cust_password);

        }



    }

    public function actionSec(){
        $model = SCSecondaryPagesLinks::find()->all();
        foreach ($model as $m){
            $parent = SCSecondaryPagesContainers::findOne($m->page_id);
            $pid = $parent->pageid;

            $container = SCSecondaryPagesContainers::find()->where(['pageid'=>$pid])->orderBy("order ASC")->one();
            $m->container_tmp = $container->id;
            $m->save();
        }
    }

    public function actionTest()
    {

        ini_set('max_execution_time', 90000);
        $productID = 117329;
        $categories = SCCategories::catGetSubCategoriesIds(102338);
        $categories = array_merge($categories, SCCategories::catGetSubCategoriesIds(104050));
        $categories = array_merge($categories, SCCategories::catGetSubCategoriesIds(255));
        $categories = array_merge($categories, SCCategories::catGetSubCategoriesIds(444));
        $categories = array_merge($categories, SCCategories::catGetSubCategoriesIds(557));
        $categories = array_merge($categories, SCCategories::catGetSubCategoriesIds(742));
        $categories = array_merge($categories, SCCategories::catGetSubCategoriesIds(6198));
        $categories = array_merge($categories, SCCategories::catGetSubCategoriesIds(4066));
        $categories = array_merge($categories, SCCategories::catGetSubCategoriesIds(4067));
        $categories = SCCategories::find()->where(['in', 'categoryID', $categories])->all();
        foreach ($categories as $cat){
            $model = SCRelatedCategories::find()->where(['categoryID'=>$cat->categoryID])->andWhere(['relatedCategoryID'=>$productID])->one();
            if(empty($model)){
                $model = new SCRelatedCategories;
                $model->categoryID = $cat->categoryID;
                $model->relatedCategoryID = $productID;
                $model->save(false);
            }
        }
    }
}
