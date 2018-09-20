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

namespace App\Validate\Server;


use ezswoole\Validate;

class GoodsCollect extends Validate
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