<?php

namespace app\controllers;

use yii\web\Controller;
use dosamigos\qrcode\QrCode;

class SiteController extends Controller {

    public function actionQrcode() {
        return QrCode::png('http://www.yii-china.com');    //调用二维码生成方法
    }

    public function actionIndex() {
        return $this->render('index');
    }

}
