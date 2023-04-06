<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
if (YII_ENV_DEV) {
    $db = require(__DIR__ . '/db-dev.php');
} else {
    $db = require(__DIR__ . '/db-prod.php');
}

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
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
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                ],
            ],
        ],
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [
                'translator',
                'seo',
                'admin',
            ],
            'itemFile' => '@app/components/rbac/data/items.php',
            'assignmentFile' => 'app/components/rbac/data/assignments.php',
            'ruleFile' => '@app/components/rbac/data/rules.php',
        ],
    ],
    'params' => $params,
];
