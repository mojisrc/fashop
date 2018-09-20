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
use ezswoole\Db;
use App\Logic\VerifyCode;

class OrderRefund extends Validate
{
	protected $rule
		= [
			'id'             => 'require',
			'refund_amount'  => 'require',
			'handle_state'   => 'require',
			'handle_message' => 'require',
			'handle_time'    => 'require',
		];
	protected $message
		= [
			'id.require'             => "id必须",
			'refund_amount.require'  => "退款金额必须",
			'handle_state.require'   => "处理状态必须",
			'handle_message.require' => "处理信息必须",
			'handle_time.require'    => "处理时间必须",

		];
	protected $scene
		= [
			'info'    => [
				'id',
			],
			'handle'  => [
				'id',
				'handle_state',
				'handle_message',
			],
			'receive' => [
				'id',
			],

		];

}