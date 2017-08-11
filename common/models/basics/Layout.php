<?php
/**
 * Created by PhpStorm.
 * User: luohua
 * Date: 17-1-12
 * Time: 下午6:04
 */

namespace app\common\models\basics;


use app\common\models\query\BaseQuery;
use Yii;
use yii\db\ActiveRecord;

class Layout extends ActiveRecord{

    public static function tableName(){
        return 'person_layout';
    }

    public static function tableDesc(){
        return '用户创建项目';
    }

    public function rules(){
        return [
            [
                [
                    'id',  'name', 'cityid', 'addtime', 'edittime'
                ],
                'safe'
            ]
        ];
    }

    public static function addRecode($info){
        $model = new Layout();
        $model->setAttributes($info, false);
        return $model->save();
    }

    /**
     * 根据userid和cityid查询项目
     * @Params  int OR arr $userid 用户id  可以为整形 也 可以为一位数组 如：array($userid)
     * @Author <lixiaobin>
     * @Date 2017-01-16
     * @Return Array
    */
    public static function findRecode($userid){
        if(empty($userid) && empty($cityid)) return false;
        //$layoutArr = self::find()->where(['operator' => $userid, 'del_flag' => 0])->asArray()->all();
        $layoutArr = self::find()->normal()->my($userid)->asArray()->all();
        if(!empty($layoutArr)){
            foreach($layoutArr as $key => $val){
                //获取城市名称
                $val['cityName'] = City::findRecode($val['cityid'],'name')->name;
                //统计图层数量
                $val['layerNum'] = Layer::find()->where(['layoutid' => $val['id']])->normal()->my($userid)->count();
                $val['storeNum'] = PersonStore::find()->where(['layoutid' => $val['id']])->normal()->my($userid)->count();
                $info[$key] = $val;
            }
        }
        return isset($info) ? $info : false;
    }

    /**
     * 根据layoutid 查询地图项目信息
     * @Params int $id layoutid
     * @Author <lixiaobin>
     * @Date 2017-01-17
     * @Return Array
    */
    public static function findOneInfo($id, $userid, $feild = '*'){
        $layoutInfo = self::find()->select($feild)->where(['id' => $id])->normal()->my($userid)->asArray()->one();
        return $layoutInfo;
    }

    /**
     * 更新地图项目名称及城市
     * @Params int id layoutid
     *         Array $params  如:array('name'=>'海淀区地图')
     * @Author <lixiaobin>
     * @Date 2017-01-17
     * @Return Bool
    */
    public static function editRecode($id, $params){
        $info = self::findOne($id);
        if(!empty($info)){
            return self::updateAll($params,['id' => $id]);
        }
        return false;
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