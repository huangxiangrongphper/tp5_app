<?php

namespace app\api\controller;

use think\Controller;

/**
 * Class Time
 *
 * @package \app\api\controller
 */
class Time extends Controller
{
    /**
     * 返回服务器端时间,拱客户端使用,保持两端时间的唯一性
     * @return array
     */
    public function index()
    {
        return show(1,'ok',time());
    }
}
