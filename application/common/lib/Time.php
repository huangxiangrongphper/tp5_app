<?php

namespace app\common\lib;

/**
 * 获取13位时间戳 秒数只有十位,然后加上三位的毫秒数
 * Class Time
 *
 * @package \app\common\lib
 */
class Time
{
    public static function get13TimeStamp()
    {
        list($t1,$t2) = explode(' ',microtime());

        return $t2 . ceil($t1 * 1000);
    }
}
