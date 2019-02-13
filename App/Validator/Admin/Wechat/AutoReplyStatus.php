<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/5
 * Time: 下午1:54
 *
 */

namespace App\Validator\Admin\Wechat;

use ezswoole\Validator;


class AutoReplyStatus extends Validator
{
	protected $rule
		= [
			'status' => 'require|integer',
		];
	protected $message
		= [];

	protected $scene
		= [
			'set' => [
				'status',
			],
		];


}