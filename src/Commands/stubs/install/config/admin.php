<?php
return [
    /*
    |--------------------------------------------------------------------------
    | 默认
    |--------------------------------------------------------------------------
     */
    'defaults'   => [
        'language'    => 'zh_CN',
        'placeholder' => 'placeholder.png',
    ],
    /*
    |--------------------------------------------------------------------------
    | 忽视授权的
    |--------------------------------------------------------------------------
     */
    'permission' => [
        'ignores'       => [
            'image',
            'home',
            'language',
            'login',
        ],
        'administrators' => [
            'admin',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | 语言列表
    |--------------------------------------------------------------------------
     */
    'languages'  => [
        'zh_CN' => [
            'title' => '中文简体',
        ],
        // 'en' => [
        //     'title'   => 'english',
        // ],
    ],
];
