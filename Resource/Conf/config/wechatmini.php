<?php
return [
    //小程序相关配置 注意：不是公众号 不是 不是！
    'app_id' => '',
    'secret' => '',

    // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
    'response_type' => 'array',

    'log' => [
        'level' => 'debug',
        'file' => EASYSWOOLE_ROOT.'/Runtime/Log/wechat.log',
    ],
];