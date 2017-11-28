<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/21
 * Time: 19:36
 */
namespace app\common\Model;
use think\Model;

class Base extends Model {
    protected  $autoWriteTimestamp = true;
    /**
     * 保存数据
     * @param $data
     * @return mixed
     */
    public function add($data){
        if(!is_array($data)){
            exception('传入数据类型错误!');
        }
        $this->allowField(true)->save($data);

        return $this->id;
    }
}