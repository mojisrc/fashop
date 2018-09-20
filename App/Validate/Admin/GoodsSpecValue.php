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

class GoodsSpecValue extends Validate
{
	protected $rule
		= [
			'id'      => 'require',
			'name'      => 'require',
			'spec_id'      => 'require',
		];
	protected $message
		= [
			'id.require'     => "id必须",
			'name.require' => "规格值名称必须",
			'spec_id.require' => "规格id必须",

		];
	protected $scene
		= [
			'add' => [
				'name',
				'spec_id',
			],
			'del' => [
				'id',
			],

		];


}