<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/18
 * Time: 23:46
 */
namespace app\api\controller\v1;
use think\Controller;
use app\api\controller\Common;
use app\common\lib\exception\ApiExecption;
class Cat extends Common {
    /**
     * 栏目接口
     */
    public function read(){
        $cats = config('cat.lists');
        $restul[] = [
            'catid' => 0,
            'catname' => '首页',
        ];
        foreach ($cats as $catid => $catname) {
            $restul[] = [
                'catid' => $catid,
                'catname' => $catname,
            ];
        }
        return show(config('app.success'), 'ok', $restul, 200);

    }






}