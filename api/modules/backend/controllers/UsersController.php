<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 07.02.2019
 * Time: 14:54
 */

namespace api\modules\backend\controllers;

use api\components\Controller;

use common\models\User;

class UsersController extends Controller
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
            ]
        ]);
    }

    public function actionIndex($perpage = 30, $page = 1, $filters = null){
        ob_start('ob_gzhandler');
        //               50        -     50 -          49
        $offset = $perpage * $page - ($perpage - 1);
        $needed = User::find()->offset($offset)->orderBy(['id'=>SORT_DESC])->limit($perpage)->all();

        /*$filters = Json::decode($filters);
        foreach($filters as $field=>$filter){
            if(empty($filter)) continue;
            $needed = $needed->andWhere(['like', $field, $filter]);
        }*/
        $count = User::find()->count();
        //$needed = $needed->limit($perpage)->all();
        $res = [];
        foreach($needed as $user){
            $res[] = $user->toArray();
        }

        return ['count'=>$count, 'orders'=>$res, 'offset'=>$offset];
    }

    public function actionUpdate(){
        $id = $_POST['id'];
        $key = $_POST['key'];
        $value = $_POST['value'];

        $user = User::findOne($id);
        $user->{$key} = $value;
        $user->save();
    }

    public function actionUser($id){
        return User::findOne($id)->toArray();
    }
}