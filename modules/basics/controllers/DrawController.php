<?php
/**
 * Created by PhpStorm.
 * User: miaozhongqiang
 * Date: 17-2-11
 * Time: 上午10:05
 */
namespace app\modules\basics\controllers;

use Yii;
use yii\helpers\Json;
use app\common\models\basics\Layout;
use app\common\models\basics\City;
use app\common\components\OutPut;
use app\common\base\BaseController;
use app\common\models\basics\PersonArea;

class DrawController extends BaseController
{
    const BMAP_DRAWING_MARKER = 1;      //点
    const BMAP_DRAWING_CIRCLE = 2;      //圆
    const BMAP_DRAWING_POLYLINE = 3;    //线
    const BMAP_DRAWING_POLYGON = 4;     //多边形

    /*
     * @author <miaozhongqiang>
     */
    public function actionIndex() {
        $params['userid'] = $this->userid;
        $data = City::search($params);

        return $this->renderPartial('index', [
            'data' => $data,
            'cityName'=>'北京',
            'cityId'=>2,
            'userid' => $this->userid
        ]);
    }

    /**
     * @desc    添加
     * @return string
     * @author <miaozhongqiang>
     */
    public function actionCreate()
    {
        $post = $this->request->post();
        $position = json_encode($post['position']);
        $model = new PersonArea();
        $model->point    = $position;
        $model->type     = $post['type'];
        $model->cityid   = $post['cityid'];
        $model->name     = $post['name'];
        $model->remark   = $post['remark'];
        $model->creator  = $this->userid;
        $model->operator = $this->userid;
        $model->addtime = $this->datetime;
        if($model->save()){
            OutPut::returnJson('请求成功', 200);
        }else{
            OutPut::returnJson('请求失败', 201);
        }
    }

    /**
     * @desc 编辑模态框
     * @return string
     * @author <miaozhongqiang>
     */
    public function actionEdit() {
        $id = $this->request->get('id','');
        $model = PersonArea::findOne($id);

        if ($this->request->isPost) {
            $params = $this->request->post();
            $model = PersonArea::findOne($id);
            $data['name'] = $params['name'];
            $data['remark'] = $params['remark'];
            $data['updater'] = $this->userid;
            $data['edittime'] = $this->datetime;
            $model->setAttributes($data, false);
            if($model->save()){
                OutPut::returnJson('操作成功', 200);
            }else{
                OutPut::returnJson('操作失败', 201);
            }
        }else{
            return $this->renderPartial('edit', [
                'model' => $model
            ]);
        }
    }

    /**
     * @desc 对象转数组
     * @param $data
     * @return array
     * @author <miaozhongqiang>
     */
    private function _objToArray($data){
        $temp = [];
        foreach ($data as $key => $value) {
            $temp[$key]['id']    = $value->id;
            $temp[$key]['name'] = $value->name;
            $temp[$key]['remark'] = $value->remark;
            $temp[$key]['type']  = $value->type;
            $temp[$key]['style'] = json_decode($value->style, true);
            if($value->type == self::BMAP_DRAWING_CIRCLE){
                $position = explode(',', json_decode($value->point));
                $temp[$key]['radius'] = $position[0];
                $temp[$key]['lng'] = $position[1];
                $temp[$key]['lat'] = $position[2];
            } else {
                $position = explode('|', json_decode($value->point));
                $posTemp = [];
                foreach ($position as $k => $v){
                    if($v){
                        $posTemp[$k] = explode(',', $v);
                    }
                }
                $temp[$key]['pos'] = $posTemp;
                $temp[$key]['lng'] = $posTemp[0][0];
                $temp[$key]['lat'] = $posTemp[0][1];
            }
        }
        return $temp;
    }

    /**@desc 样式设置
     * @param $id
     * @return string
     */
    public function actionSetstyle($id)
    {
        $model = PersonArea::findOne($id);
        if($this->request->isPost){
            $post = $this->request->post();
            $data = [
                'fillcolor' => $post['fillcolor'],
                'linecolor' => $post['linecolor'],
                'linewidth' => $post['linewidth']
            ];
            $model->style = Json::encode($data);
            if($model->save()){
                OutPut::returnJson('设置成功', 200);
            }else{
                OutPut::returnJson('设置失败', 201);
            }
        }else{
            $style = json_decode($model->style, true);
            $fillcolor = isset($style['fillcolor'])? $style['fillcolor'] : '';
            $linecolor = isset($style['linecolor'])? $style['linecolor'] : 'f00';
            $linewidth = isset($style['linewidth'])? $style['linewidth'] : 3;

            return $this->renderPartial('style', [
                'id' => $id,
                'model' => $model,
                'style' => $style,
                'cityName'=>'北京',
                'fillcolor' => $fillcolor,
                'linecolor' => $linecolor,
                'linewidth' => $linewidth,
            ]);
        }
    }

    /**@desc 获取所有数据(地图绘制)
     * @return string
     */
    public function actionGetall()
    {
        if($this->request->isPost){
            $params = $this->request->post();
            $params['userid'] = $this->userid;
            if(isset($params['layoutid'])){
                $model = Layout::findOne($params['layoutid']);
                $params['cityid'] = $model->cityid;
            }
            $data = PersonArea::search($params);
            $info = $this->_objToArray($data);
            return Json::encode($info);
        }
    }

    /**
     * @desc 删除区域
     * @author <miaozhongqiang>
     */
    public function actionSetposition(){
        if($this->request->isAjax){
            $params = $this->request->post();
            $model = PersonArea::find()->where(['id'=>$params['id']])->one();
            if (empty($model)){
                OutPut::returnJson('请求失败', 202);
            }
            $model->setAttributes(['point'=>json_encode($params['position'])],false);
            if ($model->save()){
                OutPut::returnJson('请求成功', 200);
            }
            OutPut::returnJson('请求失败', 201);
        }
    }

    /**
     * @desc 删除区域
     * @author <miaozhongqiang>
     */
    public function actionDel(){
        if($this->request->isAjax){
            $id = $this->request->get('id','');
            $model = PersonArea::find()->where(['id'=>$id])->one();
            if (empty($model)){
                OutPut::returnJson('请求失败', 202);
            }
            $model->setAttributes(['del_flag'=>1],false);
            if ($model->save()){
                OutPut::returnJson('请求成功', 200);
            }
            OutPut::returnJson('请求失败', 201);
        }
    }

    /**
     * @author <miaozhongqiang>
     */
    public function actionGetinfo_ajax() {
        if (!$this->request->isAjax) {
            OutPut::returnJson('非法请求', 201);
        }
        $id = $this->request->post('id');
        $info = PersonArea::findOne($id);
        $data['id']    = $info->id;
        $data['name'] = $info->name;
        $data['remark'] = $info->remark;
        if($info->type == self::BMAP_DRAWING_CIRCLE){
            $position = explode(',', json_decode($info->point));
            $data['lng'] = $position[1];
            $data['lat'] = $position[2];
        } else {
            $position = explode('|', json_decode($info->point));
            $pos_temp = [];
            foreach ($position as $k => $v){
                if($v){
                    $pos_temp[$k] = explode(',', $v);
                }
            }
            $data['lng'] = $pos_temp[0][0];
            $data['lat'] = $pos_temp[0][1];
        }
        OutPut::returnJson('请求成功', 200, $data);
    }
}
