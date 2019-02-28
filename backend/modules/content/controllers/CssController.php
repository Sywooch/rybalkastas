<?php

namespace backend\modules\content\controllers;

use common\models\CssFiles;
use common\models\SCMonufacturers;
use yii\web\Controller;
use Yii;

class CssController extends Controller
{
    public function actionIndex()
    {
        $model = CssFiles::find()->where("is_backup = 0")->all();
        return $this->render('index', ['model'=>$model]);
    }

    public function actionEdit($id)
    {
        $model = CssFiles::find()->where("id = $id")->one();
        $backups = CssFiles::find()->where("is_backup = 1 AND backup_of = $model->id")->orderBy("id DESC")->limit(6)->all();
        $path = $model->path;

        $file = $path.$model->name;
        if(isset($_POST['data'])){
            $backuppath = '/var/www/backup_files/';
            $old = file_get_contents($file, true);
            $ts = time()+4*60*60;
            $filename = explode('.', $model->name)[0];
            $ext = explode('.', $model->name)[1];

            $backupname = "$id-$filename-$ts.$ext";
            file_put_contents($backuppath.$backupname, $old);

            $backup = new CssFiles;
            $backup->name = $backupname;
            $backup->path = $backuppath;
            $backup->description = "Резервная копия $model->name (".date("Y-m-d H:i:s", $ts).")";
            $backup->is_backup = 1;
            $backup->backup_of = $model->id;
            if($backup->save()){
                file_put_contents($file, $_POST['data']);
            }
        }


        $data = file_get_contents($file, true);
        return $this->render('edit',['data'=>$data, 'model'=>$model, 'backups'=>$backups]);
    }
}
