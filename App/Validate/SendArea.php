<?php
namespace  App\Validate;

use ezswoole\Validate;

/**
 * 可配送区域验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class SendArea extends Validate
{
	//验证
	protected $rule = [
		'id'        => 'require',
		'title'     => 'require',
		'area_ids'  => 'require|array',
	];
	//提示
	protected $message = [
		'id.require'        => '模板ID必填',
		'title.require'     => '模板名称必填',
		'area_ids.require'  => '市id集合必填',
		'area_ids.array'    => '市id集合必须是数组',
	];
	//场景
	protected $scene = [
		'add' => [
			'title',
			'area_ids',
		],
		'edit' => [
			'id',
			'title',
			'area_ids',
		],
		'del' =>[
			'id',
		]
	];

}