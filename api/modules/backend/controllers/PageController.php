<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 06.02.2019
 * Time: 13:07
 */

namespace api\modules\backend\controllers;


use api\components\Controller;
use common\models\SCAuxPages;
use yii\helpers\Json;

class PageController extends Controller
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
        $needed = SCAuxPages::find()->offset($offset)->orderBy(['aux_page_ID'=>SORT_DESC])->limit($perpage)->all();

        /*$filters = Json::decode($filters);
        foreach($filters as $field=>$filter){
            if(empty($filter)) continue;
            $needed = $needed->andWhere(['like', $field, $filter]);
        }*/
        $count = SCAuxPages::find()->count();
        //$needed = $needed->limit($perpage)->all();
        $res = [];
        foreach($needed as $page){
            $res[] = $page->toArray();
        }

        return ['count'=>$count, 'orders'=>$res, 'offset'=>$offset];
    }

    public function actionUpdate(){
        $id = $_POST['id'];
        $key = $_POST['key'];
        $value = $_POST['value'];

        $page = SCAuxPages::findOne($id);
        $page->{$key} = $value;
        $page->save();
    }

    public function actionPage($id){
        return SCAuxPages::findOne($id)->toArray();
    }
}