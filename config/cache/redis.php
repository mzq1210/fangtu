<?php
/**
 * Created by PhpStorm.
 * User: leexb
 * Date: 16-10-31
 * Time: 下午2:16
 */

return [
        'class' => 'yii\redis\Cache',
        'redis' => [
            'class' => 'yii\redis\Connection',
            //'hostname' => '10.2.11.25',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0
        ],
];