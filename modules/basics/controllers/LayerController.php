<?php

namespace app\modules\basics\controllers;

use app\common\components\BaseCache;
use app\common\models\basics\PersonStore;
use Yii;
use app\common\components\OutPut;
use app\common\base\BaseController;
use app\common\models\basics\Layer;
use app\common\components\DrawImg;
use yii\helpers\Json;
use PHPExcel;
use PHPExcel_IOFactory;

class LayerController extends BaseController {

    public function actionIndex() {
        return $this->renderPartial('index');
    }
    

    /**
     * 添加图层
     * @Param
     * @Return json
     * @Author <lixiaobin>
     * @Date 2017-01-12
     */
    public function actionAdd() {
        return $this->renderPartial('add');
    }

    /**
     * 添加图层
     * @Param
     * @Return json
     * @Author <lixiaobin>
     * @Date 2017-01-12
     */
    public function actionCreatelayer_ajax() {
        if ($this->request->isAjax) {
            $params = $this->request->post();
            $obj = new DrawImg();
            //设置默认样式
            $params['ico'] = $imgName = $obj->thumb('ff0000', 's', 'null');
            $params['size'] = 's';
            $params['defined'] = Json::encode(array('1' => '门店名称', '2' => '详细地址'), false);
            $params['msgbox'] = Json::encode(array('1' => '门店名称', '2' => '详细地址'), false);
            $params['creator'] = $this->userid;
            $params['updater'] = $this->userid;
            $params['operator'] = $this->userid;
            $params['addtime'] = $this->datetime;
            $params['edittime'] = $this->datetime;
            $res = Layer::addRecord($params);
            if (!empty($res))
                OutPut::returnJson('添加成功', 200);
            OutPut::returnJson('添加失败', 201);
        }
        OutPut::returnJson('访问的页面不存在', 201);
    }

    /**
     * 异步生成小图标
     * @author <lixiaobin>
     * @date 2017-01-13
     * @return json
     */
    public function actionCreateimg_ajax() {
        if ($this->request->isAjax) {
            $params = $this->request->post();
            if (empty($params['color']) && empty($params['size']))
                OutPut::returnJson('失败', 201);
            $obj = new DrawImg();
            $params['bubble'] = ($params['bubble'] == 1 || $params['bubble'] == 'true') ? true : false;
//            $params['bubble'] = false;
            $imgName = $obj->thumb($params['color'], $params['size'], $params['symbol'], $params['bubble']);
            if (!empty($imgName)) {
                OutPut::returnJson('成功', 200, array('imgName' => $imgName));
            } else {
                OutPut::returnJson('失败', 201);
            }
        }
    }

    /**
     * 修改图层样式
     * @author <lixiaobin>
     * @date 2017-01-15
     * @return json
     */
    public function actionSetstyle_ajax() {
        if ($this->request->isAjax) {
            $params = $this->request->post();
            if (empty($params['color']) && empty($params['size']))
                OutPut::returnJson('失败', 201);
            $id = $params['id'];
            if ($params['bubble'] == 0) {
                $data['ico'] = $params['color'] . '-' . $params['size'] . '-' . $params['symbol'] . '_marker.png';
            } else {
                $data['ico'] = $params['color'] . '-' . $params['size'] . '-' . $params['symbol'] . '.png';
            }
            if(strstr($data['ico'],'_marker')){
                $info['marker'] = 1;
            }else{
                $info['marker'] = 2;
            }
            $data['size'] = $params['size'];
            $data['lable'] = $params['lable'];
            $lable = Layer::findRecord($id, 'lable');
            $res = Layer::editRecord($id, $data);
            $info['ico'] = '/icons/default/' . $data['ico'];
            $info['size'] = $data['size'];

            if (!empty($res)) {
                //判断是否更改lable 如果更改则调取门店数据
                if ($lable['lable'] != $params['lable']) {
                    $info['lable'] = $params['lable'];
                }
                OutPut::returnJson('修改成功', 200, $info);
            }
            OutPut::returnJson('失败', 201);
        } else {
            OutPut::returnJson('失败', 201);
        }
    }

