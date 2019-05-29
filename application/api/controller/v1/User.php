<?php

namespace app\api\controller\v1;

use app\common\lib\Aes;
use app\common\lib\IAuth;

/**
 * Class User
 *
 * @package \app\api\controller\v1
 */
class User extends AuthBase
{

    public function read()
    {
        //用户数据加密
        $aes = new Aes();
        return show(config('code.success'),'ok',$aes->encrypt($this->user));
    }

    /**
     * 用户数据修改
     */
    public function update()
    {
        $postData = input('param.');

        $data = [];

        if(!empty($postData['image']))
        {
            $data['image'] = $postData['image'];
        }

        if(!empty($postData['username']))
        {
            $data['username'] = $postData['username'];
        }

        if(!empty($postData['sex']))
        {
            $data['sex'] = $postData['sex'];
        }

        if(!empty($postData['signature']))
        {
            $data['signature'] = $postData['signature'];
        }

        if(!empty($postData['password']))
        {
            $data['password'] = IAuth::setPassword($postData['password']);
        }

        if(empty($data))
        {
            return show(config('code.error'),'数据不合法',[],404);
        }

        try {
            $id = model('User')->save($data,['id' => $this->user->id]);

            if($id)
            {
                return show(config('code.success'),'ok',[],202);
            }else {
                return show(config('code.error'),'更新失败',[],401);
            }
        }catch (\Exception $e){
            return show(config('code.error'),$e->getMessage(),[],500);
        }
    }
}
