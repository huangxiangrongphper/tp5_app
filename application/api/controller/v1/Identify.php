<?php

namespace app\api\controller\v1;

use app\api\controller\Commen;
use app\common\lib\TengXunSms;

/**
 * Class Identify
 *
 * @package \app\api\controller\v1
 */
class Identify extends Commen
{
    /**
     * post
     * 设置短信验证码
     */
    public function save()
    {
        if(!request()->isPost())
        {
            return show(config('code.error'),'您提交的数据不合法',[],403);
        }

        //检验数据
        $validate = validate('Identify');

        if(!$validate->check(input('post.')))
        {
            return show(config('code.error'),$validate->getError(),[],403);
        }

        //发送手机短信
        $id  = input('param.id');

        if(TengXunSms::getInstance()->setSmsIdentify($id))
        {
            return show(config('code.success'),'ok',[],201);
        }else {
            return show(config('code.error'),'error',[],403);
        }
    }
}
