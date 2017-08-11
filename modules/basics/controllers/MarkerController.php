<?php

namespace app\modules\basics\controllers;

use Yii;
use app\common\base\BaseController;
use app\common\components\OutPut;
use app\common\models\basics\Layout;
use app\common\models\basics\City;
use app\common\models\basics\Layer;
use app\common\models\basics\PersonStore;
use app\common\components\library\ShowMessage;
use dosamigos\qrcode\QrCode;
use yii\helpers\Url;
use app\common\components\library\CryptAES;
use yii\web\NotFoundHttpException;

class MarkerController extends BaseController {

    public function actionIndex() {
        $layout_id = $this->request->get('layoutid');
        
        // modify by liangpingzheg 增加分享的验证
        if (!is_numeric($layout_id)) {
            $aes = new CryptAES();
            $data = $aes->decrypt($layout_id);
            $arr = explode(':', $data);
            $length = count($arr);
            if ($length != 2) {
                throw new NotFoundHttpException();
            }
            $layout_id = intval($arr[1]);
            $this->userid = $arr[0];
        }
        //判断当前layoutId 是否属于当前这个用户
        $layoutInfo = Layout::findOneInfo($layout_id,$this->userid);
        if(empty($layoutInfo)){
            header('Location:'.$this->request->hostInfo);
            exit;
        }
        
        if ($layout_id) {
            $userid = $this->userid;
            //获取图层列表
            $layer_info = Layer::searchLayer($layout_id, $userid);
            $store_num = 0;
            foreach ($layer_info as $k => $v) {
                $layerStore = PersonStore::find()->where(['layerid' => $v['id']])->normal()->sort($v['sort'],$v['updown'])->limit(LAYER_NUM)->asArray()->all();
                $layerStoreNum = PersonStore::find()->where(['layerid' => $v['id']])->normal()->count('id');
                $layer_info[$k]['layerStoreNum'] = $layerStoreNum;
                $layer_info[$k]['store'] = $layerStore;
                $store_num += $layerStoreNum;
            }

            $layoutInfo = Layout::findOneInfo($layout_id, $userid, 'cityid,name,is_show_area');
            $cityModel = City::findRecode($layoutInfo['cityid'], 'name');

            return $this->renderPartial('index', [
                    'layoutid'=>$layout_id,
                    'layer_info' => $layer_info,
                    'layer_num' => count($layer_info),
                    'store_num' => $store_num,
                    'cityName' => $cityModel->name,
                    'layoutName' => $layoutInfo['name'],
                    'isShowArea' => $layoutInfo['is_show_area'],
                    'userid' => $userid
            ]);
        } else {
            $this->redirect($this->request->hostInfo);
        }
    }

    /**
     * @author <miaozhongqiang>
     */
    public function actionGetinfo_ajax() {
        if (!$this->request->isAjax) {
            OutPut::returnJson('非法请求', 201);
        }
        $storeid = $this->request->post('storeid');
        $info = PersonStore::getInfo($storeid);
        OutPut::returnJson('请求成功', 200, $info);
    }

    /**
     * @author <miaozhongqiang>
     */
    public function actionGetsearch_ajax() {
        if (!$this->request->isAjax) {
            OutPut::returnJson('非法请求', 201);
        }
        $params = $this->request->post();
        $info = PersonStore::getStore($params);
        OutPut::returnJson('请求成功', 200, $info);
    }

    /*
     * 分享功能
     * 
     * @author <liangpingzheng>
     */

    public function actionShare() {
        $id = $this->request->get('id');
        //生成token
        $aes = new CryptAES();
        $token = $aes->encrypt($this->userid . ':' . $id);

        $file = Yii::getAlias("@webroot") . '/qrcode/' . md5($id) . '.png';
        $hostinfo = $this->request->hostInfo;
        $url = $hostinfo . Url::toRoute(['/basics/marker', 'layoutid' => $token]);
        QrCode::png($url, $file); //生成二维码图片
        return $this->renderPartial('share', ['url' => $url, 'id' => $id, 'token' => $token]);
    }

}
