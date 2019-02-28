<?php

if(!empty($_SERVER["HTTP_CF_CONNECTING_IP"])){
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

if($_SERVER['HTTP_HOST'] <> 'rybalkashop.ru'){
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url = str_replace($_SERVER['HTTP_HOST'], 'rybalkashop.ru', $actual_link);
    header('Location: '.$url, true, 301);
    exit;
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');
date_default_timezone_set('Europe/Moscow');
ini_set("memory_limit","4096M");
ini_set('max_execution_time', 9000);

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

Yii::$classMap['dvizh\cart\models\tools\CartQuery'] = '@frontend/models/modules/CartQuery.php';

$beginUrl = $_SERVER['REQUEST_URI'];

(new yii\web\Application($config))->run();
