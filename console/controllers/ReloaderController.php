<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 13.03.2018
 * Time: 12:39
 */

namespace console\controllers;

use common\models\SCProductPictures;
use common\models\SCProducts;
use Imagine\Imagick\Imagine;
use yii\helpers\FileHelper;
use yii\imagine\Image;

class ReloaderController extends \yii\console\Controller{

    public function actionReload()
    {
        $folder = \Yii::getAlias('@frontend/web/reload/');
        $scanned_directory = array_diff(scandir($folder), array('..', '.'));
        $undone = 0;
        foreach($scanned_directory as $file){
            $parts = pathinfo($file);
            $name = $parts['filename'];
            $ext = $parts['extension'];
            $model = SCProducts::find()->where(['like', 'name_ru', $name])->one();
            $base_path = \Yii::getAlias('@frontend');
            if(!empty($model)){
                echo $model->name_ru.PHP_EOL;
                SCProductPictures::deleteAll(['productID'=>$model->productID]);
                $newname = \Yii::$app->security->generateRandomString(26);
                $path = $base_path . '/web/img/products_pictures/' .$newname.'_enl.'.$ext;
                $image = new \Imagine\Gd\Imagine();
                $image->open($folder.$file)->save($base_path . '/web/img/products_pictures/' .$newname.'_enl.'.$ext);
                $pic = $newname.".{$ext}";

                Image::thumbnail($path, 150, 150)
                    ->save($base_path . '/web/img/products_pictures/'.$newname.'_thm.'.$ext, ['quality' => 80]);

                Image::thumbnail($path, 300, 300)
                    ->save($base_path . '/web/img/products_pictures/'.$newname.'.'.$ext, ['quality' => 80]);

                $modelp = new SCProductPictures;
                $modelp->filename = $pic;
                $modelp->thumbnail = $newname.'_thm.'.$ext;
                $modelp->enlarged = $newname.'_enl.'.$ext;
                $modelp->productID = $model->productID;
                $modelp->priority = 1;
                $modelp->save();

            } else {
                $undone++;
            }
        }
        echo $undone.PHP_EOL;
    }

}