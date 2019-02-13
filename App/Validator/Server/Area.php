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

namespace App\Validator\Server;

use ezswoole\Validator;

class Area extends Validator
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