<?php

/**
 * socket后台执行任务
 * @author <liangpingzheng>
 */

namespace app\commands;


use Yii;
use PHPExcel_IOFactory;
use yii\helpers\Json;
use yii\console\Controller;
use app\common\models\basics\Layout;
use app\common\components\BaseCache;
use app\common\models\basics\Layer;
use app\common\models\basics\City;
use app\common\components\Geocoding;
use app\common\models\basics\PersonStore;

class SocketController extends Controller {

    private $server;

    public function init() {
        parent::init();
        $this->server = new \swoole_websocket_server(HOST, PORT);
    }

    public function actionIndex() {

        $this->server->on('open', function ( $server, $request) {
            //echo "server: handshake success with fd{$request->fd}\n";
        });

        $this->server->on('message', function ( $server, $frame) {
            $params = Json::decode($frame->data);
            switch ($params['type']) {
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
            //echo "client {$fd} closed\n";
        });
        $this->server->start();
    }

    private function getStore($fd, $info) {
        $arr = PersonStore::getStore($info);
        foreach ($arr as $key => $val) {
            if (!$key) {
                sleep(1);
            }
            $val['type'] = 'init';
            $this->server->push($fd, Json::encode($val));
            usleep(4000);
        }
    }

    private function loadLayerStore($fd, $data) {
        $layer = Layer::findOne($data['layer']);
        $ico = $layer['ico'];
        $layerStore = PersonStore::find()->where(['layerid' => $data['layer']])->normal()->sort($layer->sort,$layer->updown)->offset(LAYER_NUM)->asArray()->all();
        foreach ($layerStore as $k => $v) {
            if ($layer['title'] == 1) {
                $v['showColumn'] = $v['name'];
            } elseif ($layer['title'] == 2) {
                $v['showColumn'] = $v['address'];
            } else {
                $v['showColumn'] = $v['v' . $layer['title']];
            }
            $v['ico'] = $ico;
            $v['type'] = 'loadLayerStore';
            usleep(40000);
            $this->server->push($fd, Json::encode($v));
        }
    }

    private function listStore($fd, $data) {
        $layer = Layer::findOne($data['layer']);
        $layer['title'] = $data['column'];
        $ico = $layer['ico'];
        $layer->save();

        $storearr = PersonStore::find()->where(['layerid' => $data['layer']])->normal()->sort($layer->sort,$layer->updown)->limit(LAYER_NUM)->asArray()->all();
        foreach ($storearr as $k => $v) {
            if ($layer['title'] == 1) {
                $v['showColumn'] = $v['name'];
            } elseif ($layer['title'] == 2) {
                $v['showColumn'] = $v['address'];
            } else {
                $v['showColumn'] = $v['v' . $layer['title']];
            }
            $v['ico'] = $ico;
            $v['type'] = 'searchData';
            usleep(40000);
            $this->server->push($fd, Json::encode($v));
        }
    }

    /**
     * 批量导入数据
     * @param type $fd
     * @param array $data 上传数据
     * @return object  socket指定格式
     * @author <liangpingzheng>
     * @data 2017/2/8
     */
    private function upload($fd, $data) {
        $path = Yii::getAlias('@app') . '/data/';
        $extension = substr(strstr($data['data'], ';', TRUE), strrpos(strstr($data['data'], ';', TRUE), '.') + 1);
        if (in_array($extension, ['xlsx', 'xls', 'sheet','ms-excel'])) {
            $fileStream = base64_decode(substr(strstr($data['data'], ','), 1));
            $file = $path . date('YmdHis') . mt_rand(1000, 9999) . "." . $extension;
            file_put_contents($file, $fileStream);

            $user_id = $data['userid'];
            $layout_id = $data['layout'];
            $layer_id = $data['layer'];
            $layer = Layer::findOne($data['layer']);
            $ico = $layer['ico'];
            $cityId = Layout::findOne($layout_id)->cityid;
            $objCityInfo = City::find()->where(['city_id' => $cityId])->one();
            $cityName = $objCityInfo->name;

            if (file_exists($file)) {
                $PHPExcel = PHPExcel_IOFactory::load($file); // Reader读出来后，加载给Excel实例
                $sheet = $PHPExcel->getActiveSheetIndex(); // sheet数
                $currentSheet = $PHPExcel->getSheet($sheet); // 拿到第一个sheet（工作簿？）
                $allRow = $currentSheet->getHighestDataRow(); // 最大的行，比如12980. 行从0开始
                $allCol = $currentSheet->getHighestDataColumn();
                $highestColumm = \PHPExcel_Cell::columnIndexFromString($allCol); //字母列转换为数字列 如:AA变为27
                unlink($file);

                /*
                 * define 获取表头
                 */
                $defined = [];
                $k = 1;
                for ($i = 1; $i <= $highestColumm; $i++) {
                    $value = trim($currentSheet->getCell(chr(64 + $i) . 1)->getValue());
                    if (!$value) {
                        continue;
                    }
                    $defined[$k] = $value;
                    $k++;
                }
                $labelNum = count($defined); //标题数量
                if($labelNum > 7){
                    $labelNum = 7;
                    $defined = array_slice($defined, 0,7,true);
                }
                if ($labelNum < 2) {
                    $arr = [
                        'subType' => 'rowerror',
                        'msg' => "Excel列数最少为 2 列",
                        'type' => 'upload'
                    ];
                    $this->server->push($fd, json_encode($arr));
                    return;
                }

                /*
                 * data 获致数据
                 *
                 */
                $data = [];
                for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
                    $key = 1;
                    $temp = [];
                    for ($column = 1; $column <= $highestColumm; $column++) {
                        $title = trim($currentSheet->getCell(chr(64 + $column) . 1)->getValue());
                        $value = trim($currentSheet->getCell(chr(64 + $column) . $currentRow)->getValue());
                        if (!$title) {
                            continue;
                        }
                        $temp[$key] = $value;
                        $key++;
                    }
                    if (empty(array_filter($temp))) {
                        continue;
                    }
                    if(count($temp)>7){
                        $temp = array_slice($temp, 0,7,true);
                    }
                    array_push($data, $temp);
                }
                $total = count($data);

                if ($total > MAX_EXCLE_ROW) {
                    $arr = [
                        'subType' => 'rowerror',
                        'msg' => "数据超过最大条数限制,最大条数" . MAX_EXCLE_ROW . '条',
                        'type' => 'upload'
                    ];
                    $this->server->push($fd, json_encode($arr));
                    return;
                }

                /**
                 * 执行入库数据
                 */
                $modeold = new PersonStore();
                $successRow = 0;
                $errorRow = 0;
                $errData = []; //存储错误信息
                $totalRow = $total;
                foreach ($data as $key => $plist) {

                    //判断定义字段与导入excel的标题字段是否数量相等
                    if (!$key) {
                        $layerSave = [
                            'defined' => json_encode($defined)
                        ];
                        if ($layer->defined) {
                            $objData = json_decode($layer->defined);
                            $oldLabelNum = count((array) $objData);
                            $storeInfo = PersonStore::find()->where(['layerid' => $layer_id, 'del_flag'=>0])->one();
                            if ($storeInfo && $oldLabelNum != $labelNum) {
                                $arr = [
                                    'subType' => 'columnwrong',
                                    'msg' => "批量导入数据的标题与原数据不匹配",
                                    'type' => 'upload'
                                ];
                                $this->server->push($fd, json_encode($arr));
                                return;
                            }
                        }
                        if (empty($storeInfo)){
                            $layerSave['msgbox'] = json_encode($defined);
                        }
                        $layer->setAttributes($layerSave, false);
                        $layer->save();
                    }

                    //加入判断  如果前两字段有一个为空 则返回错误,不进行入库
                    if (!$plist[1] || !$plist[2]) {
                        $errorRow++;
                        array_push($errData, $plist);
                        continue;
                    }

                    $point = Geocoding::getPoint($plist[2], $cityName);
                    if ($point == 'AK值错误') {
                        $errorRow++;
                        array_push($errData, $plist);
                        $arr = [
                            'creator' => $user_id,
                            'layoutid' => $layout_id,
                            'layerid' => $layer_id,
                            'name' => "",
                            'address' => "",
                            'allRow' => $total,
                            'noRow' => $errorRow,
                            'yesRow' => $successRow,
                            'nowRow' => $key,
                            'subType' => 'no',
                            'type' => 'upload'
                        ];
                        $this->server->push($fd, json_encode($arr));
                        continue;
                    } else {

                        $arr = [
                            'creator' => $user_id,
                            'updater' => $user_id,
                            'operator' => $user_id,
                            'layoutid' => $layout_id,
                            'layerid' => $layer_id,
                            'name' => $plist[1],
                            'address' => $plist[2],
                            'lat' => $point['lat'],
                            'lng' => $point['lng'],
                            'addtime' => date('Y-m-d H:i:s'),
                            'edittime' => date('Y-m-d H:i:s'),
                            'allRow' => $total,
                            'noRow' => $errorRow,
                            'yesRow' => $successRow + 1,
                            'nowRow' => $key + 1,
                            'ico' => $ico,
                            'lable' => 0,
                            'is_show' => 1,
                        ];

                        if ($labelNum >= 3) {
                            for ($v = 3; $v <= $labelNum; $v++) {
                                $arr['v' . $v] = $plist[$v];
                            }
                        }

                        $isNew = false;
                        $model = PersonStore::find()->where(['layerid' => $layer_id, 'name' => $plist[1], 'del_flag'=>0])->one();
                        if (!$model) {
                            $isNew = true;
                            $model = clone $modeold;
                        }else{
                            $totalRow--;
                        }

                        $model->setAttributes($arr, false);
                        if ($model->save()) {

                            $successRow++;
                            $arr['type'] = 'upload';
                            $arr['subType'] = 'yes';
                            $arr['id'] = $model->primaryKey;
                            $arr['show_field'] = [
                                '1' => [
                                    'name' => $defined[1],
                                    'value' => $plist[1]
                                ],
                                '2' => [
                                    'name' => $defined[2],
                                    'value' => $plist[2]
                                ]
                            ];
                            if ($isNew) {
                                $this->server->push($fd, json_encode($arr));
                            }
                        }
                        unset($data[$key]);
                    }
                }
                if (!$totalRow){
                    $arr = [
                        'subType' => 'alreadyexist',
                        'msg' => "文件以存在请重新选择上传的文件!",
                        'type' => 'upload'
                    ];
                    $this->server->push($fd, json_encode($arr));
                }

                if ($errorRow == $total) {
                    $arr = [
                        'subType' => 'columnwrong',
                        'msg' => "API接口调用次数今日已达到上限,请明天再来!",
                        'type' => 'upload'
                    ];
                    $this->server->push($fd, json_encode($arr));
                }
                $url = '';
                if($errorRow > 0 && count($errData) > 0){
                    $key = md5($layer_id);
                    BaseCache::delete($key);
                    $url = '/basics/layer/errorxport?error='.$key;
                    array_unshift($errData, $defined);
                    BaseCache::set($key,json_encode($errData),time()+86400);
                    unset($errData);
                }

                $this->server->push($fd, json_encode(['type' => 'upload', 'subType' => 'finish', 'msg' => '恭喜,数据解析处理完成!', 'download'=>$url]));
            }
        }
    }

    private function sortStore($fd, $data) {
        $layer = Layer::findOne($data['layer']);
        $ico = $layer['ico'];
        if ($data['sortRadio'] == 'default') {
            $storeArr = PersonStore::find()->where(['layerid' => $data['layer']])->normal()->limit(LAYER_NUM)->asArray()->all();
            Layer::editRecord($data['layer'], ['sort' => 0]);
        } else {
            $storeArr = PersonStore::find()->where(['layerid' => $data['layer']])->normal()->sort($data['sortSelect'],$data['sortRadio'])->limit(LAYER_NUM)->asArray()->all();
            Layer::editRecord($data['layer'], ['sort' => $data['sortSelect'], 'updown' => $data['sortRadio']]);
        }

        foreach ($storeArr as $k => $v) {
            if ($layer['title'] == 1) {
                $v['showColumn'] = $v['name'];
            } elseif ($layer['title'] == 2) {
                $v['showColumn'] = $v['address'];
            } else {
                $v['showColumn'] = $v['v' . $layer['title']];
            }
            $v['ico'] = $ico;
            $v['type'] = 'sortStore';
            usleep(40000);
            $this->server->push($fd, Json::encode($v));
        }
    }

}