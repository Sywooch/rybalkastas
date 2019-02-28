<?php

namespace backend\modules\content\controllers;

use common\models\SCMainpage;
use common\models\SCMonufacturers;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }

    public function actionUpload(){
        $image = UploadedFile::getInstanceByName('pic');
        if(!empty($image)) {
            $filename = explode(".", $image->name);
            $ext = $filename[1];
            $newname = Yii::$app->security->generateRandomString(26);

            $pic = $newname.".{$ext}";

            $image->saveAs(Yii::getAlias('@frontend/web/img/content/' . $newname . '.' . $ext, ['quality' => 80]));

            $file = array();
            $file['name'] = $pic;
            $file['url'] = 'http://rybalkashop.ru/img/content/' .$pic;
            $file['thumbnailUrl'] = 'http://rybalkashop.ru/img/content/' .$pic;


            $files = array();
            $files['files'][] = $file;

            return json_encode($files);
        }
    }
}

?>