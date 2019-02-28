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
class AjaxController extends Controller
{
    public function actionTree(){
        echo '{
  id          : "string" // will be autogenerated if omitted
  text        : "string" // node text
  icon        : "string" // string for custom
  state       : {
    opened    : boolean  // is the node open
    disabled  : boolean  // is the node disabled
    selected  : boolean  // is the node selected
  },
  children    : []  // array of strings or objects
  li_attr     : {}  // attributes for the generated LI node
  a_attr      : {}  // attributes for the generated A node
}';
    }

    public function actionNotificationFeed(){
        $model = UserNotifications::find()->where("user_id =". \Yii::$app->user->id)->andWhere("shown = 0")->orderBy("id ASC")->count();

        if($model > 0){
            $ret = array();
            if($model == 1){
                $m = UserNotifications::find()->where("user_id =". \Yii::$app->user->id)->andWhere("shown = 0")->orderBy("id ASC")->one();
                $m->shown = 1;
                $m->save();
                $ret = [
                    [
                        'type' => $m->type,
                        'message' => $m->content,
                        'title' => (!empty($m->user->profile->name))?$m->user->profile->name:$m->user->username
                    ]
                ];
            } else {
                $m = UserNotifications::find()->where("user_id =". \Yii::$app->user->id)->andWhere("shown = 0")->orderBy("id ASC")->all();
                foreach($m as $ms){
                    $ms->shown = 1;
                    $ms->save();
                }
                $ret = [
                    [
                        'type' => 'info',
                        'message' => "У вас $model новых уведомлений",
                        'title' => "Оповещение"
                    ]
                ];
            }

            return \yii\helpers\Json::encode($ret);
        }


    }
}