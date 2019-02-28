<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 25.09.2017
 * Time: 14:52
 */

namespace backend\modules\im\assets;


use yii\web\AssetBundle;

class ImAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/im/assets';
    public $css = [
        'css/im.css',
    ];
    public $js = [
        'js/timeago.js',
        'js/timeago.locales.js',
    ];
    public $publishOptions = [
        'forceCopy'=>true,
    ];
}