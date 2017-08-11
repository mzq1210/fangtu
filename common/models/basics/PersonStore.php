<?php
/**
 * Created by PhpStorm.
 * User: miaozhongqiang
 * Date: 17-1-11
 * Time: 上午11:29
 * Desc: 门店类
 */
namespace app\common\models\basics;

use app\common\models\query\BaseQuery;
use app\common\components\Tools;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class PersonStore extends ActiveRecord{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_store_data';
    }

    /**
     * @desc 搜索门店
     * @author <miaozhongqiang>
     * @param array $params
     * @return object
     */
    public static function search($params=[])
    {
        $info = self::find()->with(['layer' => function ($query) {
            $query->display()->normal();
        }])->where(['layoutid' => $params['layoutid']])->normal()->my($params['userid']);
        isset($params['name']) && $info->andWhere(['like','name',$params['name']]);
        isset($params['layerid']) && $info->andWhere(['layerid'=>$params['layerid']]);
        if(isset($params['idArr'])){
            $idArr = explode(',', $params['idArr']);
            $info->andWhere(['in','id', $idArr]);
        }
        return $info->all();
    }

    /**
     * @desc 数组转化
     * @author <miaozhongqiang>
     * @param array $params
     * @return array
     */
    public static function getStore($params)
    {
        $info = self::search($params);
        $layerArr = [];
        foreach ($info as $key => $value){
            if(!$value->layer){ continue; }
            $layerArr[$key]['id'] = $value->id;
            $layerArr[$key]['layerid'] = $value->layerid;
            $layerArr[$key]['name'] = $value->name;
            $layerArr[$key]['lng'] = $value->lng;
            $layerArr[$key]['lat'] = $value->lat;
            if($value->icon) {
                $layerArr[$key]['ico'] = $value->icon;
                $layerArr[$key]['size'] = $value->size;
            }else{
                $layerArr[$key]['ico'] = $value->layer->ico;
                $layerArr[$key]['size'] = $value->layer->size;
            }
            //label自定义显示字段
            if($value->layer->lable) {
                $field = json_decode($value->layer->defined);
                $lableField = [];
                foreach ($field as $k => $val){
                    if($value->layer->lable == $k){
                        switch ($k){
                            case 1://名称
                                $lableField['name'] = $val;
                                $lableField['value'] = $value->name;
                                break;
                            case 2://地址
                                $lableField['name'] = $val;
                                $lableField['value'] = $value->address;
                                break;
                            default:
                                $lableField['name'] = $val;
                                $v = 'v'.$k;
                                $lableField['value'] = $value->$v;
                                break;
                        }
                    }
                }
                $layerArr[$key]['lable_field'] = $lableField;
            }

            //windows弹窗显示字段
            if($value->layer->msgbox){
                $showField = json_decode($value->layer->msgbox);
            }else{
                $showField = json_decode($value->layer->defined);
            }
            $temp = [];
            foreach ($showField as $k => $val){
                switch ($k){
                    case 1://名称
                        $temp[$k]['name'] = $val;
                        $temp[$k]['value'] = $value->name;
                        break;
                    case 2://地址
                        $temp[$k]['name'] = $val;
                        $temp[$k]['value'] = $value->address;
                        break;
                    default:
                        $temp[$k]['name'] = $val;
                        $v = 'v'.$k;
                        $temp[$k]['value'] = $value->$v;
                        break;
                }
            }
            $layerArr[$key]['show_field'] = $temp;

            $layerArr[$key]['lable'] = $value->layer->lable;
            $layerArr[$key]['is_show'] = $value->layer->is_show;
        }unset($info,$showField,$temp);
        return $layerArr;
    }

    /**
     * 获取门店信息,数据视图使用
     * @author <liangshimao>
     * @param $layerid
     * @param $pageSize
     * @param int $page
     * @param string $search
     * @return mixed
     */
    public static function getStoreByLayer($layerid,$pageSize,$page = 0,$search = '')
    {
        $query = self::find()->where(['layerid' => $layerid])->normal();
        if(!empty($search)){
            $query->andFilterWhere(['like','name',$search]);
        }
        $layerModel = Layer::findOne($layerid);
        if(!empty($layerModel)){
            $query->sort($layerModel->sort,$layerModel->updown);
        }
        $countQuery = clone $query;
        $info['data'] = $query->offset($page*$pageSize)->limit($pageSize)->asArray()->all();
        $info['page'] = $page;
        $info['pages'] = ceil(($countQuery->count())/$pageSize);
        $info['count'] = $countQuery->count();
        $info['head'] = Json::decode($layerModel->defined);
        $info['headcount'] = count($info['head']);
        $info['pageSize'] = $pageSize;
        $info['layername'] = Tools::cutUtf8($layerModel->name, 10);
        return $info;
    }

    /**
     * @desc 获取单条信息
     * @author <miaozhongqiang>
     * @param int $storeid
     * @return array|null|ActiveRecord
     */
    public static function getInfo($storeid)
    {
        $info = self::find()->with('layer')->where(['id' => $storeid])->one();

        $storeInfo['lng'] = $info->lng;
        $storeInfo['lat'] = $info->lat;
        $storeInfo['id'] = $info->id;
        $storeInfo['layerid'] = $info->layer->id;
        if($info->icon) {
            $storeInfo['ico'] = $info->icon;
            $storeInfo['size'] = $info->size;
        }else{
            $storeInfo['ico'] = $info->layer->ico;
            $storeInfo['size'] = $info->layer->size;
        }
        //label自定义显示字段
        if($info->layer->lable) {
            $field = json_decode($info->layer->defined);
            $lableField = [];
            foreach ($field as $k => $val){
                if($info->layer->lable == $k){
                    switch ($k){
                        case 1://名称
                            $lableField['name'] = $val;
                            $lableField['value'] = $info->name;
                            break;
                        case 2://地址
                            $lableField['name'] = $val;
                            $lableField['value'] = $info->address;
                            break;
                        default:
                            $lableField['name'] = $val;
                            $v = 'v'.$k;
                            $lableField['value'] = $info->$v;
                            break;
                    }
                }
            }
            $storeInfo['lable_field'] = $lableField;
        }
        //windows弹窗显示字段
        if($info->layer->msgbox){
            $showField = json_decode($info->layer->msgbox);
        }else{
            $showField = json_decode($info->layer->defined);
        }
        $temp = [];
        foreach ($showField as $k => $val){
            switch ($k){
                case 1://名称
                    $temp[$k]['name'] = $val;
                    $temp[$k]['value'] = $info->name;
                    $temp[$k]['field'] = 'name';
                    break;
                case 2://地址
                    $temp[$k]['name'] = $val;
                    $temp[$k]['value'] = $info->address;
                    $temp[$k]['field'] = 'address';
                    break;
                default:
                    $temp[$k]['name'] = $val;
                    $v = 'v'.$k;
                    $temp[$k]['value'] = $info->$v;
                    $temp[$k]['field'] = 'v'.$k;
                    break;
            }
        }
        $storeInfo['show_field'] = $temp;
        $storeInfo['is_show'] = $info->layer->is_show;
        unset($info,$temp);
        return $storeInfo;
    }
    
    /**
     * 修改图层样式
     */
    public static function editRecord($id, $params) {
        $info = self::findOne($id);
        if (!empty($info)) {
            return self::updateAll($params, ['id' => $id]);
        }
        return false;
    }

    /**
     * @desc 关联
     * @author <miaozhongqiang>
     * @return $this
     */
    public function getLayer(){
        return $this->hasOne(Layer::className(),['id' => 'layerid']);
    }


    /**
     * @inheritdoc
     * @return BaseQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return Yii::createObject(BaseQuery::className(), [get_called_class()]);
    }
}