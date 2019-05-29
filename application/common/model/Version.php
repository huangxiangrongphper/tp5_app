<?php

namespace app\common\model;

/**
 * Class Version
 *
 * @package \app\common\model
 */
class Version extends Base
{
    /**
     * 通过apptype获取最后一条版本内容
     * @param string $appType
     */
    public function getLastNormalVersionByAppType($appType = '')
    {
        $data = [
            'status'      => 1,
            'app_type'    => $appType
         ];

        $order = [
            'id' => 'desc',
        ];

        return $this->where($data)
            ->order($order)
            ->limit(1)
            ->find();

    }
}
