<?php

namespace backend\modules\interaction\controllers;

use common\models\SCQuiz;
use common\models\SCQuizVariants;
use yii\web\Controller;
use Yii;
use yii\web\Session;

class QuizController extends Controller
{
    public function actionIndex()
    {
        $model = SCQuiz::find()->orderBy("id DESC")->all();
        return $this->render('index', ['model'=>$model]);
    }

    public function actionCreate(){
        $model = new SCQuiz;

        if(isset($_POST['SCQuiz'])){
            if(!isset($_POST['SCQuizVariantsNew']) || count($_POST['SCQuizVariantsNew']) < 2){
                $session = new Session;
                $session->setFlash('danger', "В опросе должно быть не менее 2 вариантов ответа");
                return $this->render('create', ['model'=>$model]);
            }

            $model->load(Yii::$app->request->post());
            $model->show = 0;
            $model->active = 0;
            if($model->save()){
                if(isset($_POST['SCQuizVariantsNew'])){
                    $new_vars = $_POST['SCQuizVariantsNew'];
                    foreach($new_vars as $k=>$v){
                        $nv = new SCQuizVariants;
                        $nv->quiz_id = $model->primaryKey;
                        $nv->name = $v['name'];
                        $nv->save(false);
                    }
                }
                $this->redirect(['/interaction/quiz']);
            } else {
                $session = new Session;
                $session->setFlash('danger', "Модель не сохранена");
            }



        }

        return $this->render('create', ['model'=>$model]);
    }

    public function actionView($id){
        $model = SCQuiz::find()->where("id = $id")->one();
        $variants = SCQuizVariants::find()->where("quiz_id = $id")->all();
    }

    public function actionEdit($id){
        $model = SCQuiz::find()->where("id = $id")->one();

        if(isset($_POST)){
            $model->load(Yii::$app->request->post());
            $model->save();
            if(isset($_POST['SCQuizVariants'])){
                $old_vars = $_POST['SCQuizVariants'];
                foreach($old_vars as $k=>$v){
                    $ov = SCQuizVariants::find()->where("id = $k")->one();
                    $ov->name = $v['name'];
                    $ov->save(false);
                }
            }

            if(isset($_POST['SCQuizVariantsNew'])){
                $new_vars = $_POST['SCQuizVariantsNew'];
                foreach($new_vars as $k=>$v){
                    $nv = new SCQuizVariants;
                    $nv->quiz_id = $id;
                    $nv->name = $v['name'];
                    $nv->save(false);
                }
            }

            if(isset($_POST['deleteVariant'])){
                $del_vars = $_POST['deleteVariant'];
                foreach($del_vars as $k=>$v){
                    $dv = SCQuizVariants::find()->where("id = $k")->one();
                    $dv->delete();
                }
            }
        }

        $variants = SCQuizVariants::find()->where("quiz_id = $id")->all();


        return $this->render('edit', ['model'=>$model, 'variants'=>$variants]);
    }

    public function actionRemove($id){

    }

    public function actionInsertVariant(){

    }

    public function actionEditVariant(){

    }

    public function actionDeleteVariant(){

    }
}
