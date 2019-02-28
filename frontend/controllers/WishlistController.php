<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 22.05.2017
 * Time: 9:28
 */

namespace frontend\controllers;

use common\models\SCLaterProducts;
use yii\web\Controller;

class WishlistController extends Controller{

    public function actionIndex()
    {
        $model = SCLaterProducts::find()->where(['userID'=>\Yii::$app->user->identity->customer->customerID])->all();
        return $this->render('index', ['model'=>$model]);
    }

}