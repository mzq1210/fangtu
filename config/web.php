<?php
include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constant.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute'=>'default',
    'modules' => [
        'basics' => ['class' => 'app\modules\basics\BasicsModule']
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'fE0FIJe9gHx7n4jrXBrUEjTNfpL2UE0P',
            'enableCsrfValidation' => false,
        ],
        'cache' => require (__DIR__ . '/cache/redis.php'),
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'db' => require(__DIR__ . '/db/db.php'),
        'urlManager' => array(
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // 'suffix' => '.html',
            'rules' => [
            ]
        ),
    ],
];
return $config;