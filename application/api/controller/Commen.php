<?php

namespace app\api\controller;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use think\Cache;
use think\Controller;

/**
 * API模块公共控制器
 * Class Commen
 *
* @package
*/
class Commen extends Controller
{
    /**
     * 客户端header数据
     * @var string
     */
    public $headers = "";

    public $page = 1;
    public $size = 10;
    public $from = 0;


    /**
     * 初始化的方法
     */
    public function _initialize()
    {
        $this->checkRequestAuth();
    }

    /**
     * 检查每次app请求的数据是否合法
     */
    public function checkRequestAuth()
    {
        //首先需要获取headers数据
        $headers = request()->header();


        // sign 加密需要客户端工程师完成,解密:服务端工程师完成

        // 我们这里是对 headers中的数据进行的加密, body中的数据也可以仿照做参数的加解密

        //检验客户端sign是否合法
        if(empty($headers['sign']))
        {
            throw new ApiException('sign不存在',400);
        }

        //检验客户端app_type是否合法
        if(!in_array($headers['apptype'],config(['app.apptypes'])))
        {
            throw new ApiException('app_type不合法',400);
        }

        // 检验sign是否合法
        if(!IAuth::checkSignPass($headers))
        {
            throw new ApiException('授权码sign失败',401);
        }

        // 将sign 存入缓存中
        Cache::set($headers['sign'],1,config('app.app_sign_cache_time'));

        $this->headers = $headers;

    }

    /**
     * 获取处理的新闻内容数据
     * @param array $news
     * @return array
     */
    protected function getDealNews($news = [] )
    {
        if(empty($news))
        {
            return [];
        }

        $cats = config('cat.lists');

        foreach ($news as $key => $new)
        {
            $news[$key]['catname'] = $cats[$new['catid']] ? $cats[$new['catid']] : '-';

        }

        return $news;
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

}
