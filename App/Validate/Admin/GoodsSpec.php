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

namespace App\Validate\Admin;

use ezswoole\Validate;
use ezswoole\Db;
use App\Logic\VerifyCode;

class GoodsSpec extends Validate
{
	protected $rule
		= [
			'id'      => 'require',
			'name'      => 'require',
		];
	protected $message
		= [
			'id.require'     => "id必须",
			'name.require' => "规格名称必须",

		];
	protected $scene
		= [
			'add' => [
				'name',
			],

			'edit' => [
				'id',
				'name',
			],
			'del' => [
				'id',
			],

		];


}