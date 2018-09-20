<?php
namespace App\Validate;
use ezswoole\Validate;

/**
 * 消息验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class Message extends Validate {

	protected $rule = [
		'title'    => 'require',
		'body'     => 'require',
		'is_group' => 'require',
	];

	protected $message = [
		'title.require'    => "标题必填",
		'body.require'     => "内容必填",
		'is_group.require' => "分组必选",
	];
	protected $scene = [
		'add' => [
			'title',
			'body',
			'is_group',
		],
	];
}