<?php

// 驗證限制值設定

return [
    'users' => [
        'account'  => 'alpha_num|between:4,12',
        'password' => 'alpha_num|between:8,12',
        'name'     => 'max:10'
    ]
];
