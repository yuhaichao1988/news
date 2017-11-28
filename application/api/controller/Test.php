<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/18
 * Time: 23:46
 */
namespace app\api\controller;
use think\Controller;
use app\common\lib\exception\ApiExecption;
class Test extends Common {

    public function index(){
        $data=[
            'id1' => 1,
            'id2' => 2,
        ];
        return $data;
    }

    public function update($id = 0){
//        echo $id;exit;

        $data = input('put.');
        return $data;
    }

    public function  save(){
        $data=input('post.');
//        if ($data['age'] != 1){
//            throw new ApiExecption('您提交的参数不合法', 400);
//        }
        return show(1,'ok', input('post.'),201);
    }




}