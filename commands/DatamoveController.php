<?php
/**
 * 执行数据库迁移的命令
 * @author <liangshimao>
 *
 */

namespace app\commands;

use app\common\models\basics\City;
use app\common\models\basics\Layer;
use app\common\models\basics\Layout;
use app\common\models\basics\PersonStore;
use yii\console\Controller;
use Yii;
class DatamoveController extends Controller
{
    public function actionIndex()
    {
        $userid = 106;   //导入到新表要使用的用户id
        $selectUserId =141;  //需要转移的数据的用户id
        $connection  = Yii::$app->mdb;
        $db = 'fangtu_online_online';


        //项目数据迁移
        $layoutSql = 'select * from '. $db .'.person_layout where user_id='.$selectUserId;
        $layout = $connection->createCommand($layoutSql)->queryAll();

        foreach ($layout as $v1){
            $layoutModel = new Layout();
            $layoutModel->setAttributes([
                'name' => $v1['name'],
                'cityid' => $v1['city_id'],
                'addtime' => $v1['add_time'],
                'edittime' => $v1['edit_time'],
                'creator' => $userid,
                'updater' => $userid,
                'operator' => $userid,
            ],false);
            if($layoutModel->save()){
                echo "成功插入{$layoutModel->name}-----------------------项目!\n";
            }

            $layerSql = 'select * from '. $db .'.person_layer where user_id='.$selectUserId.' and layout_id='.$v1['id'];
            $layer = $connection->createCommand($layerSql)->queryAll();
            foreach ($layer as $v2){
                $layerModel = new Layer();
                $layerModel->setAttributes([
                    'layoutid' => $layoutModel->id,
                    'name' => $v2['name'],
                    'ico' => 'ff0000-s-null.png',
                    'size' => 's',
                    'defined' => '{"1":"\u540d\u79f0","2":"\u5730\u5740"}',
                    'creator' => $userid,
                    'updater' => $userid,
                    'operator' => $userid,
                    'type' => $v2['type'],
                    'title' => $v2['title'],
                    'sort' => $v2['sort'],
                    'addtime' => $v2['add_time'],
                    'edittime' => $v2['edit_time'],
                ],false);
                if($layerModel->save()){
                    Layer::editRecord($layerModel->id,['layer_sort' => $layerModel->id]);
                    echo "成功插入{$layerModel->name}------------图层!\n";
                }

                $layerSql = 'select * from '. $db .'.person_store_data where user_id='.$selectUserId.' and layer_id='.$v2['id'];
                $store = $connection->createCommand($layerSql)->queryAll();
                foreach ($store as $v3){
                    $storeModel = new PersonStore();
                    $storeModel->setAttributes([
                        'layoutid' => $layoutModel->id,
                        'layerid' => $layerModel->id,
                        'name' => $v3['name'],
                        'creator' => $userid,
                        'updater' => $userid,
                        'operator' => $userid,
                        'address' => $v3['address'],
                        'lat' => $v3['lat'],
                        'lng' => $v3['lng'],
                        'edittime' => $v3['edit_time'],
                        'addtime' => $v3['add_time'],
                    ],false);
                    if($storeModel->save()){
                        echo "成功插入{$storeModel->name}门店!\n";
                    }
                }
            }
        }

        echo "开始导入城市-------------!";

        $layoutSql = 'select * from '. $db .'.map_city';
        $layout = $connection->createCommand($layoutSql)->queryAll();

        foreach ($layout as $v4) {
            $layoutModel = new City();
            $layoutModel->setAttributes([
                'name' => $v4['name'],
                'city_id' => $v4['city_id'],
                'lng' => $v4['lng'],
                'lat' => $v4['lat'],
                'add_time' => date('Y-m-d H:i:s'),
                'sync_time' => date('Y-m-d H:i:s'),
            ], false);
            if ($layoutModel->save()) {
                echo "成功插入{$layoutModel->name}-----------------------城市!\n";
            }
        }


        echo "执行完毕!\n";



    }
}