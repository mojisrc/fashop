<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/22
 * Time: 下午1:55
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;

class Area extends Validate
{
	protected $rule
		= [
			'name'           => 'require',
		];
	protected $message
		= [
		];
	protected $scene
		= [
			'info' => [
				'name',
			]
		];


}