<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 15.02.2019
 * Time: 9:30
 */

namespace api\modules\backend\controllers;


use common\models\InnerOrder;
use common\models\SCHtmlBlocks;
use Faker\Calculator\Inn;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\rest\Controller;

class HtmlBlocksController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
            ]
        ]);
    }

    public function actionIndex($perpage = 20, $page = 1){
        $query = SCHtmlBlocks::find()->orderBy(['id'=>SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount'=>$countQuery->count(), 'pageSize'=>$perpage]);
        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return ['items'=>$models, 'pages'=>$pages];
    }

    public function actionBlock($id){
        return SCHtmlBlocks::findOne($id);
    }

    public function actionUpdate(){
        $payload = \Yii::$app->request->post('payload');
        if(empty($payload)) Throw new \Exception('Payload not found!');
        $data = Json::decode($payload);
        $id = $data['id'];
        if(empty($id)){
            $model = new SCHtmlBlocks();
        } else {
            $model = SCHtmlBlocks::findOne($id);
        }

        $content = Json::encode($data['content']);

        $model->key = $data['key'];
        $model->name = $data['name'];
        $model->content = $content;
        $model->save();

        return SCHtmlBlocks::findOne($model->getPrimaryKey());;
    }

    public function actionDelete($id){
        SCHtmlBlocks::deleteAll(['id'=>$id]);
        return true;
    }
}