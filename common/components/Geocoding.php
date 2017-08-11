<?php
/**
 * Created by PhpStorm.
 * User: mzq
 * Date: 16-8-9
 * Time: 下午19:36
 */

namespace app\common\components;

class Geocoding {

    //百度API
    const API = 'http://api.map.baidu.com/geocoder/v2/';

    //百度AK
    const API_AK = 'epwsls9Hr7CzV8ivdLtfytxGCMC0xLR5';

    //不显示周边数据
    const NO_POIS = 0;

    //显示周边数据
    const POIS = 1; 

    /**
     * 根据地址获取国家、省份、城市及周边数据
     * @param  float $longitude 经度
     * @param  float $latitude  纬度
     * @param  Int   $pois      是否显示周边数据
     * @return array
     */
    public static function getAddressComponent($longitude, $latitude, $pois=self::NO_POIS){
        $param = array(
                'ak' => self::API_AK,
                'location' => implode(',', array($latitude, $longitude)),
                'pois' => $pois,
                'output' => 'json'
        );

        // 请求百度api
        $response = self::toCurl(self::API, $param);
        $result = array();
        if($response){
            $result = json_decode($response, true);
        }
        return $result;
    }

    /**
     * 根据地址获取经纬度
     * @param  string  $address    具体地址
     * @return array
     */
    public static function getPoint($address, $city=''){
        $param = array(
            'ak' => self::API_AK,
            'address' => $address,
            'city' => $city,
            'output' => 'json'
        );
        if($city == '') unset($param['city']);

        // 请求百度api
        $response = self::toCurl(self::API, $param);
        $result = array();
        if($response){
            $result = json_decode($response, true);
        }
        if($result['status'] == 0){
            return $result['result']['location'];
        }else{
            return 'AK值错误';
        }

    }


    /**
     * 使用curl调用百度Geocoding API
     * @param  String $url    请求的地址
     * @param  array  $param  请求的参数
     * @return JSON
     */
    private static function toCurl($url, $param=array()){
        $ch = curl_init();
        if(substr($url,0,5)=='https'){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
        $response = curl_exec($ch);
        if($error=curl_error($ch)){
            return false;
        }
        curl_close($ch);

        return $response;
    }

}

?>