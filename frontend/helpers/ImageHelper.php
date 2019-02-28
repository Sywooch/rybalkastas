<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.03.2017
 * Time: 12:06
 */

namespace frontend\helpers;

class ImageHelper
{
    public static function loadImage($filename = null)
    {

        if(!empty($filename)){
            $imgUrl = \Yii::$app->params['imgUrl'].'/'.$filename;
            $img = $imgUrl;
        } else {
            $img = '/img/onDesign.jpg';
        }


        return $img;
    }

    public static function loadImageAbs($filename = null){
        if(!empty($filename)){
            $imgUrl = \Yii::$app->params['oldUrl'].'/'.$filename;
            $img = $imgUrl;
        } else {
            $img = '/img/onDesign.jpg';
        }


        return $img;
    }

    public static function thumbImage($filename = null){
        $imagecache = new ImageCache();
        $imagecache->is_remote = true;
        $imagecache->cached_image_directory = '/var/www/html/frontend/web/img/cache/.';
        $imgUrl = \Yii::$app->params['imgUrl'].$filename;

        return $imagecache->cache($imgUrl);
    }
}