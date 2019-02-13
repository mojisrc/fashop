<?php

namespace App\Validator\Server;

use ezswoole\Validator;


/**
 * 拼团商品管理验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class Group extends Validator
{
    //验证
    protected $rule
        = [
            'group_id' => 'require',
            'goods_id' => 'require',
            'order_id' => 'require',

        ];
    //提示
    protected $message
        = [
            'group_id.require' => '拼团活动id必须',
            'goods_id.require' => '商品id必填',
            'order_id.require' => '订单id必填',

        ];
    //场景
    protected $scene
        = [
            'info' => [
                'goods_id',
            ],
            'skuInfo' => [
                'group_id',
                'goods_id',
            ],
            'groupingSearch' => [
                'goods_id',
            ],
            'groupingInfo' => [
                'order_id',
                'goods_id',
            ],
            'allowOpenGroup' => [
                'goods_id',
            ],
            'allowJoinGroup' => [
                'goods_id',
            ],
            'shareGroupingInfo' => [
                'order_id',
                'goods_id',
            ],
        ];
}