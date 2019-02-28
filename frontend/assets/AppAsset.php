<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/styles.min.css',
        'css/buttons.css',
        'css/elements.css',
        'css/font-awesome.min.css',
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css',
        'css/slick-theme.css',
        'css/sweetalert2.min.css',
        'css/ax5toast.css',
        'css/bootstrap-slider-text-input.min.css',
        'css/jquery.toast.min.css',
    ];
    public $js = [
        'js/owl.carousel.min.js',
        'js/scripts.js',
        'js/jquery.slimscroll.min.js',
        'js/jquery.inputmask.bundle.min.js',
        'js/icheck.js',
        'js/core-js.js',
        'js/jquery.plugin.min.js',
        'js/jquery.countdown.min.js',
        'js/jquery.countdown-ru.js',
        'js/sweetalert2.min.js',
        'js/jquery.sticky-kit.js',
        'js/sticky-sidebar.js',
        'js/ax5-core.js',
        'js/ax5toast.js',
        'js/bootstrap-slider-text-input.min.js',
        'js/jquery.toast.min.js',
        //'js/kicker.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
