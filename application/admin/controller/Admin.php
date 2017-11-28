<?php
namespace app\admin\controller;
use think\Controller;
use think\Validate;
use app\common\lib\IAuth;
class Admin extends Base
{

    public function index(){
        return $this->fetch('Admin/add');
    }

    public function add(){
        //判断是否是POST提交
        if(request()->ispost()) {
            //打印提交数据
            //halt($_POST);
            $data = $_POST;
            //实例化自动验证
            $validate =  Validate('AdminUser');
            if(!$validate->check($data)){
                //不成功打印错误
                $this->error($validate->getError());
            }
            $data['password'] = IAuth::SetPassword($data['password']);
            $data['status'] = 1;
            //捕获数据库异常
            try{
              $id = model('AdminUser')->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            //数据插入判断
            if($id){
                $this->success("id={$id}的用户插入成功");
            }else{
                $this->error("用户插入失败");
            }
        }else{
            return $this->fetch();
        }


    }
}
