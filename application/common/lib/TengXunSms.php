<?php

namespace app\common\lib;

use app\common\lib\exception\ApiException;
use Qcloud\Sms\SmsSingleSender;
use think\Cache;
use think\Log;

/**
 * 腾讯短信类库封装 单例模式
 * Class TengXunSms
 *
 * @package \app\common\lib
 */
class TengXunSms
{
    const LOG_TPL = "TengXunSms:";

    private static $_instance = null;

    //短信模板里面需要两个参数,一个是验证码,一个是过期时间
    private  $params =  [];

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function setSmsIdentify($phone = 0)
    {
//        if(config('app_debug'))
//        {
//            return true;
//        }
       $this->params[0] = mt_rand(1000,9999);

        //验证码的失效时间

        Cache::set($phone,$this->params[0],config('tengxunsms.identify_time'));

        $this->params[1] = 2;

        try {
            $ssender = new SmsSingleSender(config('tengxunsms.AppID'), config('tengxunsms.AppKey'));
            $result = $ssender->sendWithParam(config('tengxunsms.nationCode'), $phone, config('tengxunsms.templId'),
               $this->params,config('tengxunsms.sign'), config('tengxunsms.extend'), config('tengxun.ext'));  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result);

            $res = $rsp->errmsg;

        }catch (\Exception $e) {
            //记录短信发送失败的日志
            Log::write("短信发送失败:".self::LOG_TPL.$e->getMessage());
            return false;
        }
            return true;
    }

    /**
     * 根据手机号查询验证码是否失效
     * @param int $phone
     */
    public function checkSmsIdentify($phone = 0)
    {
        if(!$phone)
        {
            return false;
        }
        return Cache::get($phone);
    }
}
