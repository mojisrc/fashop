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
		'content' => 'require',
		'channel' => 'require',
	];

	protected $message = [
		'content.require' => "内容必填",
		'channel.require' => "渠道必填",
	];
	protected $scene = [
		'add' => [
			'content',
			'channel',
		],
	];
}