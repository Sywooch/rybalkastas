<?php

namespace backend\controllers;

use common\models\UserNotifications;
use Yii;
use common\models\SCCategories;
use common\models\SCCategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for SCCategories model.
 */
class CacheController extends Controller
{
    public function actionIndex()
    {
        if(isset($_POST['clearFrontend']))
            $link = Yii::getAlias('@frontend/runtime/cache/*');
        if(isset($_POST['clearBackend']))
            $link = Yii::getAlias('@backend/runtime/cache/*');
        if(isset($_POST['clearImages']))
            $link = Yii::getAlias('@frontend/web/img/cache/*');


        return $this->render('index');
    }

    public function actionData()
    {
        set_time_limit(99999);
        if(isset($_POST['clear'])){
            $link = Yii::getAlias('@frontend/runtime/cache/*');
            $this->unlink_files($link);
        }

        return $this->render('data');
    }

    public function actionPages()
    {
        set_time_limit(99999);
        if(isset($_POST['clear'])){
            Yii::$app->dbCache->flush();
        }

        return $this->render('pages');
    }

    public function actionImages()
    {
        if(isset($_POST['clear'])){
            $link = Yii::getAlias('@frontend/web/img/cache/*');
            $this->unlink_files($link);
        }

        return $this->render('images');
    }

    function unlink_files($link)
    {
        $files = $this->glob_recursive($link);
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file

        }
    }

    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
        {
            $files = array_merge($files, $this->glob_recursive($dir.'/'.basename($pattern), $flags));
        }
        return $files;
    }
}