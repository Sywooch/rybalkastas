<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'plugins'],
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'timeZone' => 'Europe/Moscow',
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => ['http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js'],
                    'jsOptions' => ['type' => 'text/javascript'],
                ],
            ],
        ],
        'request' => [
            'enableCsrfValidation'=>false,
            //'csrfParam' => '_csrf-backend',
            'baseUrl' => '',
        ],
        'plugins' => [
            'class' => lo\plugins\components\PluginsManager::class,
            'appId' => 1,
            // by default
            'enablePlugins' => true,
            'shortcodesParse' => true,
            'shortcodesIgnoreBlocks' => [
                '<pre[^>]*>' => '<\/pre>',

            ]
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'alertcomponent' => [
            'class' => 'backend\components\AlertComponent',
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '',
            'hostInfo' => 'http://rybalkashop.ru',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
        ],

        'imagecache' => [
            'class' => 'frontend\components\ImageCache',
            // the below paths depend very much on your image upload setup
            'sourcePath' => Yii::getAlias('@frontend/web/img'), // base path to your uploads dir
            'cachePath' => '/cache', // relative path to your uploads dir
            'cacheUrl' => '/img', // relative path to your uploads dir
        ],
        'imageman'=>[
            'class' => 'frontend\components\ImageMan',
            'imageFolder' => Yii::getAlias('@frontend/web/img'),
            'cacheFolder' => Yii::getAlias('@frontend/web/img/cache'),
            'imageFolderUrl' => '/img',
            'cacheFolderUrl' => '/img/cache',
            'watermarks' =>
                [
                    'main' => Yii::getAlias('@frontend/web/img/rswater.png')
                ]
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/cache'
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            /*'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js'=>['js/jquery.js']
                ],
            ],*/
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'modelMap' => [
                'Profile' => 'common\models\Profile',
            ],
            'admins' => ['Sunderland'],
            'adminPermission'=>'superField'
        ],
        'plugins' => [
            'class' => 'lo\plugins\Module',
            'pluginsDir'=>[
                '@lo/plugins/core', // default dir with core plugins
                '@lo/shortcodes',
            ]
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule',
        ],

        'admin' => [
            'class' => 'mdm\admin\Module',
        ],

        'interaction' => [
            'class' => 'backend\modules\interaction\Module',
        ],


        'content' => [
            'class' => 'backend\modules\content\Module',
        ],

        'settings' => [
            'class' => 'yii2mod\settings\Module',
            // Also you can override some controller properties in following way:

        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'ut' => [
            'class' => 'backend\modules\ut\Module',
        ],

        'plant' => [
            'class' => 'backend\modules\plant\Module',
        ],
        'tasks' => [
            'class' => 'backend\modules\tasks\Module',
        ],
        'yandexexcel' => [
            'class' => 'backend\modules\yandexexcel\Module',
        ],
        'im' => [
            'class' => 'backend\modules\im\Module',
        ],
        'reports' => [
            'class' => 'backend\modules\reports\Module',
        ],
    ],
    'as access' => [
        'class' => \yii\filters\AccessControl::className(),//AccessControl::className(),
        'rules' => [
            [
                'actions' => ['login'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['Employee'],
            ],
        ],
    ],
    'params' => $params,
];
