<?php

namespace app\common\lib;

//引入七牛鉴权类
use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;

/**
 * 七牛图片基础类库
 * Class Upload
 *
 * @package app\common\lib
 */
class Upload
{
    public static function image()
    {
        if(empty($_FILES['file']['tmp_name']))
        {
            exception('您提交的图片不合法',404);
        }

        // 要上传的临时文件名
        $file = $_FILES['file']['tmp_name'];


        //取出文件的后缀
//        $ext = explode('.',$_FILES['file']['name']);
//        $ext = $ext[1];

        $pathinfo = pathinfo($_FILES['file']['name']);
        $ext = $pathinfo['extension'];

        //取出七牛相关的文件配置信息
        $config = config('qiniu');

        //构建一个鉴权对象
        $auth = new Auth($config['ak'],$config['sk']);



        //生成上传的token
        $token = $auth->uploadToken($config['bucket']);

        //上传到七牛后,保存的文件名
        $key = date('Y')."/".date('m')."/".substr(md5($file),0,5).date('YmdHis').rand(0,9999).'.'.$ext;

        //初始化UploadManager类,执行上传操作
        $UploadManager = new UploadManager();
        list($res,$err)  = $UploadManager->putFile($token,$key,$file);

        if($err !== null){
            return null;
        } else {
            return $key;
        }

    }



}
