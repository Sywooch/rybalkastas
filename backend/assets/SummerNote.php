<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author  Dmitriy Mosolov
 * @version 1.0 / dated 18.10.2018
 */
class SummerNote extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/summernote.css'
    ];
    public $js = [
        'js/summernote.min.js',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'backend\assets\CodeMirror',
    ];
}
