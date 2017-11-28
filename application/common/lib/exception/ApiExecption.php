<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/19
 * Time: 20:26
 */
namespace app\common\lib\exception;

use think\Exception;
use Throwable;

class ApiExecption extends Exception{

    public $message = '';
    public $httpCode = 500;
    public $code = 0;
    /**
     * ApiExecption constructor.
     * @param string $message 提示信息
     * @param int $httpCode http状态码
     * @param int $code 业务状态码
     */
    public function __construct($message = "", $httpCode = 0,  $code = 0){
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;

    }


}