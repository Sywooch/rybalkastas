<?php

namespace backend\controllers;

use common\models\User;

class UserAdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = User::find()->all();
        return $this->render('index');
    }

    public function actionManage()
    {
        return $this->render('manage');
    }

    public function actionRegister()
    {
        return $this->render('register');
    }

}
