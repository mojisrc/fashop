<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/4
 * Time: 下午1:31
 *
 */

namespace App\Validate\Admin;


use ezswoole\Validate;
class Wechat extends Validate
{
	protected $rule
		= [
			'name'        => 'require',
			'description' => 'require',
			'account'     => 'require',
			'original'    => 'require',
			'level'       => 'require',
			'headimg'     => 'require',
			'qrcode'      => 'require',
		];

	protected $message
		= [];

	protected $scene
		= [
			'confSet' => ['name', 'description', 'account', 'original', 'level', 'headimg', 'qrcode'],
		];

}