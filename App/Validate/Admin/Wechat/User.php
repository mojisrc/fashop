<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/2
 * Time: 下午11:45
 *
 */

namespace App\Validate\Admin\Wechat;
use ezswoole\Validate;

class User extends Validate
{
	protected $rule
		= [
			'openid'  => 'require',
			'openids' => 'require|array',
			'remark'=>'require',
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
			'get'            => [
				'name',
			],
			'select'              => [
				'openids',
			],
			'remark'  => [
				'openid',
				'remark'
			],
			'block' => [
				'openids',
			],
			'unblock'   => [
				'openids',
			],

		];
}