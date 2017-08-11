<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 17-5-26
 * Time: 下午2:33
 */

namespace app\commands;

use app\common\models\basics\PersonArea;
use yii\console\Controller;
use Yii;

class AreamoveController extends Controller
{
    public function actionIndex()
    {

        $connection  = Yii::$app->mdb;
        $db = 'test';
        $userid  = 5;
        $colorArray = ['f1f075','eaf7ca','c5e96f','a3e46b','7ec9b1','b7ddf3','63b6e5','548cba','677da7','9c89cc','d27591','f5c272','cccccc'];
        $colorCount = count($colorArray);
        $cityRelation = ['110000'=>'2','120000'=>'3','140100'=>'8','310000'=>'4','320100'=>'9','330100'=>'11','510100'=>'17','420100'=>'15'];

        //项目数据迁移
        foreach ($cityRelation as $cityLian=> $city){

            $areaSql = 'select * from '. $db .'.business where city=' . $cityLian;
            $area = $connection->createCommand($areaSql)->queryAll();

            foreach ($area as $k=>$v1) {
                $areaModel = new PersonArea();
                $areaModel->setAttributes([
                    'name' => $v1['name'],
                    'point' => '"'.$v1['longitude'].','.$v1['latitude'].'|'.str_replace(';', '|', $v1['position_border']) . '"',
                    'type' => 4,
                    'style' => '{"fillcolor":"'. $colorArray[$k%$colorCount] .'","linecolor":"f00","linewidth":"3"}',
                    'remark' => $v1['name'],
                    'addtime' => date('Y-m-d H:i:s'),
                    'edittime' => date('Y-m-d H:i:s'),
                    'creator' => $userid,
                    'updater' => $userid,
                    'operator' => $userid,
                    'cityid' => $city,
                ], false);

                if ($areaModel->save()) {
                    echo "成功插入{$areaModel->name}-----------------------商圈!\n";
                }

            }
        }

    }
}