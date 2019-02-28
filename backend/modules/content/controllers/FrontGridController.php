<?php

namespace backend\modules\content\controllers;

use common\models\SCMainpage;
use common\models\SCMonufacturers;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class FrontGridController extends Controller
{
    public function actionIndex()
    {
        $model = SCMainpage::find()->all();
        $newgrid = new SCMainpage;
        return $this->render('index', ['model'=>$model, 'newgrid'=>$newgrid]);

    }

    public function actionSerialize()
    {
        if(!isset($_POST['SCMainpage']))return 'Nothing to serialize';

        foreach($_POST['SCMainpage'] as $id => $data){
            $model = SCMainpage::find()->where("id = $id")->one();
            $model->x = $data['x'];
            $model->y = $data['y'];
            $model->width = $data['width'];
            $model->height = $data['height'];
            if($model->save())
                continue;
            else
                return 'Error on save';
        }

        return 'Good';
    }

    public function actionInsert()
    {
        $image = UploadedFile::getInstanceByName('SCMainpage[picture]');
        if(!empty($image)){
            $filename = explode(".", $image->name);
            $ext = $filename[1];
            $newname = Yii::$app->security->generateRandomString(26);
            $pic = $newname.".{$ext}";
            $image->saveAs(Yii::getAlias('@frontend/web/img/mainpage/start/'.$pic), ['quality' => 80]);
            $model = new SCMainpage;
            $model->picture = $pic;
            $model->url = $_POST['SCMainpage']['url'];
            $model->fieldset = 10;
            $model->x = $model->y = $model->width = $model->height = 1;
            if($model->save()){
                $grid = SCMainpage::find()->all();
                return $this->renderAjax('_grid', ['model'=>$grid]);
            }
        }
    }

    public function actionRemove()
    {
        if(!isset($_POST['id']))return 'Nothing to remove';

        $id = $_POST['id'];
        $model = SCMainpage::find()->where("id = $id")->one();
        if($model->delete()){
            $grid = SCMainpage::find()->all();
            return $this->renderAjax('_grid', ['model'=>$grid]);
        }
    }
}
