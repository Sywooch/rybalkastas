<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'absence', 'autolink', 'relinker'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru',
    'timeZone' => 'Europe/Moscow',

    'components' => [

        'view' => [
            'class' => common\components\View::class,
            'theme' => [
                'basePath' => '@app/themes/base',
                'baseUrl' => '@web/themes/base',
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user',
                    '@app/views' => '@app/themes/base',
                ],
            ],
        ],
        /*'view' => [
            'class' => '\rmrevin\yii\minify\View',
            'enableMinify' => true,
            'concatCss' => true, // concatenate css
            'minifyCss' => true, // minificate css
            'concatJs' => true, // concatenate js
            'minifyJs' => true, // minificate js
            'minifyOutput' => true, // minificate result html page
            'web_path' => '@web', // path alias to web base
            'base_path' => '@webroot', // path alias to web base
            'minify_path' => '@webroot/min', // path alias to save minify result
            'js_position' => [ \yii\web\View::POS_LOAD ], // positions of js files to be minified
            'force_charset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expand_imports' => true, // whether to change @import on content
            'compress_options' => ['extra' => true], // options for compress
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],*/
        'autolink' => [
            'class'=>'frontend\components\AutoLink'
        ],
        'relinker' => [
            'class'=>'frontend\components\Relinker'
        ],
        'absence' => [
            'class' => 'frontend\components\absence\Absence',
        ],
        'request' => [
            'enableCsrfValidation' => false,
            'baseUrl' => '',
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

        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                /*[
                    'pattern'=>'lols/asdlol',
                    'route' => 'shop/category',
                    'defaults' => ['id' => 3310]
                ],*/
                'tournaments' => 'tournaments/index',
                'sponsorship' => 'sponsorship/index',
                ['pattern' => 'yandex-market', 'route' => 'YandexMarketYml/default/index', 'suffix' => '.yml'],
                '' => 'site/index',
                '<action>' => 'site/<action>',
                'thumbs/<path:.*>' => 'site/thumb',

                //['pattern'=>'page/shops', 'route'=>'page/shops'],
                ['pattern'=>'page/<slug>', 'route'=>'page/index'],
            ],
        ],

        'urlManagerBackend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '',
            'hostInfo' => 'http://admin.rybalkashop.ru',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
        ],

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
            ],
        ],

        'bot' => [
            'class' => 'SonkoDmitry\Yii\TelegramBot\Component',
            'apiToken' => '368483985:AAGZkTncS5jdbz_RJ7BVQsITvtE-Q5dRLJE',
        ],

        'errorHandler' => [
            //'class' => 'common\components\SiteErrorHandler',
            'errorAction' => 'site/error',
        ],

        'cart' => [
            'class' => 'dvizh\cart\Cart',
            'currency' => 'р.', //Валюта
            'currencyPosition' => 'after', //after или before (позиция значка валюты относительно цены)
            'priceFormat' => [2, '.', ''], //Форма цены
            'as discount' => [
                'class' => 'frontend\behaviors\CartDiscount',
            ],

        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LdcehoUAAAAAHQ2tk1ENqxsjS2SYaLUBGkmfw_K',
            'secret' => '6LdcehoUAAAAAGW36G4Y_CEmMBp5LE0vEveLisP6',
        ],

        "recaptcha" => [
            "class" => "alexeevdv\\recaptcha\\Recaptcha",
            "siteKey" => "6LdcehoUAAAAAHQ2tk1ENqxsjS2SYaLUBGkmfw_K",
            "secret" => "6LdcehoUAAAAAGW36G4Y_CEmMBp5LE0vEveLisP6",
        ],

        'assetManager' => [
            'appendTimestamp' => true,
        ],



    ],
    'modules' => [
        'comment' => [
            'class' => 'yii2mod\comments\Module',
            
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [
                'settings' => 'frontend\controllers\PrivateController',
                'recovery' => 'frontend\controllers\RecoveryController',
                'admin' => [
                    'class' => 'frontend\controllers\UserAdminController',
                ],
            ],
            'modelMap' => [
                'User' => 'common\models\User',
                'Profile' => 'common\models\Profile',
                'LoginForm' => 'frontend\models\LoginForm',
                'RegistrationForm' => 'frontend\models\RegistrationForm',
                'SettingsForm' => 'frontend\models\SettingsForm',
                'ResentForm' => 'frontend\models\ResentForm',
                'RecoveryForm' => 'frontend\models\RecoveryForm',
            ],
            'enableConfirmation'=>false,
            'adminPermission'=>'Employee'

        ],
        'YandexMarketYml' => [
            'class' => 'corpsepk\yml\YandexMarketYml',
            'enableGzip' => true, // default is false
            'cacheExpire' => 1, // 1 second. Default is 24 hours
            'categoryModel' => 'common\models\SCCategories',
            'shopOptions' => [
                'name' => 'Рыболов на Птичке',
                'company' => 'ИП Русяев Максим Васильевич',
                'url' => 'http://rybalkashop.ru',
                'currencies' => [
                    [
                        'id' => 'RUR',
                        'rate' => 1
                    ]
                ],
            ],
            'offerModels' => [
                ['class' => 'common\models\SCProducts'],
            ],
        ],
        'rbac' => [
            'class'=>'dektrium\rbac\RbacWebModule',
            'adminPermission'=>'headField'
        ],
        /*'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['176.107.242.44'],
        ]*/
    ],
    'params' => $params,
];
