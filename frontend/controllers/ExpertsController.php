<?php
namespace frontend\controllers;

use common\models\SCExpertMessages;
use common\models\SCExperts;
use common\models\SCSecondaryPages;
use frontend\models\ExpertQuestion;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ExpertsController extends Controller
{

    public function actionIndex() {
        $model = SCExperts::find()
              ->where(['consult' => SCExperts::CAN_CONSULT])
            ->orderBy('sort_order ASC')
                ->all();

        if (empty($model)) Throw new NotFoundHttpException;

        return $this->render('index', [
            'model'=>$model
        ]);
    }

    public function actionExpert($id){
        $model = SCExperts::findOne($id);
        if(empty($model))Throw new NotFoundHttpException;

        $newPost = new \frontend\models\ExpertQuestion();
        if ($newPost->load(\Yii::$app->request->post())) {
            $model = new SCExpertMessages;
            $model->message = $newPost->message;
            $model->parent = !empty($newPost->post_id)?$newPost->post_id:0;
            $model->expert_id = $id;
            $model->user_id = \Yii::$app->user->id;
            $model->save();
            return $this->refresh();
        }


        $query = SCExpertMessages::find()->where(['expert_id' => $model->expert_id])->andWhere(['parent'=>0])->orderBy('created_at DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $messages = $query->offset($pages->offset)
            ->limit(10)
            ->all();

        return $this->render('expert', ['model'=>$model, 'messages'=>$messages, 'pages'=>$pages ]);
    }

    public function actionLoadform($id)
    {
        if(\Yii::$app->user->isGuest)return false;
        $check = SCExpertMessages::findOne($id);
        if(empty($check))Throw new NotFoundHttpException();
        $newPost = new \frontend\models\ExpertQuestion();
        return $this->renderAjax('_form', ['model'=>$check, 'newPost'=>$newPost]);
    }


    public function actionEdit($id)
    {
        if(!\Yii::$app->user->can('Employee'))return false;
        $check = SCExpertMessages::findOne($id);
        if(empty($check))Throw new NotFoundHttpException();

        if ($check->load(\Yii::$app->request->post())) {
            $check->save();
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        return $this->renderAjax('_form_edit', ['model'=>$check]);
    }

}