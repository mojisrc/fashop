<?php

namespace App\Validate;

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
class Shipper extends Validate
{
	//验证
	protected $rule
		= [
			'id'             => 'require',
			'name'           => 'require',
			'province_id'    => 'require',
			'city_id'        => 'require',
			'area_id'        => 'require',
			'street_id'      => 'require',
			'area_info'      => 'require',
			'address'        => 'require',
			'contact_number' => 'require|length:11',
			'is_default'     => 'require|between:0,1',
		];
	//提示
	protected $message
		= [
			'id.require'             => 'ID必填',
			'name.require'           => '发货人必填',
			'province_id.require'    => '省ID必填',
			'city_id.require'        => '市ID必填',
			'area_id.require'        => '区县ID必填',
			'street_id.require'      => '街道ID必填',
			'area_info.require'      => '地区信息必填',
			'address.require'        => '详细地址必填',
			'contact_number.require' => '联系电话必填',
			'contact_number.length'  => '联系电话必须是11位',
			'is_default.require'     => '是否为默认地址必填',
			'is_default.between'     => '是否为默认地址必须是0-1',
		];
	//场景
	protected $scene
		= [
			'add'  => [
				'name',
				'area_id',
				'address',
				'contact_number',
			],
			'edit' => [
				'id',
				'name',
				'area_id',
				'address',
				'contact_number',
			],
			'del'  => [
				'id',
			],
			'set'  => [
				'id',
				'is_default',
			],
		];
}