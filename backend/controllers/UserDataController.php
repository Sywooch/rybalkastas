<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 23.11.2017
 * Time: 13:43
 */

namespace backend\controllers;

use common\models\SCCustomers;
use common\models\SCOrders;
use yii\db\Expression;
use yii\web\Controller;

class UserDataController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetUsers()
    {
        $users = [];
        if(!empty($_POST)){
            $query = SCOrders::find()
                ->select(['customerID', 'user_phone', 'customer_firstname', 'customer_lastname', 'customer_email', new Expression('SUM(order_amount) as sum')])
                ->groupBy('customerID')
                ->orderBy('sum DESC');
            $users = $query->asArray()->all();

            foreach ($users as $k=>$user){
                if($user['sum'] < $_POST['min_sum']){
                    unset($users[$k]);
                }
            }
        }
        return $this->render('get-users', ['users'=>$users]);
    }

}