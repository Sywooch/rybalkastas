<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CodeMirror extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/codemirror.css',
        'css/codemirror-monokai-theme.css',
    ];
    public $js = [
        'js/codemirror.js',
        'js/codemirror-active-line.js',
        'js/codemirror-closetag.js',
        'js/codemirror-xml-fold.js',
        'js/codemirror-matchtags.js',
        'js/xml.js',
        'js/html.js',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
}
