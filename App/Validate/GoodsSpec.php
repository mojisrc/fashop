<?php
namespace  App\Validate;

use ezswoole\Validate;


/**
 * 商品规格验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class GoodsSpec extends Validate
{
	//验证
	protected $rule = [
		'id' => 'require',
		'name' => 'require',
	];
	//提示
	protected $message = [
		'id.require' => 'ID必填',
		'name.require' => '规格名称必填',
	];
	//场景
	protected $scene = [
		'add' => [
			'name',
		],
		'edit' => [
			'id',
		],
	];
}