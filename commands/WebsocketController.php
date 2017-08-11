<?php

/**
 * Created by PhpStorm.
 * User: leexb
 * Date: 17-1-9
 * Time: 下午1:01
 */
namespace app\commands;

use app\common\models\basics\Layer;
use Yii;
use yii\console\Controller;
use yii\helpers\Json;
use app\common\models\basics\PersonStore;
use app\common\models\basics\Layout;
use app\common\models\basics\City;
use app\common\components\Geocoding;
use PHPExcel_IOFactory;

class WebsocketController extends Controller{

    private $server;

    public function init(){
        parent::init();
        $this->server = new \swoole_websocket_server(HOST, PORT);
    }

    public function actionIndex()
    {

        $this->server->on('open', function ( $server, $request) {
            //echo "server: handshake success with fd{$request->fd}\n";

        });

        $this->server->on('message', function ( $server, $frame) {
            //echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            $params = Json::decode($frame->data);
            switch ($params['type']){
                case 'layer':

                    $this->getStore($frame->fd, $params);
                    break;
                case 'upload':
                    $this->upload($frame->fd, $params);
                    break;
                case 'searchData':
                    $this->listStore($frame->fd, $params);
                    break;
                case 'loadLayerStore':
                    $this->loadLayerStore($frame->fd, $params);
                    break;
                case 'sortStore':
                    $this->sortStore($frame->fd, $params);
                    break;
            }
        });

        $this->server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });
        $this->server->start();
    }

    private function getStore($fd, $info){
        $arr = PersonStore::getStore($info);
        $num = 0;
        foreach ($arr as $val){
            if($num == 0) sleep(1);
            usleep(4000);
            $val['type'] = 'init';
            $this->server->push($fd, Json::encode($val));
            $num++;
        }
    }

    private function loadLayerStore($fd, $data){
        $layer = Layer::findOne($data['layer']);
        $ico = $layer['ico'];
        $layerStore = PersonStore::find()->where(['layerid'=>$data['layer']])->offset(LAYER_NUM)->asArray()->all();
        foreach ($layerStore as $k=>$v){
            if($layer['title'] == 1) {
                //$storearr[$k]['showColumn'] = $v['name'];
                $v['showColumn'] = $v['name'];
            }
            if($layer['title'] == 2) {
                //$storearr[$k]['showColumn'] = $v['address'];
                $v['showColumn'] = $v['address'];
            }
            $v['ico'] = $ico;
            $v['type'] = 'loadLayerStore';
            usleep(40000);
            $this->server->push($fd, Json::encode($v));
        }
    }

    private function listStore($fd, $data){
        $layer = Layer::findOne($data['layer']);
        $layer['title'] = $data['column'];
        $ico = $layer['ico'];
        $layer->save();
        $storearr = PersonStore::find()->where(['layerid'=>$data['layer']])->asArray()->all();
        foreach ($storearr as $k => $v){
            if($layer['title'] == 1) {
                //$storearr[$k]['showColumn'] = $v['name'];
                $v['showColumn'] = $v['name'];
            }elseif($layer['title'] == 2) {
                //$storearr[$k]['showColumn'] = $v['address'];
                $v['showColumn'] = $v['address'];
            }else{
                $v['showColumn'] = $v['v'.$layer['title']];
            }
            $v['ico'] = $ico;
            $v['type'] = 'searchData';
            usleep(40000);
            $this->server->push($fd, Json::encode($v));
        }
       /* $returnData = [
            'type' => 'searchData',
            'layerid' => $data['layer'],
            'data' => $storearr
        ];
        $this->server->push($fd, Json::encode($returnData));*/
    }

    /**
     * @desc excel批量导入
     * @author <wangluohua>
     */
    private function upload($fd, $data){
        $update_path = Yii::getAlias('@app') . '/data/';
        $exe =   substr(strstr($data['data'], ';', TRUE),strrpos(strstr($data['data'], ';', TRUE),'.')+1);
        if($exe == 'xlsx' || $exe == 'xls' || $exe == 'sheet'){
            //$exe = '.xlsx';
            $tmp = base64_decode(substr(strstr($data['data'], ','), 1));
            $path = $update_path . date('YmdHis').mt_rand(1000,9999) .".". $exe;
            file_put_contents($path, $tmp);

            $file = $path;
            $user_id = $data['userid'];
            $layout_id = $data['layout'];
            $layer_id = $data['layer'];
            $layer = Layer::findOne($data['layer']);
            $ico = $layer['ico'];
            $cityId = Layout::findOne($layout_id)->cityid;
            $cityName = City::find()->where(['city_id'=>$cityId])->one();
            if (file_exists($file)) {
                $PHPExcel = PHPExcel_IOFactory::load($file); // Reader读出来后，加载给Excel实例
                $sheet = $PHPExcel->getActiveSheetIndex(); // sheet数
                $currentSheet = $PHPExcel->getSheet($sheet); // 拿到第一个sheet（工作簿？）
                $allRow = $currentSheet->getHighestRow(); // 最大的行，比如12980. 行从0开始
                $allCol = $currentSheet->getHighestColumn();
                $end_index  = \PHPExcel_Cell::columnIndexFromString($allCol);
                $maxColumn = $end_index > MAX_EXCLE_COLUMN ? MAX_EXCLE_COLUMN : $end_index;
                $modeold = new PersonStore();
                $yesRow = 0 ;
                $noRow = 0 ;
                for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
                    $layerValue = [];
                    for ($column = 1; $column <= $maxColumn; $column++){
                        $columnS = chr($column+64);
                        $value = trim($currentSheet->getCell($columnS.$currentRow)->getValue());
                        if ($currentRow == 1 && !empty($value)){
                            $layerValue[$column] = $value;
                        }elseif($currentRow !== 1){
                            $layerValue[$column] = $value;
                        }
                    }
                    if ($currentRow == 1) {
                        $trueCol = count($layerValue);
                        $layerSave = [
                          'defined' => json_encode($layerValue)
                        ];
                        $personStore = PersonStore::find()->where(['layerid'=>$layer_id])->asArray()->one();
                        if (!empty($personStore)){
                            if ($layerSave['defined']!=$layer->defined){
                                $arr = [
                                    'subType'    => 'columnwrong',
                                    'type'       => 'upload'
                                ];
                                $this->server->push($fd, json_encode($arr));
                                return;
                            }
                        }

                        $layer->setAttributes($layerSave,false);
                        if ($layer->save()){
                            continue;
                        }
                        break;
                    }
                    //根据地址获取经纬度
                    if (empty($layerValue[1]) || empty($layerValue[2])){
                        $noRow++;
                        $arr = [
                            'creator'    => $user_id,
                            'layoutid'   => $layout_id,
                            'layerid'    => $layer_id,
                            'name'       => "",
                            'address'    => "",
                            'allRow'     => $allRow - 1,
                            'noRow'      => $noRow,
                            'yesRow'     => $yesRow,
                            'nowRow'     => $currentRow -1,
                            'subType'    => 'no',
                            'type'       => 'upload'
                        ];
                        $this->server->push($fd, json_encode($arr));
                        continue;
                    }
                    $yesRow++;
                    $point = Geocoding::getPoint($layerValue[2], $cityName);
                    if ($point == 'AK值错误') {
                        $point = array();
                        $point['lat'] = '';
                        $point['lng'] = '';
                    }
                    $arr = array();
                    $arr = [
                        'creator'    => $user_id,
                        'operator'    => $user_id,
                        'layoutid'   => $layout_id,
                        'layerid'    => $layer_id,
                        'name'       => $layerValue[1],
                        'address'    => $layerValue[2],
                        'lat'        => $point['lat'],
                        'lng'        => $point['lng'],
                        'addtime'    => date('Y-m-d H:i:s'),
                        'edittime'   => date('Y-m-d H:i:s'),
                        'allRow'     => $allRow - 1,
                        'noRow'      => $noRow,
                        'yesRow'     => $yesRow,
                        'nowRow'     => $currentRow -1,
                        'ico'        => $ico,
                        'lable'      => 0,
                    ];
                    for ($v = 3; $v <= $trueCol; $v++){
                        $arr['v'.$v] = $layerValue[$v];
                    }
                    $mode = clone $modeold;
                    $mode->setAttributes($arr,false);
                    if($mode->save()){
                        $arr['type'] = 'upload';
                        $arr['subType'] = 'yes';
                        $arr['id'] = $mode->primaryKey;
                        $this->server->push($fd, json_encode($arr));
                    }else{

                    }

                }
                if (!empty($status))
                    unlink($file);
            }
            
        }
    }
    /**
     * @desc 左侧列表排序
     * @author <wangluohua>
     */
    private function sortStore($fd, $data){
        $layer = Layer::findOne($data['layer']);
        $ico = $layer['ico'];
        if ($data['sortRadio'] == 'default'){
            $storearr = PersonStore::find()->where(['layerid'=>$data['layer']])->asArray()->all();
            Layer::editRecord($data['layer'], ['sort' => 0]);
        }else{
            if ($data['sortSelect'] == 1){
                $orderColumn = 'name';
            }elseif($data['sortSelect'] == 2){
                $orderColumn = 'address';
            }else{
                $orderColumn = 'v'.$data['sortSelect'];
            }
            $orderby = $orderColumn." ".$data['sortRadio'];
            $storearr = PersonStore::find()->where(['layerid'=>$data['layer']])->orderBy($orderby)->asArray()->all();
            Layer::editRecord($data['layer'], ['sort' => $data['sortSelect'],'updown'=> $data['sortRadio']]);
        }

        foreach ($storearr as $k => $v){
            if($layer['title'] == 1) {
                //$storearr[$k]['showColumn'] = $v['name'];
                $v['showColumn'] = $v['name'];
            }
            if($layer['title'] == 2) {
                //$storearr[$k]['showColumn'] = $v['address'];
                $v['showColumn'] = $v['address'];
            }
            $v['ico'] = $ico;
            $v['type'] = 'sortStore';
            usleep(40000);
            $this->server->push($fd, Json::encode($v));
        }
    }
}