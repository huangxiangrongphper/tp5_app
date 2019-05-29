<?php
namespace app\admin\controller;

use app\common\lib\Upload;
use think\Request;

/**
 * Class Image
 *后台图片上传相关逻辑
 * @package app\admin\controller
 */
class Image extends Base
{
    /**
     * 图片上传
     */
    public static function upload()
    {
        $file = Request::instance()->file('file');

        $info = $file->move('upload');

        if($info && $info->getPathname())
        {
            $data = [
                'status'  => 1,
                'massage' => 'ok',
                'data'    => '/'.$info->getPathname(),
            ];

            echo json_encode($data);exit();
        }

        echo json_encode(['status'=>0,'massage'=>'上传失败']);
    }

    /**
     * 七牛图片上传
     */
    public function uploadByQiniu()
    {
        try{
            $image = Upload::image();
        }catch (\Exception $e) {
            echo json_encode(['status'=>0,'massage'=>$e->getMessage()]);
        }

        if($image)
        {
            $data = [
                'status'  => 1,
                'massage' => 'ok',
                'data'    => config('qiniu.image_url').'/'.$image
            ];
            echo json_encode($data);exit();
        }else{
            echo json_encode(['status'=>0,'massage'=>'上传失败']);
        }

    }
}
