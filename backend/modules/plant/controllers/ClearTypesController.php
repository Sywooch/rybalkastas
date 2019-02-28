<?php

namespace backend\modules\plant\controllers;

use common\models\SCProductOptionsCategoryes;
use common\models\SCProductOptionsValues;
use common\models\SCProducts;
use yii\web\Controller;
use common\models\SCCategories;
use common\models\UserActivity;
use common\models\UserNotifications;
use yii\web\Session;

class ClearTypesController extends Controller
{
    public function actionIndex(){
        if(isset($_POST['clear'])){
            SCProductOptionsValues::deleteAll("option_value_ru = ''");
            $session = new Session;
            $session->setFlash('success', "Лишние атрибуты удалены");
        }
        return $this->render("index");
    }
}