<?php

namespace backend\controllers;

use common\models\UserActivity;
use common\models\UserFollowers;
use dektrium\user\models\User;
use Yii;
use common\models\SCCategories;
use common\models\SCCategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for SCCategories model.
 */
class OuserController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()->all();
        return $this->render('index', ['users'=>$users]);
    }

    public function actionUser($id)
    {
        $model = User::find()->where("id = $id")->one();
        $activity = UserActivity::find()->where("user_id = $id")->orderBy("date DESC")->all();
        return $this->render('user',
            [
                'model'=>$model,
                'activity'=>$activity,
        ]
        );
    }

    public function actionFollow($id){
        $check = UserFollowers::find()->where("follower_id = ".Yii::$app->user->identity->getId())->andWhere("user_id = $id")->one();
        if(!empty($check)){
            throw new \yii\web\HttpException(500, 'Connection already exists.');
        }

        $model = new UserFollowers;
        $model->user_id = $id;
        $model->follower_id = Yii::$app->user->identity->getId();
        $model->save();
    }

    public function actionUnfollow($id){
        $model = UserFollowers::find()->where("follower_id = ".Yii::$app->user->identity->getId())->andWhere("user_id = $id")->one();
        $model->delete();
    }
}