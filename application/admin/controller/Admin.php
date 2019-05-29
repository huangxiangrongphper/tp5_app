<?php
namespace app\admin\controller;

use think\Controller;

class Admin extends Controller
{
    public function add()
    {
        //是否是post提交
        if(request()->isPost()){
            $userDate = input('post.');

            //数据验证
            $validate = validate('AdminUser');

            if(!$validate->check($userDate)){
                $this->error($validate->getError());
            }

            $userDate['password'] = md5($userDate['password'] .'_#Flourishing');
            $userDate['status']   = 1;

            try{
                $userId  =  model('AdminUser')->add($userDate);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if($userId)
            {
                $this->success('id='.$userId.'的用户新增成功');
            }else{
                $this->error('error');
            }

        }else{
            return $this->fetch();
        }

    }
}
