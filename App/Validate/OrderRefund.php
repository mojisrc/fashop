<?php
namespace  App\Validate;

use ezswoole\Validate;


/**
 * 模板验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class OrderRefund extends Validate
{
	//验证
	protected $rule = [
		'id'             => 'require',
		'amount'         => 'require',
		'handle_state'   => 'require|in:0,10,20,30',
		'handle_message' => 'require',
	];
	//提示
	protected $message = [
		'id.require' => 'ID必填',
		'amount.require' => '金额必填',
		'handle_message.require' => '处理信息必填',
		'handle_state.require' => '处理状态必填',
		'handle_state.between' => '是否系统模板必须是0,10,20,30',
	];
	//场景
	protected $scene = [
		'info' => [
			'id',
		],
		'handle' => [
			'id',
			'amount',
			'handle_state',
			'handle_message',
		],
	];
}