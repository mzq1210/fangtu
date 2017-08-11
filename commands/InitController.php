<?php

/*
 * @系统初始化时 进行设置目录权限
 * @author <liangpingzheng>
 * @date Jan 16, 2017 11:05:24 AM
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class InitController extends Controller {

    public $writablePaths = [
        '@root/runtime',
        '@root/data',
        '@root/web/assets',
        '@root/web/icons/default',
        '@root/web/qrcode',
    ];
    public $executablePaths = [
        '@root/yii',
        '@root/web/icons/template',
        '@root/web/icons/thumb',
    ];

    public function actionIndex() {
        $this->setWritable($this->writablePaths);
        $this->setExecutable($this->executablePaths);
    }

    public function setWritable($paths) {
        foreach ($paths as $writable) {
            $writable = Yii::getAlias($writable);
            Console::output("Setting writable: {$writable} 0777");
            @chmod($writable, 0777);
        }
    }

    public function setExecutable($paths) {
        foreach ($paths as $executable) {
            $executable = Yii::getAlias($executable);
            Console::output("Setting executable: {$executable} 0775");
            @chmod($executable, 0755);
        }
    }

}
