<?php

namespace app\controllers;

use app\common\models\basics\Layer;
use Yii;
use app\common\components\OutPut;
use app\common\components\DrawImg;
use app\common\models\basics\City;
use app\common\base\BaseController;
use app\common\models\basics\Layout;

class MainController extends BaseController
{

    /**
     * 房图main页面
     * @Author <lixiaobin>
     * @Date 2017-01-17
     */
    public function actionIndex()
    {
        //获取根据当前城市和用户获取图层
        $info = Layout::findRecode($this->userid);
        return $this->renderPartial('index',[
            'info' => $info,
            'realname' => $this->realname,
            'mobile' => $this->mobile,
        ]);
    }

    /**
     * 调取添加地图项目模板
     * @Author <lixiaobin>
     * @Date 2017-01-17
    */
    public function actionAdd(){
        $city = City::getList();
        return $this->renderPartial('add', [
            'city' => $city,
            'cityid' => $this->cityid
        ]);
    }

    /**
     * 异步添加地图项目
     * @Author <lixiaobin>
     * @Date 2017-01-17
     * @Return Json
    */
    public function actionAdd_ajax(){
        if($this->request->isAjax){
            $params = $this->request->post();
            if(!empty($params['cityid']) && !empty($params['name'])){
                $params['addtime'] = $this->datetime;
                $params['edittime'] = $this->datetime;
                $params['creator'] = $this->userid;
                $params['updater'] = $this->userid;
                $params['operator'] = $this->userid;
                $res = Layout::addRecode($params);
                if(!empty($res)){
                    $name = City::findRecode($params['cityid'],'name')->name;
                    if($params['cityid'] == 2){
                        $name = mb_substr($name, 1, 1);
                    }else{
                        $name = mb_substr($name, 0, 1);
                    }
                    $draw = new DrawImg();
                    $draw->logo($params['cityid'],$name);
                    OutPut::returnJson('添加成功');
                }
            }
            OutPut::returnJson('添加失败',201);
        }
        OutPut::returnJson('添加失败',201);
    }

    /**
     * 调取修改地图项目模板
     * @Author <lixiaobin>
     * @Date 2017-01-17
     */
    public function actionEdit($id){
        $city = City::getList();
        $info = Layout::findOneInfo($id,$this->userid);
        return $this->renderPartial('edit', [
            'city' => $city,
            'info' => $info
        ]);
    }

    /**
     * 异步修改地图项目
     * @Author <lixiaobin>
     * @Date 2017-01-17
     * @Return Json
     */
    public function actionEdit_ajax(){
        if($this->request->isAjax){
            $params = $this->request->post();
            if(!empty($params['cityid']) && !empty($params['name'])){
                $data['cityid'] = $params['cityid'];
                $data['name'] = $params['name'];
                $data['edittime'] = $this->datetime;
                $data['updater'] = $this->userid;
                $res = Layout::editRecode($params['id'], $data);
                if(!empty($res)){
                    $name = City::findRecode($params['cityid'],'name')->name;
                    if($params['cityid'] == 2){
                        $name = mb_substr($name, 1, 1);
                    }else{
                        $name = mb_substr($name, 0, 1);
                    }
                    $draw = new DrawImg();
                    $draw->logo($params['cityid'],$name);
                    OutPut::returnJson('添加成功');
                }
            }
            OutPut::returnJson('添加失败',201);
        }
        OutPut::returnJson('添加失败',201);
    }

    /**
     * 删除地图项目 及 删除 图层 和图层下的数据
     * @Author <lixiaobin>
     * @Date 2017-01-17
     * @Return Json
    */
    public function actionDel_ajax(){
        if($this->request->isAjax){
            $id = $this->request->get('id');
            if(!empty($id)){
                $res = Layout::editRecode($id, array('del_flag' => 1));
                if(!empty($res)) OutPut::returnJson('删除成功');
            }
            OutPut::returnJson('删除失败',201);
        }
        OutPut::returnJson('删除失败',201);
    }

    /**
     * @desc 设置区域是否显示
     * @author <miaozhongqiang>
     */
    public function actionSetarea_ajax(){
        if($this->request->isAjax){
            $id = $this->request->post('layoutid');
            $status = $this->request->post('status');
            $user = $this->userid;
            $model = Layout::find()->where(['id'=>$id])->my($user)->one();
            if (empty($model)){
                OutPut::returnJson('请求失败', 201);
            }
            $model->setAttributes(['is_show_area'=>$status],false);
            if ($model->save()){
                OutPut::returnJson('请求成功', 200);
            }
            OutPut::returnJson('请求失败', 201);
        }
    }
}
