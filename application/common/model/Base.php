<?php
namespace app\common\model;

use think\model;

class Base extends model
{
    protected $autoWriteTimestamp = true;

    public function add($data)
    {
        if(!is_array($data))
        {
            exception('用户数据不合法');
        }


        $this->allowField(true)->save($data);

        return $this->id;
    }
}
