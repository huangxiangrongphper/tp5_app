<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::resource('blog','index/blog');

#API测试路由
Route::get('api/demo','api/demo/index');

#获取栏目列表信息
Route::get('api/:ver/cat','api/:ver.cat/read');

#获取新闻首页信息
Route::get('api/:ver/index','api/:ver.index/index');

#设备的版本号信息
Route::get('api/:ver/init','api/:ver.index/init');

#获取具体的栏目的新闻
Route::resource('api/:ver/news','api/:ver.news');

#推荐相关文章排行接口
Route::get('api/:ver/rank','api/:ver.rank/index');

#短信验证码相关
Route::resource('api/:ver/identify','api/:ver.identify');

#用户登录路由
Route::post('api/:ver/login','api/:ver.login/save');

#用户信息相关路由
Route::resource('api/:ver/user','api/:ver.user');

#图片上传
Route::post('api/:ver/image','api/:ver.image/save');

#点赞
Route::post('api/:ver/upvote','api/:ver.upvote/save');

#取消点赞
Route::delete('api/:ver/upvote','api/:ver.upvote/delete');














