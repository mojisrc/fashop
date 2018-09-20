<?php

namespace App\Validate\Admin;

use ezswoole\Validate;

/**
 * 权限节点验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class AuthRule extends Validate
{

	protected $rule
		= [
			'id'      => 'require',
			'sign'    => 'require',
			'title'   => 'require',
			'pid'     => 'require',
			'route'   => 'require',
			'display' => 'require',

		];
	protected $message
		= [
			'name.require' => "名称必填",
		];
	protected $scene
		= [
			'add'  => [
				'sign',
				'title',
				'display',
			],
			'edit' => [
				'id',
				'sign',
				'title',
				'display',
			],
			'info' => ['id'],
			'del'  => [
				'id',
			],
			'sort' => [
				'sorts',
			],
		];
}