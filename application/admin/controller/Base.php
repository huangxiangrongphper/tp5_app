<?php
namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    /**
     * page 当前页
     * @var string
     */
    public $page = '';

    /**
     * 每页显示多少条数
     * @var string
     */
    public $size = '';

    /**
     * 查询条件的起始值
     * @var int
     */
    public $from = 0;

    /**
     * @var string
     */
    public $model = '';

    /**
     * 判断用户是否登录
     */
    public function _initialize()
    {
        if(!$this->isLogin())
        {
            return $this->redirect('login/index');
        }
    }

    public function isLogin()
    {
        $user = session(config('admin.session_user'),'',config('admin.session_user_scope'));

        if($user && $user->id)
        {
            return true;
        }

        return false;
    }

    /**
     * 获取分页page size内容
     */
    public function getPageAndSize($data)
    {
        $this->page  = !empty($data['page']) ? $data['page'] : 1 ;
        $this->size = !empty($data['size']) ? $data['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1 ) * $this->size;
    }

    /**
     * 公用的删除方法
     * @param int $id
     */
    public function delete($id = 0)
    {
        if(!intval($id))
        {
            return $this->request('',0,'ID不合法');
        }

        //实例化具体的model对象 分为模型名和控制器名相同 和不相同两种情况

        $model = $this->model ? $this->model  : request()->controller();

        try{
            $res = model($model)->save(['status'=>-1],['id'=>$id]);
        }catch (\Exception $e){
            return $this->result('',0,$e->getMessage());
        }

        if($res)
        {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']],1,'ok');
        }

        return $this->result('',0,'删除失败');
    }

    /**
     * 通用修改状态的方法
     */
    public function status()
    {
        $data = input('param.');
        $model = $this->model ? $this->model  : request()->controller();

        try{
            $res = model($model)->save(['status'=>$data['status']],['id'=>$data['id']]);
        }catch (\Exception $e){
            return $this->result('',0,$e->getMessage());
        }

        if($res)
        {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']],1,'ok');
        }

        return $this->result('',0,'修改失败');
    }

}
