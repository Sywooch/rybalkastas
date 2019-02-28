<?php

return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],
    'controllerNamespace' => 'api\controllers',
    'language' => 'ru',
    'components' => [

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<action>' => 'site/<action>',
                'thumbs/<path:.*>' => 'site/thumb',
            ],
        ],
        'request' => [
            'cookieValidationKey' => md5('asdFw42Q'),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false
        ],
    ],
    'params' => [
        'tempAuth' => 'a9s8dalxsjdhas-d987'
    ],
];
