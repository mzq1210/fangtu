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

class EditController extends BaseController {

    public function actionIndex() {
        $layout_id = $this->request->get('layoutid', 12);
        if (!empty($layout_id) && is_numeric($layout_id)) {
            //判断当前layoutId 是否属于当前这个用户
            $layoutInfo = Layout::findOneInfo($layout_id,$this->userid);
            if(empty($layoutInfo)){
                header('Location:'.$this->request->hostInfo);
                exit;
            }
            //获取图层列表
            //add by miaozhongqiang 2017-02-08 增加userid条件
            $userid = $this->userid;
            $layer_info = Layer::searchLayer($layout_id, $userid);
            $store_num = 0;
            foreach ($layer_info as $k => $v) {
                //add by miaozhongqiang 2017-02-08 增加del_flag条件
                $layerStore = PersonStore::find()->where(['layerid' => $v['id'],'del_flag'=>0])->normal()->sort($v['sort'],$v['updown'])->limit(LAYER_NUM)->asArray()->all();
                $layerStoreNum = PersonStore::find()->where(['layerid' => $v['id']])->normal()->count();
                $layer_info[$k]['layerStoreNum'] = $layerStoreNum;
                $layer_info[$k]['store'] = $layerStore;
                $store_num += $layerStoreNum;
            }
            //add by lixiaobin 2017-02-04 将“我的第一幅地图” 改为 地图的名称
            $layoutInfo = Layout::findOneInfo($layout_id,$userid, 'cityid,name,is_show_area');
            $cityModel = City::findRecode($layoutInfo['cityid'], 'name');
            $maxExcleRow = MAX_EXCLE_ROW;
            return $this->renderPartial('index', [
                'maxExcelRow' => $maxExcleRow,
                'layer_info' => $layer_info,
                'layer_num' => count($layer_info),
                'store_num' => $store_num,
                'cityName' => $cityModel->name,
                //add by lixiaobin 2017-02-04 将“我的第一幅地图” 改为 地图的名称
                'layoutName' => $layoutInfo['name'],
                'isShowArea' => $layoutInfo['is_show_area'],
                'layout_id' => $layout_id,
                'userid' => $this->userid
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @author <miaozhongqiang>
     */
    public function actionGetinfo_ajax() {
        if (!$this->request->isPost) {
            OutPut::returnJson('非法请求', 201);
        }
        $storeid = $this->request->post('storeid');
        $info = PersonStore::getInfo($storeid);
        OutPut::returnJson('请求成功', 200, $info);
    }

    public function actionLayerstore_ajax() {
        $arr = [
            'code' => 201,
            'data' => false
        ];
        if (!$this->request->isAjax) {
            json_encode($arr);
        }
        $layerid = $this->request->post('layer');
        $layer = Layer::findOne($layerid);
        $ico = $layer['ico'];
       
        $layerStore = PersonStore::find()->where(['layerid' => $layerid])->normal()->sort($layer->sort,$layer->updown)->offset(LAYER_NUM)->asArray()->all();
       
        foreach ($layerStore as $k => $v) {
            if ($layer['title'] == 1) {
                $layerStore[$k]['showColumn'] = $v['name'];
            }elseif ($layer['title'] == 2) {
                $layerStore[$k]['showColumn'] = $v['address'];
            }else{
                $layerStore[$k]['showColumn'] = $v['v'.$layer['title']];
            }

            if (!empty($layerStore[$k]['icon'])) {
                $layerStore[$k]['ico'] = $v['icon'];
            }else{
                $layerStore[$k]['ico'] = $ico;
            }
        }
        $arr = [
            'code' => 200,
            'data' => $layerStore
        ];
        echo json_encode($arr);
    }

    /**
     * 编辑模态框
     */
    public function actionEdit($id) {
        $model = PersonStore::getInfo($id);

        if ($this->request->isPost) {
            $params = $this->request->post();
            $data = [];
            $pointError = false;
            foreach ($params['params'] as $key => $value){
                $data[$value['name']] = $value['value'];
                if($value['name'] == 'address'){
                    $m = PersonStore::findOne($id);
                    //add by lixiaobin 2017-03-03 修改坐标不走按地址获取坐标
                    if($m['address'] != $value['value']){
                        $layoutInfo = Layout::findOne($m['layoutid']);
                        $cityInfo = City::findOne(['city_id' => $layoutInfo->cityid]);
                        $point = Geocoding::getPoint($value['value'],$cityInfo->name);
                        if(isset($point['lat']) && isset($point['lng'])){
                            $data['lat'] = $point['lat'];
                            $data['lng'] = $point['lng'];
                        }else{
                            $pointError = true;
                        }
                    }
                }
            }
            $model = PersonStore::findOne($data['id']);
            $data['operator'] = $this->userid;
            $data['edit_time'] = $this->datetime;
            $model->setAttributes($data, false);
            if($model->save()){
                $data = PersonStore::getInfo($data['id']);
                if($pointError){
                    OutPut::returnJson('修改成功,定位失败!',200,$data);
                }else{
                    OutPut::returnJson('修改成功', 200, $data);
                }
            }else{
                OutPut::returnJson('操作失败', 201);
            }
        }else{
            return $this->renderPartial('edit', [
                'model' => $model
            ]);
        }
    }

    /**
     * 设置图层样式模态框
     */
    public function actionStyle() {
        $id = $this->request->get('id');
        $model = PersonStore::findOne($id);
        $icon = "ff0000-m-null.png";
        if ($model) {
            $info = Layer::findOne($model->layerid);
            if ($model['icon']) {
                $icon = $model['icon'];
            } else {
                $icon = $info['ico'];
            }
        }
        $data['id'] = $id;
        $data['icon'] = $icon;
        $data['bubble'] = 'true';
        $icon = str_replace(['_marker', '.png'], '', $icon);
        $arr = explode('-', $icon);
        $data['color'] = $arr[0];
        $data['size'] = $arr[1];
        $data['symbol'] = str_replace([$arr[0], "-$arr[1]-"], '', $icon);
        if (preg_match('/_marker/', $data['icon'])) {
            $data['bubble'] = 'false';
        }

        return $this->renderPartial('style', ['data' => $data
        ]);
    }

    public function actionSetstyle_ajax() {
        if ($this->request->isAjax) {
            $params = $this->request->post();
            PersonStore::editRecord($params['id'],$params);
            OutPut::returnJson('修改成功', 200,['img'=>$params['icon']]);
        }
    }

    /**
     * 根据layoutid获取这个项目下的所有图层，后期可能加添加分页（图层管理）
     * @param $layoutid
     * @return string
     * @author <liangshimao>
     */
    public function actionLayeredit($layoutid)
    {
        $info = Layer::searchLayerPage($layoutid,$this->userid);
        return $this->renderPartial('layer',[
            'info' => $info['data'],
            'layoutid' => $layoutid,
        ]);
    }

    /**
     * 根据layoutid获取这个项目下的所有的layer,刷新图层编辑用
     * @author <liangshimao>
     */
    public function actionLayeredit_ajax()
    {
        if(!$this->request->isAjax){
            OutPut::returnJson('非法请求',201);
        }
        $layoutid = $this->request->post('layoutid');
        $info = Layer::searchLayerPage($layoutid,$this->userid);
        OutPut::returnJson('成功',200,$info['data']);
    }

    /**
     * 图层管理中修改是否隐藏的ajax方法
     * @author <liangshimao>
     */
    public function actionSetdisplay_ajax()
    {
        if($this->request->isAjax){
            $id = $this->request->post('id');
            $checked = $this->request->post('checked');
            $model = Layer::findOne($id);
            $model->setAttributes([
                'is_display' => ($checked == 'true')?1:0,
            ],false);
            if($model->save()){
                OutPut::returnJson('修改成功',200);
            }
        }
        OutPut::returnJson('非法请求',201);
    }

    /**
     * 图层管理中是否隐私的ajax方法
     * @author <liangshimao>
     */
    public function actionSetpublic_ajax()
    {
        if($this->request->isAjax){
            $id = $this->request->post('id');
            $checked = $this->request->post('checked');
            $model = Layer::findOne($id);
            $model->setAttributes([
                'is_public' => ($checked == 'true')?1:0,
            ],false);
            if($model->save()){
                OutPut::returnJson('修改成功');
            }
        }
        OutPut::returnJson('非法请求',201);
    }

    /**
     * 图层管理中设置排序的ajax方法
     * @author <liangshimao>
     */
    public function actionSetsort_ajax()
    {
        if($this->request->isAjax){
            $id = $this->request->post('id');
            $up = $this->request->post('up');
            $exid = $this->request->post('exid');
            $model = Layer::findOne($id);
            if($up == 'true'){
                $preModel = Layer::findOne($exid);
                if(!empty($preModel)){
                    $tmp = $preModel->layer_sort;
                    $preModel->setAttributes(['layer_sort' => $model->layer_sort],false);
                    $model->setAttributes(['layer_sort' => $tmp],false);
                    if($model->save() && $preModel->save()){
                        OutPut::returnJson('修改成功');
                    }
                }
            }else{
                $nextModel = Layer::findOne($exid);
                if($nextModel){
                    $tmp = $nextModel->layer_sort;
                    $nextModel->setAttributes(['layer_sort' => $model->layer_sort],false);
                    $model->setAttributes(['layer_sort' => $tmp],false);
                    if($model->save() && $nextModel->save()){
                        OutPut::returnJson('修改成功');
                    }
                }
            }
        }
        OutPut::returnJson('操作失败',201);
    }

    /**
     * 更改图层编辑页面小眼睛开启与否的ajax方法
     * @author <liangshimao>
     */
    public function actionSetshow_ajax()
    {
        if($this->request->isAjax){
            $id = $this->request->post('id');
            $checked = $this->request->post('checked');
            $model = Layer::findOne($id);
            $model->setAttributes([
                'is_show' => $checked,
            ],false);
            if($model->save()){
                OutPut::returnJson('修改成功');
            }
        }
        OutPut::returnJson('非法请求',201);
    }

    /**
     * @desc 删除图层
     * @author <miaozhongqiang>
     */
    public function actionDel(){
        if($this->request->isAjax){
            $id = $this->request->get('id','');
            $model = PersonStore::find()->where(['id'=>$id])->one();
            $data = PersonStore::getInfo($id);
            if (empty($model)){
                OutPut::returnJson('请求失败', 202);
            }
            $model->setAttributes(['del_flag'=>1],false);
            if ($model->save()){
                OutPut::returnJson('请求成功', 200,$data);
            }
            OutPut::returnJson('请求失败', 201);
        }
    }

    /**
     * @desc 标注自定义样式恢复
     * @author <miaozhongqiang>
     */
    public function actionResetstyle(){
        if($this->request->isAjax){
            $id = $this->request->get('id','');
            $model = PersonStore::find()->where(['id'=>$id])->one();
            if (empty($model)){
                OutPut::returnJson('请求失败', 202);
            }
            $model->setAttributes(['icon'=>''],false);
            if ($model->save()){
                OutPut::returnJson('请求成功', 200);
            }
            OutPut::returnJson('请求失败', 201);
        }
    }

    /**
     * @desc 添加标注点
     * @author <miaozhongqiang>
     * @param $layoutid
     * @return string
     */
    public function actionAddmarker($layoutid){
        if($this->request->isPost) {
            $params = $this->request->post();
            $data = [];
            foreach ($params['params'] as $key => $value){
                $data[$value['name']] = $value['value'];
            }
            $model = new PersonStore();
            $data['creator'] = $this->userid;
            $data['updater'] = $this->userid;
            $data['operator'] = $this->userid;
            $data['addtime'] = $this->datetime;
            $data['edittime'] = $this->datetime;

            $model->setAttributes($data, false);
            if ($model->save()){
                $id = $model->attributes['id'];
                $data = PersonStore::getInfo($id);
                OutPut::returnJson('添加成功', 200, $data);
            }else{
                OutPut::returnJson('添加失败', 201);
            }
        }else{
            $userid = $this->userid;
            $lng = $this->request->get('lng');
            $lat = $this->request->get('lat');
            $layer = Layer::find()->select('id, name')->where(['layoutid' => $layoutid])->normal()->display()->my($userid)->asArray()->all();
            return $this->renderPartial('add',[
                'layer' => $layer,
                'layoutid' => $layoutid,
                'lng' => $lng,
                'lat' => $lat,
            ]);
        }
    }


    /**
     * @desc 获取图层字段
     * @author <miaozhongqiang>
     * @return string
     */
    public function actionGetfield(){
        if ($this->request->isAjax) {
            $params = $this->request->post();
            if($params['layerid']){
                $layer = Layer::findOne($params['layerid']);
                $showField = json_decode($layer->defined);
                $fields = [];
                foreach ($showField as $k => $val){
                    switch ($k){
                        case 1://名称
                            $fields[$k]['name'] = $val;
                            $fields[$k]['field'] = 'name';
                            break;
                        case 2://地址
                            $fields[$k]['name'] = $val;
                            $fields[$k]['field'] = 'address';
                            break;
                        default:
                            $fields[$k]['name'] = $val;
                            $fields[$k]['field'] = 'v'.$k;
                            break;
                    }
                }
                OutPut::returnJson('查询成功', 200, $fields);
            }else{
                OutPut::returnJson('查询失败', 201);
            }
        }
        OutPut::returnJson('访问的页面不存在', 201);
    }


    /**
     * @desc 修改项目信息
     * @author <liangshimao>
     */
    public function actionLayout($id)
    {
        $city = City::getList();
        $info = Layout::findOneInfo($id,$this->userid);
        return $this->renderPartial('layout', [
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
    public function actionLayout_ajax(){
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
                OutPut::returnJson('添加失败',201);
            }else{
                OutPut::returnJson('添加失败',201);
            }
        }
        OutPut::returnJson('添加失败',201);
    }

    /**
     * 下载导入魔板改为php下载
     * @Author <wangluohua>
     * @Date 2017-03-3
     */
    public function actionDownload(){
        $path = Yii::getAlias('@app') . '/web/data/';
        $file = $path.'Import_Format.xlsx';
        Yii::$app->response->sendFile($file,'模板.xlsx');
    }

}