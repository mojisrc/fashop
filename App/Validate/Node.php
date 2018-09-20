<?php
namespace App\Validate;
use ezswoole\Validate;

class Node extends Validate {
	//编辑的时候unique规则会自动排除主键的，再复杂的情况就自己在验证器里面添加一个方法进行验证
	//定义验证规则
	protected $rule = [
		'title' => 'require',
	];
	//定义验证提示
	protected $message = [
		'title.require'       => '菜单名称必须',
		'email.email'         => '邮箱格式不正确',
		'email.unique'        => '该邮箱已存在',
		'password.require'    => '密码不能为空',
		'password.min'        => '密码长度不能小于6位',
		're-password.require' => '重复密码不能为空',
		're-password.confirm' => '两次密码不一致',
	];
}