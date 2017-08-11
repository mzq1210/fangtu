<?php

/*
 * @desc   
 * @author <liangpingzheng>
 * @date Feb 7, 2017 11:13:04 AM
 */

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Controller;
use app\common\components\OutPut;
use app\common\components\library\Curl;

class DefaultController extends Controller {

    /**
     * 房图首页
     * @Author <lixiaobin>
     */
    public function actionIndex() {
        return $this->renderPartial('index',[
            'host' => Yii::$app->request->hostInfo,
            'realname' => Yii::$app->session->get('realname')
        ]);
    }

    /**
     * 房图首页登录模态框
     * @Author <lixiaobin>
     */
    public function actionLogin(){
        return $this->renderPartial('login');
    }

    /**
     * 异步登陆
     * @Author <lixiaobin>
    */
    public function actionLogin_ajax(){
        if(Yii::$app->request->isAjax){
            $username = Yii::$app->request->post('username', '');
            $password = Yii::$app->request->post('password', '');
            $siteId = 2;
            $params = array('username' => $username, 'password' => $password, 'siteid' => $siteId);
            $info = Curl::curlPost(PASSPORT_URL_LOGIN, $params);
            $userInfo = Json::decode($info);
            if ($userInfo['code'] == 200) {
                Yii::$app->session->set('userid', $userInfo['data']['id']);
                Yii::$app->session->set('username', $userInfo['data']['username']);
                Yii::$app->session->set('mobile', $userInfo['data']['mobile']);
                Yii::$app->session->set('realname', $userInfo['data']['realname']);
                Yii::$app->session->set('siteid', $userInfo['data']['siteid']);
                Yii::$app->session->set('cityid', $userInfo['data']['cityid']);
                OutPut::returnJson('登陆成功');
            }
            OutPut::returnJson('登陆失败', 201);
        }
        OutPut::returnJson('登陆失败', 201);
    }

    /**
     * 退出登陆
     * @Author <lixiaobin>
    */
    public function actionLoginout(){
        Yii::$app->session->removeAll();
        return $this->redirect(Yii::$app->request->hostInfo);
    }
}
