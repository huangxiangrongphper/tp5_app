<?php

return [
    'password_pre_halt' => '_#Flourishing',//密码加密盐
    'aeskey'            => 'LUBUbUP1T8pxTjcwX4VlZQOg86Q2xk3x',//aes秘钥,服务端和客户端必须保持一致
    'apptypes'          => [
        'ios',
        'android',
    ],
    'app_sign_time'     => 10,  // sign失效时间
    'app_sign_cache_time'     => 20,  // sign缓存失效时间
    'login_time_out_day'  => 7, //登录token的失效时间
];
