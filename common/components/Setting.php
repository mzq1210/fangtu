<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\components;

use app\common\models\basics\City;

class Setting {


    public static function getById($id = 2, $field = 'name') {

        $key = "map_city_list";
        //缓存里面取城市列表如果没有取到则从数据库里面取得并存入缓存
        if(!($cityList = BaseCache::get($key))){
            $cityList = City::getList();
            BaseCache::set($key, $cityList),1800;
        }
        //$cityList = City::getList();
        foreach ($cityList as $key=>$val){
            if($val['city_id'] == $id){
                $city = $cityList[$key];
                break;
            }
        }
        // 如果根据id查询没有查到相应的城市默认为北京
        if (empty($city)){
            foreach ($cityList as $key=>$val){
                if($val['city_id'] == 2){
                    $city = $cityList[$key];
                    break;
                }
            }
        }
        
        if ($field) {
            return $city[$field];
        } else {
            return $city;
        }
        
    }
    
    public static function getCityList(){
        $key = "map_city_list";
        //缓存里面取城市列表如果没有取到则从数据库里面取得并存入缓存
        if(!($cityList = BaseCache::get($key))){
            $cityList = City::getList();
            BaseCache::set($key, $cityList,1800);
        }
        return $cityList;
    }

}
