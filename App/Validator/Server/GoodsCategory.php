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

namespace App\Validator\Server;

use ezswoole\Validator;
use ezswoole\Db;
use App\Biz\VerifyCode;

class GoodsCategory extends Validator
{
	protected $rule
		= [
			'id' => 'require|integer|gt:0',
		];
	protected $message
		= [

		];
	protected $scene
		= [
			'info' => [
				'id',
			],
		];


}