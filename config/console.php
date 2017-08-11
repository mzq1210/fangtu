<?php

include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bootstrap.php');
include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constant.php');


$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => require(__DIR__ . '/db/db.php'),
        'mdb' => require(__DIR__ . '/db/mdb.php'),
        'cache' => require (__DIR__ . '/cache/redis.php'),
    ],
];

return $config;
