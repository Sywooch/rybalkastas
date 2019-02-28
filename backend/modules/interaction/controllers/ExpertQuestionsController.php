<?php

namespace backend\modules\interaction\controllers;

use common\models\api\ChatAnswers;
use common\models\api\ChatOperatorConnections;
use common\models\api\ChatOperators;
use common\models\api\ChatQuestions;
use common\models\SCCustomers;
use common\models\SCExperts;
use yii\web\Controller;
use Yii;

class ExpertQuestionsController extends Controller
{
    public function actionIndex()
    {
        $activeOperators = ChatOperatorConnections::find()->all();
        $pages = SCExperts::find()->orderBy('expert_name')->all();
        return $this->render('index', ['pages'=>$pages]);
    }

    public function actionCreate()
    {
        $model = new SCExperts;
        if ($model->load(Yii::$app->request->post())) {

            echo $model->email;
            
            if(!$model->save()){
                print_r($model->getErrors());
                return;
            } else {
                $oper = new ChatOperators;
                $oper->email = $model->email;
                $oper->first_name = $model->expert_name;
                $oper->last_name = $model->expert_last_name;
                $oper->password = 1234;
                $oper->sc_id = $model->getPrimaryKey();
                $oper->save(false);

                $cust = new SCCustomers;
                $cust->Login = $model->email;
                $cust->cust_password = base64_encode('123456');
                $cust->Email = $model->email;
                $cust->first_name = $model->expert_name;
                $cust->last_name = $model->expert_last_name;



                $cust->save(false);
            }

            return $this->redirect(['index']);
        }
        return $this->render('create', ['model'=>$model]);
    }

    public function actionEdit($id)
    {
        $model = SCExperts::findOne($id);
        if ($model->load(Yii::$app->request->post())) {

            echo $model->email;

            if(!$model->save()){
                print_r($model->getErrors());
                return;
            }

            return $this->redirect(['index']);
        }
        return $this->render('create', ['model'=>$model]);
    }



    public function actionConnect($id)
    {
        $model = SCExperts::find()->where("expert_id = $id")->one();
        $connection = new ChatOperatorConnections;
        $connection->sc_page_id = $id;
        if ($connection->load(Yii::$app->request->post()) && $connection->save()) {
            return $this->redirect(['index']);
        }


        return $this->render('connect', ['model'=>$model, 'connection'=>$connection]);
    }

    public function actionBulkAnswer()
    {
        $model = ChatQuestions::find()->orderBy('date DESC')->all();

        return $this->render('bulk-answer', ['model'=>$model]);
    }

    public function actionPutAnswer(){
        $id = $_POST['id'];
        $model = new ChatAnswers;
        $model->question_id = $id;
        $model->content = $_POST['answer'];
        $model->save();
        echo $id;
    }

    public function actionDeletePost($id){
        $model = ChatQuestions::findOne($id);
        $model->delete();

        return $this->redirect(['bulk-answer']);
    }

    public function beforeAction($action)
    {
        if ($action->id == 'create') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
}
