<?php
/**
 * 基类控制器
 * @Author: <lixiaobin>
 * @Date: 17-1-12
 */

namespace app\common\base;

use Yii;
use yii\web\Controller;

class BaseController extends Controller{

    public $request;
    public $session;
    public $userid;
    public $realname;
    public $mobile;
    public $cityid;
    public $datetime;
    public $date;
    
    public function init(){
        parent::init();
        $this->request = Yii::$app->request;
        $this->session = Yii::$app->session;
        $this->datetime = date('Y-m-d H:i:s');
        $this->date = date('Y-m-d');
        //判断session中的userid和其他信息 不存在 则返回登录页面
        $this->userid = $this->session->get('userid');
        $this->realname = $this->session->get('realname');
        $this->mobile = $this->session->get('mobile');
        $this->cityid = $this->session->get('cityid');
        //判断是否是分享的链接 如果是分享的链接则不走是否登录的判断
        $layout = $this->request->get('layoutid','main');
        if(is_numeric($layout) || $layout == 'main'){
            if(empty($this->userid) || empty($this->realname) || empty($this->mobile) || empty($this->cityid)) $this->redirect($this->request->hostInfo);
        }

    }
}