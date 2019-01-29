<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Admin;

use ezswoole\Validate;

class DistributionRecruit extends Validate
{
    protected $rule
        = [
            'title'   => 'require',
            'url'     => 'require',
            'content' => 'require',
        ];

    protected $message
        = [
            'title.require'   => "名称必须",
            'url.require'     => "链接地址必须",
            'content.require' => "内容必须",
        ];

    protected $scene
        = [
            'edit' => [
                'title',
                'url',
                'content',
            ],
        ];
}