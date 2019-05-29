<?php

namespace app\common\lib;

use think\Cache;

class IAuth
{

    # 加密用户登录密码
    public static function setPassword($data)
    {
        return md5($data.config('app.password_pre_halt'));
    }

    /**
     * 生成每次请求的sign的验签算法
     * @param array $data
     * @return string
     */
    public static function setSign($data = [])
    {
        // 1.把请求中的字段进行排序
        ksort($data);

        //2.拼接请求字符串 id=123&name=huangxiangrong
        $string = http_build_query($data);

        //3.通过aes来进行加密客户端请求的数据
       $string =  (new Aes())->encrypt($string);

        //4.返回处理后的字符串
        return $string;
    }

    /**
     * 检查sign是否正常
     *
     * @param    array $data
     * @return  boolen
     */
    public static function checkSignPass($data)
    {
        // did=xx&app_type=3
        $str = (new Aes())->decrypt($data['sign']);

        if(empty($str))
        {
            return false;
        }

        //将did=xx&app_type=3 这样数据转换为数组格式
        parse_str($str,$arr);

        if(!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did'])
        {
            return false;
        }

        if(!config('app_debug')) {

            if(time() - ceil($arr['time'] / 1000) > config('app.app_sign_time'))
            {
                return false;
            }

            //查询sign在缓存中是否失效
            if(Cache::get($data['sign']))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * 设置登录的token --- 唯一性
     * @param string $phone
     * @return string
     */
    public static function setAppLoginToken($phone = '')
    {
        $str = md5(uniqid(md5(microtime(true)),true));
        $str = sha1($str.$phone);
        return $str;
    }
}














