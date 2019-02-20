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

namespace App\Validator\Admin;

use ezswoole\Validator;

class DistributionRecruitTemplate extends Validator
{
    protected $rule
        = [
            'id'      => 'require',
            'title'   => 'require',
            'content' => 'require',
        ];

    protected $message
        = [
            'id.require'      => "id必须",
            'title.require'   => "名称必须",
            'content.require' => "内容必须",
        ];

    protected $scene
        = [
            'info' => [
                'id',
            ],
        ];
}