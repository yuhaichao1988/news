<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/29
 * Time: 11:23
 */
namespace app\common\lib;

use think\Cache;

class IAuth {
    /**
     * 密码加密
     * @param string $data
     * @return string
     */
    public static function SetPassword($data){
        return md5($data.config('admin.adminpassword_per_halt'));
    }

    /**
     * 生成每次请求的sign加密
     * @param array $data
     * @return string
     */
    public static function setSign($data = []){
        // 1 按照字典排序
        ksort($data);
        // 2 进行数组转换,拼接字符串
        $string = http_build_query($data);
        // 3 通过AES加密
        $string = (new Aes())->encrypt($string);

        return $string;
    }

    /**
     * 检查sign是否正常
     * @param array $data
     * @return bool
     */
    public static function checkSignPass($data) {
        //解密sign
        $str = (new Aes())->decrypt($data['sign']);
        if (empty($str)){
            return false;
        }

        parse_str($str, $arr);
        if (!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']){
            return false;
        }
        if (!config('app_debug')){
            if ((time() - ceil($arr['time'] / 1000)) > config('app.app_type_time') ){
                return false;
            }
            //唯一性判定
            if (Cache::get($data['sign'])){
                return false;
            }
        }
            return true;

    }
}