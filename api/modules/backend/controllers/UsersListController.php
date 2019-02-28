<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 07.02.2019
 * Time: 14:54
 */

namespace api\modules\backend\controllers;


use common\models\SCCategories;
use common\models\SCProducts;
use common\models\User;
use yii\helpers\Json;

class UsersListController extends \api\components\Controller
{

    public function actionUsers()
    {

$res = [];
        $users = User::find()->all();
        foreach ($users as $user) {
            $res[] = [
                'username'=>$user->username];
        }


        return ['users' => $res];
    }


}