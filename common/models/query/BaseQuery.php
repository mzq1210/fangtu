<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 17-2-15
 * Time: 下午6:32
 */

namespace app\common\models\query;


use yii\db\ActiveQuery;

class BaseQuery extends ActiveQuery
{
    /**
     * 未被删除的
     */
    public function normal()
    {
        return $this->andWhere(['del_flag' => 0]);
    }

    /**
     * 自己的数据
     */
    public function my($userId)
    {
        return $this->andWhere(['operator' => $userId]);
    }

    /**
     * 未隐藏的数据 layer 特有的方法
     */
    public function display()
    {
        return $this->andWhere(['is_display' => 0]);
    }

    /**
     * 排序封装  门店特有的方法
     * $sort 对应layer表中的sort字段属性,按照哪个字段排序
     * $updown 对应layer表中的updown字段,表示正序或者逆序
     */
    public function sort($sort,$updown)
    {
        switch ($sort){
            case '0':
                return $this;
                break;
            case '1':
                return $this->orderBy('convert(`name` using gbk)'.' '.$updown);
                break;
            case '2':
                return $this->orderBy('convert(`address` using gbk)'.' '.$updown);
                break;
            default:
                return $this->orderBy('`v'.$sort.'`+0'.' '.$updown);
                break;
        }
    }
}