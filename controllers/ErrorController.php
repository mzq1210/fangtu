<?php

/**
 * 错误信息页面
 * @author <liangpingzheng>
 * @date Jan 19, 2017 5:38:25 PM
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ErrorController extends Controller {

    public function actionError() {
        $this->layout = false;
        $code = 404;
        $msg = 'Page Not Found';

        $error = Yii::$app->errorHandler->exception;
        if ($error) {
            $code = $error->getCode();
            $msg = $error->getMessage();
            return $this->render('404');
        }
    }

}