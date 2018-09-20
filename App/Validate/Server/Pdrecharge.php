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


class Pdrecharge extends Validate
{
	protected $rule
		= [
			'id'        => 'require',
			'amount'    => 'require',
			'bank_name' => 'require',
			'bank_no'   => 'require',
			'bank_user' => 'require',

		];
	protected $message
		= [
			'id.require'        => "id必须",
			'amount.require'    => "额度必须",
			'bank_name.require' => "银行名称必须",
			'bank_no.require'   => "账号必须",
			'bank_user.require' => "开户名必须",

		];
	protected $scene
		= [
			'pdCashAdd' => [
				'amount',
				'bank_name',
				'bank_no',
				'bank_user',
			]
		];
}