<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 29.08.2016
 * Time: 10:50
 */
namespace backend\controllers;


use common\models\SCCustomers;
use common\models\SCNotifications;
use yii\base\Controller;
use Yii;
class NotificationController extends Controller
{
    public function actionIndex(){
        $model = new \common\models\SCNotifications;
        if ($model->load(Yii::$app->request->post())) {
            $ar = array();
            $users = SCCustomers::find()->select(['customerID'])->where("Login <> ''")->all();
            foreach($users as $user){
                $ar[] = $user->customerID;
            }


            foreach($ar as $a){
                $n = new SCNotifications;
                $n->mini_text = $model->mini_text;
                $n->full_text = $model->full_text;
                $n->customerID = $a;
                if(!$n->save()){
                    print_r($n->getErrors());
                }

            }
        }
        return $this->render('index',['model'=>$model]);
    }
}