<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php')
);

return [
    'id' => 'app-rest',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','debug'],
    'controllerNamespace' => 'rest\controllers',
    'language' => 'ru',
    'modules'=> [
        'ut' => [
            'class' => 'rest\modules\ut\Module',
        ],
        'debug'=>[
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['95.84.214.67','176.107.242.44','95.84.217.85','37.204.53.246', '::1']
        ]
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<action>' => 'site/<action>',
                'thumbs/<path:.*>' => 'site/thumb',
            ],
        ],
        'bot' => [
            'class' => 'SonkoDmitry\Yii\TelegramBot\Component',
            'apiToken' => '368483985:AAGZkTncS5jdbz_RJ7BVQsITvtE-Q5dRLJE',
        ],
        'request' => [
            'cookieValidationKey' => md5('asdFw42Q'),
        ],

    ],
    'as access' => [
        'class' => \yii\filters\AccessControl::className(),//AccessControl::className(),
        'rules' => [
            [
                'actions' => ['index'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'ips' => ['176.107.242.44', '195.98.179.222', '176.107.242.44', '82.199.121.213', '95.84.217.85','37.204.53.246', '178.214.34.200'],
            ],
        ],
        'denyCallback' => function($rule, $action) {
            throw new \yii\web\ForbiddenHttpException();
        }
    ],
    'params' => $params,
];
