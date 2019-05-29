<?php
namespace app\admin\controller;

class News extends Base
{
    public function index()
    {
        //param 能获取到 get 或者post的数据
        $data = input('param.');

        //格式化查询条件
        $query = http_build_query($data);

        /**
         * 检索数据
         */

        $whereData = [];


        if(!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] > $data['start_time'])
        {
            $whereData['create_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],
            ];
        }

        if(!empty($data['catid']))
        {
            $whereData['catid'] = intval($data['catid']);
        }

        if(!empty($data['title']))
        {
            $whereData['title'] = ['like','%'.$data['title'].'%'];
        }


        // 分页模式一
        //$news  = model('News')->getNews();

        //分页模式二
        $this->getPageAndSize($data);

        // 获取列表里面的数据
        $news = model('News')->getNewsByCondition($whereData,$this->from,$this->size);

        //获取满足条件的数据页数
        $total  = model('News')->getNewsCountByCondition($whereData);

        //计算总页数
        $pageTotal = ceil($total/ $this->size);

        $this->assign('news',$news);
        $this->assign('pageTotal',$pageTotal);
        $this->assign('curr',$this->page );
        $this->assign('cats',config('cat.lists'));

        //保持搜索条件
        $start_time = empty($data['start_time']) ? '' : $data['start_time'];
        $end_time = empty($data['end_time']) ? '' : $data['end_time'];
        $catid = empty($data['catid']) ? '' : $data['catid'];
        $title = empty($data['title']) ? '' : $data['title'];
        $this->assign('start_time',$start_time);
        $this->assign('end_time',$end_time);
        $this->assign('catid',$catid);
        $this->assign('title',$title);
        $this->assign('query',$query);


        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            
            //入库操作
            try{
                $id = model('News')->add($data);
            }catch (\Exception $e){
                return $this->result('',0,'新增失败');
            }

            if($id) {
                return $this->result(['jump_url' => url('news/index')],1,'ok');
            } else{
                return $this->result('',0,'新增失败');
            }

        }else{
            return $this->fetch('',[
                'cats' => config('cat.lists')
            ]);
        }

    }

}
