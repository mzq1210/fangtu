<?php

namespace app\modules\basics\controllers;

use app\common\components\DrawImg;
use app\common\components\Geocoding;
use app\common\models\basics\City;
use Yii;
use app\common\models\basics\Layout;
use app\common\models\basics\Layer;
use app\common\models\basics\PersonStore;
use yii\web\NotFoundHttpException;
use app\common\base\BaseController;
use app\common\components\OutPut;

class EcharsController extends BaseController {

    public function actionIndex() {

        return $this->renderPartial('index');
    }

   

}