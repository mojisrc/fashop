<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/15
 * Time: 下午3:22
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;


class Buy extends Validate
{

	protected $rule
		= [
            'cart_ids'        => 'require|array',
            'address_id'      => 'require|integer',
            'pay_sn'          => 'require|regex:/^\d{18}$/',
            'order_type'      => 'require',
            'payment_code'    => 'require',
            'openid'          => 'require',
            'payment_channel' => 'require|checkChannel',

        ];

	protected $message
		= [];
	protected $scene
		= [
			'calculate' => [
				'cart_ids',
				'address_id',
			],
			'create'    => [
				'cart_ids',
				'address_id',
			],
			'info'      => [
				'pay_sn',
			],
			'pay'       => [
				'order_type',
				'pay_sn',
				'payment_code',
                'payment_channel'
			],
		];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule  验证规则
     * @return bool
     */
    protected function checkChannel( $value, $rule, $data )
    {
        return in_array($value, ["wechat", "wechat_mini", "wechat_app"]) ? true : "支付渠道不正确";
    }
}