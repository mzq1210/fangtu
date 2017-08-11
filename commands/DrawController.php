<?php

/*
 * @desc   
 * @author <liangpingzheng>
 * @date Jan 12, 2017 5:12:29 PM
 */

namespace app\commands;

use yii\console\Controller;
use app\common\components\DrawImg;

class DrawController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex() {
        $obj = new DrawImg();
        $obj->thumb("ff00ff", 'm', 'm', true);
//        $obj->thumb("ff00ff", 'l', 'circle-stroked');
//        $obj->thumb("ff00ff", 's', 'circle-stroked');
    }

}
