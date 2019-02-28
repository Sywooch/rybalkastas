<?php

namespace backend\modules\kitmaker\controllers;

use common\models\SCCategories;
use common\models\UserActivity;
use common\models\UserNotifications;
use yii\web\Controller;
use common\models\SCKits;
use common\models\SCKitElements;
use yii\web\Session;
use yii\web\UploadedFile;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $model = SCKits::find()->all();
        return $this->render('index', ['model'=>$model]);
    }

    public function actionCreate()
    {
        $model = new SCKits();
        $beforeImage = $model->picture;

        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'picture');
            if (!empty($image)) {
                $filename = explode(".", $image->name);
                $ext = $filename[1];
                $model->picture = Yii::$app->security->generateRandomString(26) . ".{$ext}";
                $path = '/var/www/published/publicdata/TESTRYBA/attachments/SC/kits/' . $model->picture;
                $image->saveAs($path);
            } else {
                $model->picture = $beforeImage;
            }

            if ($model->save(false)) {
                if(isset($_POST['NewKitElement'])){
                    foreach($_POST['NewKitElement'] as $k=>$v){
                        $el = new SCKitElements();
                        $el->kit_id = $model->id;
                        $el->categoryID = $v['id'];
                        $el->ratio = $v['percent'];
                        $el->save();
                    }
                }
                $act = new UserActivity();
                $act->putActivity("Kits", $model->id, 'create');
                $notify = new UserNotifications();
                $notify->putMassNotify(\Yii::$app->user->id, "Создал комплект $model->name");
                $session = new Session();
                $session->setFlash('success', "Категория сохранена");
                return $this->redirect(['index']);
            }
        }

        return $this->render('create',['model'=>$model]);
    }

    public function actionEdit($id)
    {

    }

    public function actionLoadsubcatsajax(){
        $root = $_POST['root'];
        $type = 0;
        $main = $_POST['main'];

        $model = SCCategories::find()->where("parent = ".$root)->orderBy('sort_order')->all();

        return $this->renderAjax('modaltree', [
            'rootCats'=>$model,
            'type' =>$type,
            'main' =>$main,
        ]);
    }
}
