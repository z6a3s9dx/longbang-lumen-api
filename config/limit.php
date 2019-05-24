<?php

// 驗證限制值設定

return [
    'users' => [
        'account'  => 'alpha_num|between:4,12',
        'password' => 'alpha_num|between:8,12',
        'name'     => 'max:10'
    ],

    'user_login' => [
        'time' =>'date_format:Y-m-d H:i:s',
        //'time_end' =>'date_format:Y-MM-DD HH:ii:ss',
    ]
];
