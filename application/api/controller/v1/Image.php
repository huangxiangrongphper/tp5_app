<?php

namespace app\api\controller\v1;

use app\common\lib\Upload;

/**
 * Class image
 *
 * @package \app\api\controller\v1
 */
class Image extends AuthBase
{
    public function save()
    {
       $image = Upload::image();
       if($image)
       {
           return show(config('code.success'),'ok',config('qiniu.image_url')."/".$image);
       }
    }
}
