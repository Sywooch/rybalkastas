<?php

namespace console\controllers;

use common\models\SCProducts;
use yii\imagine\Image;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class MigrationsController extends Controller
{
    public function actionImages()
    {
        $model = SCProducts::find()->limit(10)->all();
        $mainFolder = '/var/www/html/frontend/web/img/';
        
        foreach ($model as $m){
            $pics = $m->pictures;
            $folderName = substr($m->productID, 0, 2);
            $folderPath = $mainFolder.$folderName;
            $folderPathOriginal = $mainFolder.$folderName.'/original/';
            $folderPathCompressed = $mainFolder.$folderName.'/compressed/';
            $folderPathThumb = $mainFolder.$folderName.'/thumb/';
            @mkdir($folderPath, 0777);
            @mkdir($folderPathOriginal, 0777);
            @mkdir($folderPathCompressed, 0777);
            @mkdir($folderPathThumb, 0777);
            foreach ($pics as $pic){


                $original = $pic->filename;
                if(empty($original)){
                    $original = $pic->enlarged;
                }

                $filename = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
                $file = file_get_contents('http://rybalkashop.ru/published/publicdata/TESTRYBA/attachments/SC/products_pictures/'.$original);
                $ext = preg_match('/\.\w+$/', $original, $matches);
                $ext = $matches[0];

                file_put_contents($folderPathOriginal.$filename.$ext, $file);
                
                Image::thumbnail($folderPathOriginal.$filename.$ext, 512, 512)->save($folderPathCompressed, ['quality'=>50]);

            }
            echo $m->categoryID.' ..Done'.PHP_EOL;
        }
    }
}