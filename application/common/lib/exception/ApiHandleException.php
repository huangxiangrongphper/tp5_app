<?php

namespace app\common\lib\exception;

use think\exception\Handle;

/**
 * api 异常处理类
 * Class ApiHandleException
 *
 * @package app\common\lib\exception
 */
class ApiHandleException extends Handle
{
    /**
     * 默认异常状态码
     * @var int
     */
    public $httpCode = 500;

    public function render(\Exception $e)
    {
        /**
         * 如果是调试模式,就不返回json格式的数据给客户端
         */
        if(config('app_debug') == true)
        {
            return parent::render($e);
        }

        if ($e instanceof ApiException)
        {
            $this->httpCode = $e->httpCode;
        }
        return show(0,$e->getMessage(),[],$this->httpCode);
    }
}
