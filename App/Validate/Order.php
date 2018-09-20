<?php

namespace App\Validate;

use ezswoole\Validate;


/**
 * 订单验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class Order extends Validate
{
	protected $rule
		= [
			'id'              => 'require|integer',
			'shipper_id'      => 'require|integer',
			'deliver_name'    => 'require',
			'deliver_phone'   => 'require',
			'deliver_address' => 'require',
			'express_id'      => 'require|integer',
			'tracking_no'     => 'require',
		];
	protected $message
		= [
			'id.require'         => '订单id必填',
			'shipper_id.require' => '商家物流地址id必填',
		];
	protected $scene
		= [
			'info'    => [
				'id',
			],
			'setSend' => [
				'id',
				'deliver_name',
				'deliver_phone',
				'deliver_address',
				'express_id',
				'tracking_no',
			],
		];
}