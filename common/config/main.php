<?php
return [
    'language' => 'ru',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'pageCache' => [
            'class' => 'yii\caching\DummyCache'
        ],

        'fragmentCache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/fragmentCache',
        ],

        'dbCache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'dbc',
            'cacheTable' => 'cache',
        ],

        /*'dbCache' => [
            'class' => 'yii\caching\DummyCache'
        ],*/

        'glide' => [
            'class' => 'trntv\glide\components\Glide',
            'sourcePath' => '@frontend/web/img',
            'cachePath' => '@frontend/web/img/cached',
            'signKey' => '<random-key>' // "false" if you do not want to use HTTP signatures
        ],

        'cacheRedis' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 0,
            ],

        ],

        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager', // or use 'yii\rbac\PhpManager'
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],

        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
        ],

        'formatter' => [
            'defaultTimeZone' => 'Europe/Moscow'
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'support@rybalkashop.ru',
                'password' => 'md123456md',
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
        ],

        'mailer_s' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'contacts@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
        ],

        'mailer_sendmail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_MailTransport',
            ],
            'viewPath' => '@frontend/views/mail',
        ],

        /**
         * Мэйлер для оповещения об успешном
         * формировании заказа на сайте
         */

        //noReply
        'mailer_no_reply' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'noreply@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'noreply@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //contactsMailer
        'mailer_contacts' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'contacts@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'contacts@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        /**
         * Мэйлеры под каждую пару продавцов
         */

        //DZ #1
        'mailer_dz_1' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'dz.1@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'dz.1@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //DZ #2
        'mailer_dz_2' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'dz.2@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'dz.2@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //DZ #3
        'mailer_dz_3' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'dz.3@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'dz.3@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //MD #1
        'mailer_md_1' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'md.1@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'md.1@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //MD #2
        'mailer_md_2' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'md.2@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'md.2@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //MD #3
        'mailer_md_3' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'md.3@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'md.3@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //BR #1
        'mailer_br_1' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'br.1@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'br.1@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //BR #2
        'mailer_br_2' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'br.2@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'br.2@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //BR #3
        'mailer_br_3' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'br.3@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'br.3@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //KK #1
        'mailer_kk_1' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'kk.1@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'kk.1@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //KK #2
        'mailer_kk_2' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'kk.2@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'kk.2@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //KK #3
        'mailer_kk_3' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'kk.3@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'kk.3@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //PR #1
        'mailer_pr_1' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'pr.1@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'pr.1@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //PR #2
        'mailer_pr_2' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'pr.2@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'pr.2@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //PR #3
        'mailer_pr_3' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'pr.3@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'pr.3@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        //PR #4
        'mailer_pr_4' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => [
                    'pr.4@rybalkashop.ru' => 'RybalkaShop.Ru - Рыболов на "Птичке"'
                ]
            ],
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'pr.4@rybalkashop.ru',
                'password'   => 'fhjuna',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
        ],

        'i18n' => [
            'translations' => [
                'yii2mod.settings' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/settings/messages',
                ],
                // ...
            ],
        ],

        'soap' => [
            'class' => 'mongosoft\soapclient\Client',
            'url' => 'http://89.223.24.77/srv/UT/ws/SiteSync/?wsdl',
            'options' => [
                'login' => 'siteabserver',
                'password' => 'revresbaetis',
                'cache_wsdl' => WSDL_CACHE_NONE,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                'location' => str_replace('?wsdl', '', $url)
            ],
        ],

        'bot' => [
            'class' => 'SonkoDmitry\Yii\TelegramBot\Component',
            'apiToken' => '368483985:AAGZkTncS5jdbz_RJ7BVQsITvtE-Q5dRLJE',
        ],

        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/rybalkashop',
        ],

        'mongout' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/rybalkashop_ut',
        ],

        'redis' => [

            'class' => 'yii\redis\Connection',

            'hostname' => '127.0.0.1',

            'port' => 6379,

            'database' => 0,

        ],

        'redisExtended' => [

            'class' => 'yii\redis\Connection',

            'hostname' => '127.0.0.1',

            'port' => 6379,

            'database' => 2,

        ],

        'session' => [
            'class' => 'yii\redis\Session',
            'redis' => 'redisExtended',
        ]
    ],
];
