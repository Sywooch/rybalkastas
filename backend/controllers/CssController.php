<?php

namespace backend\controllers;

use common\models\UserNotifications;
use Yii;
use common\models\SCCategories;
use common\models\SCCategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for SCCategories model.
 */
class CssController extends Controller
{
    public function actionIndex(){
        return $this->render("index");
    }


}