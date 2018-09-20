<?php
namespace App\Validate;
use ezswoole\Validate;

/**
 * 用户发票信息验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class Invoice extends Validate {
	protected $rule = [
		'id'                             => ['number'],
		'type'                           => ['require', 'in' => '1,2'],
		'title_select_type'              => 'require',
		'content'                        => 'require',
		'receive_name'                   => 'require',
		'receive_phone'                  => 'require',
		'receive_province'               => 'require',
		'receive_address'                => 'require',
		'consumption_type'               => 'require',
		'company_name'                   => 'require',
		'company_code'                   => 'require',
		'company_register_address'       => 'require',
		'company_register_phone'         => 'require',
		'company_register_brank_name'    => 'require',
		'company_register_brank_account' => 'require',
	];
	protected $message = [
		'id.id'                                  => 'id必填',
		'type.in'                                => '发票类型错误',
		'title_select_type.require'              => '抬头类型必填',
		'content'                                => '发票内容必填',
		'receive_name.require'                   => '抬头类型必填',
		'receive_phone.require'                  => '收票人手机号必填',
		'receive_province.require'               => '收票人省份必填',
		'receive_address.require'                => '送票地址必填',
		'consumption_type.require'               => '发票分类必填',
		'company_name.require'                   => '公司名必填',
		'company_code.require'                   => '纳税人识别号必填',
		'company_register_address.require'       => '注册地址必填',
		'company_register_phone.require'         => '注册电话必填',
		'company_register_brank_name.require'    => '开户银行必填',
		'company_register_brank_account.require' => '银行帐户必填',
	];
	protected $scene = [
		// 抬头类型  1是个人，2公司
		'title_select_type_1_add'  => [
			'type',
			'title_select_type',
			// 'content',
			// 'receive_name',
			// 'receive_phone',
			// 'receive_province',
			// 'receive_address',
			'consumption_type',
		],
		'title_select_type_1_edit' => [
			'id',
			'type',
			'title_select_type',
			// 'content',
			// 'receive_name',
			// 'receive_phone',
			// 'receive_province',
			// 'receive_address',
			'consumption_type',
		],
		'title_select_type_2_add'  => [
			'type',
			'title_select_type',
			// 'receive_name',
			// 'receive_phone',
			// 'receive_province',
			// 'receive_address',
			'consumption_type',
			'company_name',
			// 'company_code',
			// 'company_register_address',
			// 'company_register_phone',
			// 'company_register_brank_name',
			// 'company_register_brank_account',
		],
		'title_select_type_2_edit' => [
			'id',
			'type',
			'title_select_type',
			// 'receive_name',
			// 'receive_phone',
			// 'receive_province',
			// 'receive_address',
			'consumption_type',
			'company_name',
			// 'company_code',
			// 'company_register_address',
			// 'company_register_phone',
			// 'company_register_brank_name',
			// 'company_register_brank_account',
		],
	];
}