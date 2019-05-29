<?php

namespace app\api\controller\v1;

use app\api\controller\Commen;
use app\common\lib\exception\ApiException;

/**
 * Class News
 *
 * @package \app\api\controller\v1
 */
class News extends Commen
{
    /**
     * 获取具体的栏目列表新闻
     */
    public function index()
    {
        //todo 数据验证

        $data = input('get.');

        $whereData['status'] = config('code.status_normal');

        if(!empty($data['catid']))
        {
            $whereData['catid'] = input('get.catid',0,'intval');
        }

        if(!empty($data['title']))
        {
            $whereData['title'] = ['like','%'.$data['title'].'%'];
        }

        $this->getPageAndSize($data);

        $newsTotal = model('News')->getNewsCountByCondition($whereData);

        $news = model('News')->getNewsByCondition($whereData,$this->from,$this->size);

        $result = [
            'total'     => $newsTotal,
            'page_num'  => ceil($newsTotal / $this->size),
            'list'      => $this->getDealNews($news)
        ];

        return show(config('code.success'),'ok',$result,200);

    }

    /**
     * 获取文章详情页信息
     */
    public function read()
    {
        $id = input('param.id',0,'intval');
        if(empty($id))
        {
            return new ApiException('id is not',404);
        }

        $news = model('News')->get($id);

        if(empty($news) || $news->status != config('code.status_normal'))
        {
            return new ApiException('不存在该新闻',404);
        }

        //增加文章的阅读数

        try {
            model('News')->where(['id' => $id ])->setInc('read_count');
        }catch (\Exception $e){
            return new ApiException('error',400);
        }

        $cats = config('cat.lists');
        $news->catname = $cats[$news->catid];

        return show(config('code.success'),'ok',$news,200);
     }
}
