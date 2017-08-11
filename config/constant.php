<?php

/**
 * Created by PhpStorm.
 * User: 李效宾
 * Date: 2016-10-31
 * Time: 下午2:16
 * Desc: 将所用的到配置参数（常量）配置在该文件中
 */
//redis前缀设置
defined('MPS_REDIS_KEY') OR define('MPS_REDIS_KEY', 'mps_');

//来源
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

//登陆入口地址
defined('PASSPORT_URL') OR define('PASSPORT_URL', 'http://10.2.11.31:8686');

//websocket ip+port
defined('HOST') or define('HOST', '127.0.0.1');
defined('PORT') or define('PORT', '9521');
define('PAGESIZE', 15);

//左侧列表默认打开每个图层显示条数
defined('LAYER_NUM') or define('LAYER_NUM', 10);

//上传图层数据是允许的最大列数
defined('MAX_EXCLE_COLUMN') or define('MAX_EXCLE_COLUMN', 7);
defined('MAX_EXCLE_ROW') or define('MAX_EXCLE_ROW', 3000);

//用户登陆 请求url
defined('PASSPORT_URL_LOGIN') OR define('PASSPORT_URL_LOGIN', PASSPORT_URL.'/login/loginapi');
