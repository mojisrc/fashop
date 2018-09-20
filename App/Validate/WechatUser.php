<?php
namespace App\Validate;

use ezswoole\Validate;

/**
 * 微信验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 * @author 邓凯
 */
class WechatMaterial extends Validate {
    //验证
    protected $rule = [
        'openid' => 'require',
        'openids' => 'require|array',
        'remark'=>'require',

    ];
    //提示
    protected $message = [
        'openid.require' => 'openid参数丢失',
        'openids.array' => '图文消息必须是数组',
        'remark.require'=>'请填写备注信息',
    ];
    //场景
    protected $scene = [
        'getUser'=>[
            'openid',
        ],
        'userSelect'=>[
            'openids',
        ],
        'userRemark'=>[
            'openid',
            'remark',
        ],
    ];




}