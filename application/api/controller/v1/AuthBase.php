<?php

namespace app\api\controller\v1;

use app\api\controller\Commen;
use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\model\User;

/**
 * 客户端auth登录权限基础类库
 * 1. 每个接口(需要登录 个人中心 点赞 评论) 都需要去继承
 * 2. 判定  access_user_token 是否合法
 * 3. 用户信息 -> user
 * Class AuthBase
 *
 * @package \app\api\controller\v1
 */
class AuthBase extends Commen
{

    /**
     * 登录用户的基本信息
     * @var array
     */
    public $user = [];
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        parent::_initialize();

        $res = $this->isLogin();

        if(empty($res))
        {
           throw new ApiException('您没有登录',401);
        }
    }


    public function isLogin()
    {
        if(empty($this->headers['token']))
        {
            return false;
        }

        $accessUserToken = (new Aes())->decrypt($this->headers['token']);
        if(empty($accessUserToken))
        {
            return false;
        }

        if(!preg_match("/||/",$accessUserToken))
        {
            return false;
        }

        list($token,$id) = explode("||",$accessUserToken);

        $user = User::get(['token' => $token]);

        if(!$user || $user->status != 1)
        {
            return false;
        }

        if(time() > $user->time_out)
        {
            return false;
        }

        $this->user = $user;

        return true;
    }
}













