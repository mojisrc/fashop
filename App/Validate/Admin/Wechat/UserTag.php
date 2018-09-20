<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/2
 * Time: 下午12:13
 *
 */

namespace App\Validate\Admin\Wechat;

use ezswoole\Validate;

class UserTag extends Validate
{
	protected $rule
		= [
			'name'    => 'require',
			'id'      => 'require',
			'openid'  => 'require',
			'openids' => 'require|array',
		];
	protected $message
		= [
			'name.require'   => "标签名必填",
			'id.require'     => "标签id必填",
			'openid.require' => "openid必填",
			'openis.require' => "openids必须是数组",
		];
	protected $scene
		= [
			'create'            => [
				'name',
			],
			'edit'              => [
				'id',
				'name',
			],
			'delete'            => [
				'id',
			],
			'userTagsByOpenid'  => [
				'openid',
			],
			'userTagUsersOfTag' => [
				'id',
			],
			'userTagTagUsers'   => [
				'openids',
				'id',
			],

		];

}