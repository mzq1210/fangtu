<?php

namespace app\modules\basics\controllers;

use app\common\components\Geocoding;
use app\common\components\OutPut;
use app\common\models\basics\City;
use app\common\models\basics\Layer;
use app\common\models\basics\Layout;
use Yii;
use app\common\base\BaseController;
use app\common\models\basics\PersonStore;

class StoreController extends BaseController
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
    
    /**
     * 加载数据视图的ajax方法
     */
    public function actionGetstore_ajax()
    {
        if(!$this->request->isAjax){
            OutPut::returnJson('非法请求',201);
        }
        $layerid = $this->request->post('layerid');
        $page = $this->request->post('page',0);
        $search = $this->request->post('search');
        $info = PersonStore::getStoreByLayer($layerid,PAGESIZE,$page,$search);
        
        OutPut::returnJson('成功',200,$info);
    }

    /**
     * 通过点击数据视图修改信息后，调用ajax修改
     * @author <liangshimao>
     */
    public function actionEdit_ajax()
    {
        if(!$this->request->isAjax){
            OutPut::returnJson('非法请求',201);
        }
        $name = $this->request->post('name');
        $id = $this->request->post('id');
        $type = $this->request->post('type');
        $storeModel = PersonStore::findOne($id);
        $layerModel = Layer::findOne($storeModel->layerid);
        switch($type){
            case 1:
                $storeModel->setAttributes(['name'=>$name],false);
                break;
            case 2:
                $layoutInfo = Layout::findOne($storeModel['layoutid']);
                $cityInfo = City::findOne(['city_id' => $layoutInfo->cityid]);
                $point = Geocoding::getPoint($name,$cityInfo->name);
                if(isset($point['lat']) && isset($point['lng'])){
                    $storeModel->setAttributes(['address'=>$name,'lat'=>$point['lat'],'lng'=>$point['lng']],false);
                }else{
                    $storeModel->setAttributes(['address'=>$name],false);
                }
                break;
            case 3:
                $storeModel->setAttributes(['v3'=>$name],false);
                break;
            case 4:
                $storeModel->setAttributes(['v4'=>$name],false);
                break;
            case 5:
                $storeModel->setAttributes(['v5'=>$name],false);
                break;
            case 6:
                $storeModel->setAttributes(['v6'=>$name],false);
                break;
            case 7:
                $storeModel->setAttributes(['v7'=>$name],false);
                break;
        }
        if($storeModel->save()){
            $data = PersonStore::getInfo($id);
            //是否是需要更新门店列表数据
            if($type == $layerModel->title){
                $data['update'] = 1;
            }else{
                $data['update'] = 0;
            }
            OutPut::returnJson('修改成功',200,$data);
        }else{
            OutPut::returnJson('修改失败',201);
        }
    }

}