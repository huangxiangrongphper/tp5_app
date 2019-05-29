<?php
namespace app\admin\controller;

use app\common\model\AdminUser;
use app\common\lib\IAuth;

class Login extends Base
{
    public function _initialize()
    {

    }
    public function index()
    {
        if($this->isLogin())
        {
            //已经登录  跳转到后台首页面
            return $this->redirect('index/index');
        }else{
            return $this->fetch();
        }


    }

    public function check()
    {
        if(request()->isPost())
        {
            $userData = input('post.');
            if(!captcha_check($userData['code']))
            {
                $this->error('验证码错误');
            }

            #验证提交的数据
            $validate = validate('AdminUser');
            if(!$validate->check($userData)){
                $this->error($validate->getError());
            }

            try {
            #检查用户数据是否正确
            $user= AdminUser::get(function($query) use($userData){
                $query->where(
                    ['username'=>$userData['username'],'password'=>IAuth::setPassword($userData['password']),'status'=>config('code.status_normal')]
                );
            });
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if(!$user)
            {
                $this->error('用户名或者密码错误或用户不可用');
            }
            $user->last_login_time = time();
            $user->last_login_ip   = request()->ip();

            $user->save();


            session(config('admin.session_user'),$user,config('admin.session_user_scope'));
            $this->success('登录成功','index/index');

        }else{
            $this->error('请求不合法');
        }

    }

    public function logout()
    {
        session(null,config('admin.session_user_scope'));
        $this->redirect('login/index');
    }

    public function welcome()
    {

    }
}
