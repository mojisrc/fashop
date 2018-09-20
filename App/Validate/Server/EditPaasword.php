<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/22
 * Time: 下午1:55
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;

class EditPaasword extends Validate
{
	protected $rule
		= [
			'user_id'     => 'require',
			'oldpassword' => 'require',
			'password'    => 'require|min:6|max:32|different:oldpassword',
		];
	protected $message
		= [
			'phone.require'      => "手机号必填",
			'email.require'      => "邮箱必填",
			'password.require'   => "密码必填",
			'password.min'       => "密码最小长度6位",
			'password.max'       => "密码最大长度32位",
			'password.different' => "新密码不能和老密码一样",
		];
	protected $code
		= [
			'phone.require'      => "手机号必填",
			'email.require'      => "邮箱必填",
			'password.require'   => "密码必填",
			'password.min'       => "密码最小长度6位",
			'password.max'       => "密码最大长度32位",
			'password.different' => "新密码不能和老密码一样",
		];
	protected $scene
		= [
			'edit' => [
				'oldpassword',
				'password',
			],
		];


}