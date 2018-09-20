<?php
namespace App\Validate;
use ezswoole\Validate;

class Driver extends Validate {
	protected $rule = [
		'name'  => 'require',
		'phone' => 'require',
	];

	protected $message = [
		'name.require'  => '姓名必须填写',
		'phone.require' => '电话必须填写',
	];

	protected $scene = [
		'add'  => ['name', 'phone'],
		'edit' => ['name', 'phone'],
	];
}
?>