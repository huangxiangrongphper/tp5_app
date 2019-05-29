<?php

namespace app\api\controller\v1;

use app\api\controller\Commen;

/**
 * Class Cat
 *
 * @package \app\api\controller
 */
class Cat extends Commen
{

    public function read()
    {
        $cats = config('cat.lists');

        $result[] = [
            'catid'   => 0,
            'catname' => '首页',
        ];
        foreach ($cats as $catid => $catname)
        {
            $result[] = [
                'catid'   => $catid,
                'catname' => $catname,
            ];
        }

        return show(config('code.success'),'ok',$result,200);
    }
}
