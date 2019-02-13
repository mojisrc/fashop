<?php
namespace  App\Validator;

use ezswoole\Validator;


/**
 * 评价验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class OrderEvaluate extends Validator{
	//验证
	protected $rule = [
		'id'          => 'require',
		'content'     => 'require',
		'is_display'  => 'require|between:0,1',
	];
	//提示
	protected $message = [
		'id.require'          => 'ID必填',
		'content.require'     => '评价内容必填',
		'is_display.require'  => '是否显示必填',
		'is_display.between'  => '是否显示必须是0-1',
	];
	//场景
	protected $scene = [
		'reply' => [
			'id',
			'content',
		],
		'display' => [
			'id',
			'is_display',
		],
	];
}