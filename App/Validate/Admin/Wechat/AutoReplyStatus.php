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

namespace App\Validate\Admin\Wechat;

use ezswoole\Validate;


class AutoReplyStatus extends Validate
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