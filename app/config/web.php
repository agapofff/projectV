<?php

use yii\web\Cookie;

$params = require(__DIR__ . '/params.php');
if (YII_ENV_DEV) {
    $db = require(__DIR__ . '/db-dev.php');
} else {
    $db = require(__DIR__ . '/db-prod.php');
}

$config = [
    'id' => 'project-v',
    'name' => 'project-v',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'UTC', // UTC

    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',

    'bootstrap' => ['log', 'paramsBootstrap', 'clientBootstrap', 'redirectBootstrap', 'utmBootstrap'],

    'defaultRoute' => 'main/site/index',
    'components' => [
        'paramsBootstrap' => [
            'class' => 'app\components\ParamsBootstrap',
        ],
        'clientBootstrap' => [
            'class' => 'app\components\ClientBootstrap',
        ],
        'redirectBootstrap' => [
            'class' => 'app\components\RedirectBootstrap',
        ],
        'utmBootstrap' => [
            'class' => 'app\components\UtmBootstrap',
        ],
        'session' => [
            'cookieParams' => [
                'httpOnly' => !YII_ENV_DEV,
                'secure' => !YII_ENV_DEV,
                'sameSite' => YII_ENV_DEV ? null : Cookie::SAME_SITE_STRICT,
            ]
        ],
        'cookies' => [
            'class' => 'yii\web\Cookie',
            /*'expire' => time() + 60 * 60 * 24,
            'httpOnly' => !YII_ENV_DEV,
            'secure' => !YII_ENV_DEV,
            'sameSite' => YII_ENV_DEV ? null : Cookie::SAME_SITE_STRICT,*/
        ],
        'request' => [
            'enableCsrfValidation' => !YII_ENV_DEV,
            'cookieValidationKey' => 'KpdrQ2X6XefU9JJd2RoNxGliDtIE3su4',
            'class' => 'app\components\lang\LangRequest',
        ],
        'response' => [
            'on beforeSend' => function($event) {
                YII_ENV_DEV ? null : $event->sender->headers->add('X-Frame-Options', 'DENY');
            },
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\auth\Identity',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/auth/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'main/site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'notamedia\sentry\SentryTarget',
                    'dsn' => 'https://977c17a8f8bf42edbbd30dc9db59d591@sentry.sessia.com/13',
                    'levels' => ['error', 'warning'],
                    'context' => true,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => require(__DIR__ . '/urlManager.php'),
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath' => '@app/messages',
                ],
                'amba' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => false,
                ],
                'm' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => false,
                ],
                'admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => false,
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => YII_DEBUG,
            'viewPath' => '@app/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'office@freedomgroupint.com',
                'password' => 'FG2017officeMail',
                'port' => 465,
                'encryption' => 'ssl',
            ],
        ],
        'geoip' => [
            'class' => 'dpodium\yii2\geoip\components\CGeoIP',
            'support_ipv6' => false, //Default value
        ],
        /**
         * Чтобы папки в web/assets автоматически обновлялись
         * (чтобы не вычищать их вручную после каждого обновления)
         * включаем использование символических ссылок
         */
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                ],
            ],
        ],
        /*'view' => [
            'class' => '\rmrevin\yii\minify\View',
            'enableMinify' => !YII_DEBUG, // !YII_DEBUG
            'concatCss' => true, // concatenate css
            'minifyCss' => true, // minificate css
            'concatJs' => true, // concatenate js
            'minifyJs' => true, // minificate js
            'minifyOutput' => true, // minificate result html page
            'webPath' => '@web', // path alias to web base
            'basePath' => '@webroot', // path alias to web base
            'minifyPath' => '@webroot/assets/minify', // path alias to save minify result
            'jsPosition' => [ \yii\web\View::POS_END ], // positions of js files to be minified
            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expandImports' => true, // whether to change @import on content
            'compressOptions' => ['extra' => true], // options for compress
            'excludeFiles' => [
                'admin/main.min.css',
                'admin/menu.min.css',
            ],
        ],*/
        'socialShare' => [
            'class' => \ymaker\social\share\configurators\Configurator::class,
            'socialNetworks' => [
                'telegram' => [
                    'class' => \ymaker\social\share\drivers\Telegram::class,
                    'label' => '',
                    'options' => ['class' => 'share__link share__link_telegram'],
                ],
                'viber' => [
                    'class' => \ymaker\social\share\drivers\Viber::class,
                    'label' => '',
                    'options' => ['class' => 'share__link share__link_viber'],
                ],
                'whatsapp' => [
                    'class' => \ymaker\social\share\drivers\WhatsApp::class,
                    'label' => '',
                    'options' => ['class' => 'share__link share__link_whatsapp'],
                ],
                'facebook' => [
                    'class' => \app\widgets\share\FacebookEdit::class,
                    'label' => '',
                    'options' => ['class' => 'share__link share__link_fb'],
                ],
                'vkontakte' => [
                    'class' => \ymaker\social\share\drivers\Vkontakte::class,
                    'label' => '',
                    'options' => ['class' => 'share__link share__link_vk'],
                ],
                'twitter' => [
                    'class' => \ymaker\social\share\drivers\Twitter::class,
                    'label' => '',
                    'options' => ['class' => 'share__link share__link_twitter'],
                ],
                'odnoklasniki' => [
                    'class' => \ymaker\social\share\drivers\Odnoklassniki::class,
                    'label' => '',
                    'options' => ['class' => 'share__link share__link_ok'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'app\components\AuthManager',
            'defaultRoles' => [
                'translator',
                'seo',
                'admin',
            ],
            'itemFile' => '@app/components/rbac/data/items.php',
            'assignmentFile' => 'app/components/rbac/data/assignments.php',
            'ruleFile' => '@app/components/rbac/data/rules.php',
        ],
        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
        ],
    ],
    'aliases' => [],
    'params' => $params,
];

/*if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['172.23.0.1', '::1'],
    ];
}*/

return $config;
