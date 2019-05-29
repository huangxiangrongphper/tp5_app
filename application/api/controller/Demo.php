<?php

namespace app\api\controller;

use app\common\lib\Jpush;
use app\common\lib\TengXunSms;

/**
 * API测试类
 * Class Demo
 *
 * @package \app\api\controller
 */
class Demo
{
    public function index()
    {

        Jpush::push('hello huangxiangrong',11);

    }

    /**
     * 测试发送短信
     */
    public function sendSms()
    {

    }

    public function pushtest()
    {

    }

}
