<?php

namespace app\api\controller\v1;

use app\api\controller\Commen;
use app\common\lib\exception\ApiException;

/**
 * 获取首页接口
 *
 * 1.头图 4-6
 * 2.推荐为列表 默认40条
 * Class index
 *
 * @package \app\api\controller\v1
 */
class Index extends Commen
{
    public function index()
    {
        $news = model('News')->getIndexHeadNormalNews();

        $news = $this->getDealNews($news);

        $Positions = model('News')->getPositionNormalNews();

        $Positions = $this->getDealNews($Positions);

        $result = [
            'heads'      => $news,
            'positions'  => $Positions
        ];

        return show(config('code.success'),'ok',$result,200);
    }

    public function init()
    {
        $version = model('Version')->getLastNormalVersionByAppType($this->headers['apptype']);

        if (empty($version)) {
            return new ApiException('error', 404);
        }


        if ($version->version > $this->headers['version']) {
            $version->is_update = $version->is_force == 1 ? 2 : 1;
        } else {
            $version->is_update = 0; // 0 不更新 . 1需要更新,2强制更新
        }

        // 记录用户的信息 用于统计
        $activities = [
            'version'  => $this->headers['version'],
            'app_type' => $this->headers['apptype'],
            'did'      => $this->headers['did'],
        ];

        try {
            model('AppActive')->add($activities);
        } catch (\Exception $exception){

        }

        return show(config('code.success'),'ok',$version,200);
    }
}