    /**
     * 根据layerid 获取图层数据
     * @author <lixiaobin>
     * @date 2017-01-15
     * @return json
     *
     */
    public function actionInfo_ajax() {
        if ($this->request->isAjax) {
            $id = $this->request->post('layerid');
            $field = 'id,ico,size,lable';
            $info = Layer::findRecord($id, $field);
            $icoArr = explode('-', $info['ico']);
            //处理有无气泡
            $info['bubble'] = 1;
            if (end($icoArr) == 'marker.png') {
                $info['bubble'] = 0;
            }
            if (!empty($info))
                OutPut::returnJson('成功', 200, $info);
            OutPut::returnJson('失败', 201);
        }
        OutPut::returnJson('失败', 201);
    }

    /**
     * 设置图层样式模态框
     */
    public function actionStyle($id) {
        $info = Layer::findRecord($id);
        $icoArr = explode('_', $info['ico']);
        //判断有无气泡
        $info['bubble'] = 1;
        if (end($icoArr) == 'marker.png') {
            $info['bubble'] = 0;
        }
        $icoArr = explode(',', str_replace(['_marker.png', '.png', '-s-', '-l-', '-m-'], ['', '', ',', ',', ','], $info['ico']));
        $info['iconColor'] = $icoArr[0];
        $info['iconName'] = $icoArr[1];
        //获取自定义的字段
        $lable = Layer::lable($id);
        return $this->renderPartial('style', [
                'id' => $id,
                'info' => $info,
                'lable' => $lable
        ]);
    }

    /**
     * @author <wangluohua>
     * @desc 重命名图层
     */

    public function actionRename() {
        if($this->request->isAjax){
            $id = $this->request->get('id',0);
            $layer = Layer::findRecord($id,'name');
            $name = $layer['name'] ? $layer['name']:"";
            return $this->renderPartial('rename',[
                'name' => $name,
                'layerid' => $id
            ]);
        }
    }

    public function actionRenamelayer(){
        if($this->request->isAjax){
            $post = $this->request->post();
            $id = $post['layerid'];
            $data = [
                'id' => $id,
                'name' => $post['layername']
            ];
            $model = Layer::findOne($id);
            $model->setAttributes($data,false);
            if ($model->save()){
                OutPut::returnJson('重命名图层成功', 200, $data);
                return;
            }
            OutPut::returnJson('重命名图层失败', 201, $data);
        }
    }


    /**
     * @author <miaozhongqiang>
     */
    public function actionSetshow_ajax() {
        if (!$this->request->isAjax) {
            OutPut::returnJson('非法请求', 201);
        }
        $layerid = $this->request->post('layerid');
        $status = $this->request->post('status');

        $model = Layer::findOne($layerid);
        $model->setAttributes(['is_show' => $status], false);
        if ($model->save()) {
            OutPut::returnJson('请求成功', 200);
        } else {
            OutPut::returnJson('请求失败', 201);
        }
    }

    /**
     * @author <wangluohua>
     * @desc 设置显示字段是显示模态框并显示相应layer的数据
     */
    public function actionSetmsgbox(){
        if($this->request->isAjax){
            $id = $this->request->get('layerid');
            $defined = Layer::findRecord($id,'defined,msgbox');
            $arr = [];
            if(!empty($defined['defined'])){
                $arr = json_decode($defined['defined'],true);
            }
            $msgbox = [];
            if(!empty($defined['msgbox'])){
                $msgbox = json_decode($defined['msgbox'],true);
            }
            return $this->renderPartial('setmsgbox',[
                'defined' => $arr,
                'msgbox'  => $msgbox,
                'layerid' => $id
            ]);
        }
    }

    /**
     * @author <wangluohua>
     * @desc 设置右侧用户点击时显示字段
     */
    public function actionSetmsgbox_ajax(){
        if($this->request->isAjax){
            $post = $this->request->post();
            $id = $post['layerid'];
            unset($post['layerid']);
            $data = [
                'msgbox' => json_encode($post)
            ];
            $model = Layer::findOne($id);
            $model->setAttributes($data,false);
            $model->save();
            $data['layerid'] = $id;
            OutPut::returnJson('设置显示字段成功', 200, $data);
        }
    }

    /**
     * @author <mzq>
     * @desc 清除图层数据
     */
    public function actionClear(){
        if($this->request->isAjax){
            $id = $this->request->get('id','');
            $user = $this->userid;
            $model = Layer::find()->where(['id'=>$id])->my($user)->one();
            if (empty($model)){
                OutPut::returnJson('请求失败', 201);
            }
            $model->setAttributes(['defined'=>'','msgbox'=>''],false);
            PersonStore::updateAll(['del_flag'=>1],['layerid'=>$id]);
            if ($model->save()){
                OutPut::returnJson('请求成功', 200);
            }
            OutPut::returnJson('请求失败', 201);
        }
    }


