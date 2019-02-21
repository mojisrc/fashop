<?php

namespace App\Validator\Admin;

use ezswoole\Validator;

/**
 * 权限验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class AuthGroup extends Validator
{

	protected $rule
		= [
			'id'     => 'require',
			'name'   => 'require',
			'status' => 'require',
		];

	protected $scene
		= [
			'add'  => [
				'name',
				'status',
			],
			'edit' => [
				'id',
				'name',
				'status',
			],
			'del'  => [
				'id',
			],
		];

}