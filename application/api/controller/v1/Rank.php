<?php

namespace app\api\controller\v1;

use app\api\controller\Commen;
use app\common\lib\exception\ApiException;

/**
 * Class Rank
 *
 * @package \app\api\controller\v1
 */
class Rank extends Commen
{
    /**
     * 获取推荐文章排行列表
     */
    public function index()
    {
        try {
            $rands = model('News')->getRankNormalNews();
            $rands = $this->getDealNews($rands);
        }catch (\Exception $e){
            return new ApiException('error',400);
        }

        return show(config('code.success'),'ok',$rands,200);
    }
}
