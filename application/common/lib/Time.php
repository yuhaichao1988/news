<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/29
 * Time: 11:23
 */
namespace app\common\lib;
/**
 * 时间
 * Class Time
 * @package app\common\lib
 */
class Time {
    /**
     * 获取13位的时间戳
     * @return int
     */
    public static function get13TimeStamp(){
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);

    }

}