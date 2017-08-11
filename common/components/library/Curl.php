<?php
/**
 * Curl 请求类
 * @Author: leexb
 * @Date: 17-2-6
 */
namespace app\common\components\library;

class Curl{
    public static function curlPost($url, $data = array()) {
        $query = "";
        if (is_array ( $data )) {
            foreach ( $data as $k => $v ) {
                $query .= "$k=" . urlencode ( $v ) . "&";
            }
        }
        $query = substr ( $query, 0, - 1 );
        $ch = curl_init ();
        $options = array (
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => count ( $data ),
            CURLOPT_POSTFIELDS => $query,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 30
        );

        if (! function_exists ( 'curl_setopt_array' )){
            function curl_setopt_array($ch, $options) {
                foreach ( $options as $option => $value ) {
                    curl_setopt ( $ch, $option, $value );
                }
            }
        } else {
            curl_setopt_array ( $ch, $options );
        }
        $return = curl_exec ( $ch );
        curl_close ( $ch );

        return $return;
    }

}