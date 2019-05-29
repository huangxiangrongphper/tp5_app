<?php
namespace app\admin\controller;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function welcome()
    {
        halt(session(config('admin.session_user'),'',config('admin.session_user_scope')));
    }
}