    /**
     * @author <wangluohua>
     * @desc 删除图层
     */
    public function actionDel(){
        if($this->request->isAjax){
            $id = $this->request->get('id','');
            $user = $this->userid;
            $model = Layer::find()->where(['id'=>$id])->my($user)->one();
            if (empty($model)){
                OutPut::returnJson('请求失败', 201);
            }
            $model->setAttributes(['del_flag'=>1],false);
            PersonStore::updateAll(['del_flag'=>1],['layerid'=>$id]);
            if ($model->save()){
                OutPut::returnJson('请求成功', 200);
            }
            OutPut::returnJson('请求失败', 201);
        }
    }

    public function actionGettitle_ajax()
    {
        if($this->request->isAjax){
            $layerid = $this->request->post('layerid');
            $title = Layer::findRecord($layerid,'defined,title,sort,updown');
            OutPut::returnJson('成功',200,$title);
        }
        OutPut::returnJson('请求失败', 201);
    }

    /**
     * @author <wangluohua>
     * @desc 导出图层数据到excel
     */
    public function actionExportexcel()
    {
        $layerid = $this->request->get('id');
        $userid = $this->userid;
        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        $layerInfo = Layer::findOne($layerid);
        $data = PersonStore::find()->where(["layerid"=>$layerid])->normal()->my($userid)->sort($layerInfo['sort'],$layerInfo['updown'])->all();
        
        //表格头的输出
        $head = Json::decode($layerInfo->defined);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$head[1]);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B1',$head[2]);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
        if(isset($head[3])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C1',$head[3]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        }
        if(isset($head[4])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D1',$head[4]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        }
        if(isset($head[5])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E1',$head[5]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        }
        if(isset($head[6])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F1',$head[6]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        }
        if(isset($head[7])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G1',$head[7]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        }
        //设置居中
        $count = count($data)+1;
        for($i = 1;$i<=$count;$i++){
            $objectPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        foreach ( $data as $n => $product )
        {
            //明细的输出
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n+2) ,$product->name);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n+2) ,$product->address);
            if(isset($head[3])){
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n+2) ,$product->v3);
            }
            if(isset($head[4])){
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n+2) ,$product->v4);
            }
            if(isset($head[5])){
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n+2) ,$product->v5);
            }
            if(isset($head[6])){
                $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n+2) ,$product->v6);
            }
            if(isset($head[7])){
                $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n+2) ,$product->v7);
            }


        }

        ob_end_clean();
        ob_start();

        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$layerInfo->name.'图层导出数据-'.date("Y年m月j日").'.xls"');
        $objWriter= \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $objWriter->save('php://output');
    }


    /**
     * @author <lixiaobin>
     * @desc 导出错误的信息
     */
    public function actionErrorxport()
    {

        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        $key = $this->request->get('error','');
        $errorInfo = BaseCache::get($key);
        $data = Json::decode($errorInfo);
        //BaseCache::delete($key);
        $head = $data[0];
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$head[1]);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B1',$head[2]);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
        if(isset($head[3])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C1',$head[3]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        }
        if(isset($head[4])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D1',$head[4]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        }
        if(isset($head[5])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E1',$head[5]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        }
        if(isset($head[6])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F1',$head[6]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        }
        if(isset($head[7])){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G1',$head[7]);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        }
        array_shift($data);
        //设置居中
        $count = count($data)+1;
        for($i = 1;$i<=$count;$i++){
            $objectPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        foreach ( $data as $n => $value )
        {
            //明细的输出
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n+2) ,$value[1]);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n+2) ,$value[2]);
            if(isset($head[3])){
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n+2) ,$value[3]);
            }
            if(isset($head[4])){
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n+2) ,$value[4]);
            }
            if(isset($head[5])){
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n+2) ,$value[5]);
            }
            if(isset($head[6])){
                $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n+2) ,$value[6]);
            }
            if(isset($head[7])){
                $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n+2) ,$value[7]);
            }
        }

        ob_end_clean();
        ob_start();

        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.date("YmjHis").'.xls"');
        $objWriter= \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $objWriter->save('php://output');
    }

}
