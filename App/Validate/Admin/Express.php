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

class Express extends Validate
{
	protected $rule
		= [
			'id'              => 'require',
			'company_name'    => 'require',
			'is_commonly_use' => 'require',
		];
	protected $message
		= [
			'id.require'              => "id必须",
			'company_name.require'    => "公司名称",
			'is_commonly_use.require' => "是否为常用",
		];
	protected $scene
		= [
			'add' => [
				'company_name',
				'is_commonly_use',
			],

			'edit' => [
				'id',
				'company_name',
				'is_commonly_use',
			],
			'del'  => [
				'id',
			],

			'set' => [
				'id',
			],

		];

}