<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/3
 * Time: 下午12:05
 *
 */

namespace App\Validator\Server;


use ezswoole\Validator;

class GoodsCollect extends Validator
{
	protected $rule
		= [
			'goods_id' => 'require',
		];
	protected $message
		= [

		];
	protected $scene
		= [
			'add'   => [
				'goods_id',
			],
			'del'   => [
				'goods_id',
			],
			'state' => [
				'goods_id',
			],
		];

}