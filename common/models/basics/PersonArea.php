<?php
/**
 * Created by PhpStorm.
 * User: miaozhongqiang
 * Date: 17-2-11
 * Time: 下午1:05
 */

namespace app\common\models\basics;

use Yii;
use yii\db\ActiveRecord;
use app\common\models\query\BaseQuery;

class PersonArea extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'person_area';
    }

    /**
     * @desc 搜索热区
     * @author <miaozhongqiang>
     * @param array $params
     * @return object
     */
    public static function search($params=[])
    {
        $info = self::find()->normal()->my($params['userid']);
        isset($params['cityid']) && $info->andWhere(['cityid' => $params['cityid']]);
        isset($params['name']) && $info->andWhere(['like','name',$params['name']]);
        return $info->all();
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
