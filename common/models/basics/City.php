<?php
/**
 * Created by PhpStorm.
 * User: luohua
 * Date: 17-1-12
 * Time: 下午6:05
 */

namespace app\common\models\basics;


use yii\db\ActiveRecord;

class City extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'map_city';
    }
    public function rules(){
        return [
            [
                ['id','name','city_id','lng','lat'],'safe'
            ]
        ];
    }
    public static function tableDesc() {
        return '城市';
    }

    /**
     * @desc 搜索城市
     * @author <miaozhongqiang>
     * @param array $params
     * @return object
     */
    public static function search($params=[])
    {
        $info = self::find()->with(['area' => function ($query) use ($params) {
            $query->normal()->my($params['userid']);
        }]);
        isset($params['name']) && $info->andWhere(['like','name',$params['name']]);
        return $info->all();
    }

    public static function getList(){
        $list  = static::find()->orderBy(['add_time' => SORT_DESC])->asArray()->all();
        return $list;
    }

    /**
     * 根据城市ID查询城市名称
     * @Params int $cityid 城市ID
     * @Author <lixiaobin>
     * @date 2017-10-16
     * @Return Array
    */
    public static function findRecode($cityid, $field = '*'){
        if(empty($cityid)) return false;
        return self::find()->select($field)->where(['city_id' => $cityid])->one();
    }

    /**
     * @desc 关联
     * @author <miaozhongqiang>
     * @return $this
     */
    public function getArea(){
        return $this->hasMany(PersonArea::className(),['cityid' => 'city_id']);
    }
}
