<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/21
 * Time: 19:21
 */
namespace app\common\validate;

use think\Validate;

class AdminUser extends Validate
{
    //验证规则
    protected $rule =   [
        'username'  => 'require|max:25',
        'password'  => 'require|max:25',
//        'age'   => 'number|between:1,120',
//        'email' => 'email',
    ];
    //提示信息
    protected $message  =   [
        'username.require' => '用户名必须',
        'username.max'     => '用户名最多不能超过25个字符',
        'password.require' => '密码必须',
        'password.max'     => '密码最多不能超过25个字符',

        //        'age.number'   => '年龄必须是数字',
//        'age.between'  => '年龄只能在1-120之间',
//        'email'        => '邮箱格式错误',
    ];
    //正则表达式验证
    protected $regex = [
    ];

}