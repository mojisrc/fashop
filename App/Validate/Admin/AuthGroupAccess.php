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
class AuthGroupAccess extends Validate
{
	protected $rules
		= [
			'member_ids' => 'require',
			'id'         => 'require',
		];
	protected $message
		= [
			'member_ids.require' => '成员id必须',
			'member_ids.array'   => '成员id格式不对',
			'id.require'         => '组id必填',
		];

	protected $scene
		= [
			'groupMemberEdit' => [
				'member_ids',
				'id',
			],
		];

}