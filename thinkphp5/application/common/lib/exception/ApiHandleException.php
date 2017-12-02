<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/19
 * Time: 19:51
 */
namespace app\common\lib\exception;

use think\exception\Handle;

class ApiHandleException extends Handle{
    /**
     * HTTP状态码
     * @var int
     */
    public $httpCode = 500;
    /**
     * 重写
     * Render an exception into an HTTP response.
     *
     * @param  \Exception $e
     * @return Response
     */
    public function render(\Exception $e){
        if (config('app_debug') == true){
            return parent::render($e);
        }
        if ($e instanceof ApiExecption) {
            $this->httpCode = $e->httpCode;
        }
        return  show(0, $e->getMessage(), [], $this->httpCode);
    }
}