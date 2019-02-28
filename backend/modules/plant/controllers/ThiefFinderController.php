<?php

namespace backend\modules\plant\controllers;

use common\models\SCOrderedCarts;
use common\models\SCProductOptionsCategoryes;
use common\models\SCProductOptionsValues;
use common\models\SCProducts;
use common\modules\plant\models\ThiefForm;
use yii\web\Controller;
use common\models\SCCategories;
use common\models\UserActivity;
use common\models\UserNotifications;
use yii\web\Session;

class ThiefFinderController extends Controller
{
    public function actionIndex(){
        $model = new ThiefForm();

        if(!empty($_POST)){
            $items = $_POST['ThiefForm']['positions'];
            $positions = explode(',', $items);
            foreach($positions as $k=>$pos){
                $positions[$k] = trim($pos);
            }
            $positions=array_filter($positions);
            $positions = implode('|', $positions);
            $cart_positions = SCOrderedCarts::find()->select('orderID')->where("name REGEXP '$positions'")->all();




            return $this->render("results", ['model'=>$cart_positions]);

        } else {
            return $this->render("index", ['model'=>$model]);
        }

    }
}