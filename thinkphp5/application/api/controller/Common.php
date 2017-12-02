<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/18
 * Time: 23:46
 */
namespace app\api\controller;
use app\common\lib\Aes;
use app\common\lib\IAuth;
use app\common\lib\Time;
use Qiniu\Auth;
use think\Cache;
use think\Controller;
use app\common\lib\exception\ApiExecption;

/**
 * API模块 公共的控制器
 * Class Common
 * @package app\api\controller
 */
class Common extends Controller {
    /**
     * headers信息
     * @var string
     */
    public $headers = '';
    /**
     * 初始化方法
     */
    public function _initialize(){
        $this->checkRequestAuth();
//        $this->testAes();
    }

    /**
     *检查app每次请求的数据是否合法
     */
    public function checkRequestAuth(){
        //首先获取headers头里的数据
        $headers = request()->header();

        // sign 加密需要客户端完成，解密需要服务端完成
        //基础参数校验
        if (empty($headers['sign'])) {
            throw new ApiExecption('sign参数不存在', 400);
        }
        if (!in_array($headers['app_type'],config('app.apptypes'))) {
            throw new ApiExecption('app_type不合法', 400);
        }


        if (!IAuth::checkSignPass($headers)) {
            throw new ApiExecption('授权码sign校验失败', 401);
        }
        Cache::set($headers['sign'], 1, config('app.app_type_cache_time'));
        $this->headers = $headers;
    }

    public function testAes(){
//        $str = 'id=1&code=1125&username=yuhaichao';
//        $aes_str = 'PY7TX1rAnwzeJ4iGvougoUcLowrqeUdtUNJrh39Kq5kXC9E0AssYx/daeInHsKBO';
//        echo (new Aes())->encrypt($str);exit;
//        echo (new Aes())->decrypt($aes_str);exit;
        $data = [
            'did' => '214124512',
            'ves' => 1,
            'time' => Time::get13TimeStamp(),
        ];
        $str = 'xW5p/9XPxjtbDJGKl2+KwXeqvqrfmPueo0h3tKNdKcS+W48kX4AMwZsWwKJsRwbF';
//        echo IAuth::setSign($data);exit;
        echo (new Aes())->decrypt($str);exit;
    }




}