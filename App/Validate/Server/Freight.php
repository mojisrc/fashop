<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/3
 * Time: 上午11:50
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;

class Freight extends Validate
{
	protected $rule
		= [
			'id' => 'require|integer|gt:0',
		];
	protected $message
		= [];
	protected $scene
		= [
			'info' => [
				'id',
			],
		];

}