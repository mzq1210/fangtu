<?php

/**
 * Created by PhpStorm.
 * User: miaozhongqiang
 * Date: 17-1-11
 * Time: 上午11:29
 * Desc: 图层类
 */

namespace app\common\models\basics;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\ActiveRecord;
use app\common\models\query\BaseQuery;
class Layer extends ActiveRecord {

    public static function tableName() {
        return 'person_layer';
    }

    /**
     * 添加图层
     * @Params $info 入库图层信息
     * @Return boole
     * @Author <lixiaobin>
     * @Date   2017-01-12
     */
    public static function addRecord($info) {
        $model = new Layer();
        $model->setAttributes($info, false);
        if ($model->save()) {
            return self::editRecord($model->id, ['layer_sort' => $model->id]);
        }
        return false;
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

    public static function findRecord($id, $field = '*') {
        $info = self::find()->select($field)->where('id = :id', [':id' => $id])->asArray()->one();
        return $info;
    }

    public static function searchLayer($layout_id, $userid) {
        if (!empty($layout_id)) {
            $infos = self::find()->where(['layoutid' => $layout_id])->normal()->display()->my($userid)->orderBy(['layer_sort' => SORT_ASC])->asArray()->all();
            return $infos;
        } else {
            return false;
        }
    }

    //一对多
    public function getStore() {
        return $this->hasMany(PersonStore::className(), ['layerid' => 'id'])->andFilterWhere(['del_flag' => 0])->limit(10);
    }

    //二位数组排序
    public static function arraySort($arr, $sort = 1) {
        foreach ($arr as $key => $val) {
            $res[] = $val;
            $valArr[$key] = $sort == 1 ? $val['view_num'] : ($sort == 2 ? $val['sale_num'] : $val['view_num']);
        }
        array_multisort($valArr, SORT_DESC, $res);
        return $res;
    }

    /**
     * 分页显示某项目下的所有图层
     * @author <liangshimao>
     * @param $layout_id
     */
    public static function searchLayerPage($layoutid, $userid) {
        $query = self::find()->where(['layoutid' => $layoutid])->normal()->my($userid)->orderBy(['is_display'=>SORT_ASC,'layer_sort' => SORT_ASC]);
        $info['data'] = $query->all();
        return $info;
    }

    /**
     * 获取label名称
     * @param int $layerId 图层ID
     * @param int $fieldId 自定义字段ID
     * @return string or array 返回自定义名称数组或自定义字段名
     * @author <liangpingzheng>
     * @Data 2017-01-19
     */
    public static function lable($layerId, $fieldId = 0) {
        $ret = '';
        $info = self::findRecord($layerId, 'defined');
        if ($info) {
            $data = Json::decode($info['defined']);
            if ($fieldId && isset($data[$fieldId])) {
                $ret = $data[$fieldId];
            } else if ($layerId) {
                $ret = $data;
            }
        }
        unset($data);
        return $ret;
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
