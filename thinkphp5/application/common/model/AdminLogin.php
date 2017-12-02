<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/21
 * Time: 19:36
 */
namespace app\common\Model;
use think\Model;

class AdminLogin extends Model {
    protected  $autoWriteTimestamp = true;
    /**
     * 新增用户
     * @param $data
     * @return mixed
     */
    public function login($data){
        if(!is_array($data)){
           exception('传入数据类型错误!');
        }
        $this->allowField(true)->save($data);

        return $this->id;
    }
}