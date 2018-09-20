<?php
namespace  App\Validate;

use ezswoole\Validate;


/**
 * 物流管理验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class Express extends Validate
{
	//验证
	protected $rule = [
		'id'              => 'require',
		'company_name'    => 'require',
		'kuaidi100_code'  => 'require',
		'taobao_code'     => 'require',
		'is_commonly_use' => 'require|between:0,1',
	];
	//提示
	protected $message = [
		'id.require'             => 'ID必填',
		'company_name.require'   => '公司名称必填',
		'kuaidi100_code.require' => '快递100Code必填',
		'taobao_code.require'    => '淘宝100Code必填',
		'is_commonly_use'        => '是否为常用物流必须是0-1',
	];
	//场景
	protected $scene = [
		'add' => [
			'company_name',
			'kuaidi100_code',
			'taobao_code',
		],
		'edit' => [
			'id',
			'company_name',
			'kuaidi100_code',
			'taobao_code',
		],
		'set' => [
			'id',
			'is_commonly_use',
		],
	];
}