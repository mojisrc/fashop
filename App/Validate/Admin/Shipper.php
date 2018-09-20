<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Admin;

use ezswoole\Validate;
use ezswoole\Db;
use App\Logic\VerifyCode;

class Shipper extends Validate
{
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
			'contact_number' => 'require',

		];
	protected $message
		= [
			'id.require'               => "id必须",
			'name.require'             => "发货人必须",
			'province_id.require'      => "省ID必须",
			'city_id.require'          => "市ID必须",
			'area_id.require'          => "区县ID必须",
			'combine_detail  .require' => "地区信息，如：天津 天津市 河西区 南京路，空格间隔必须",
			'address.require'          => "详细地址必须",
			'contact_number .require'  => "联系电话必须",

		];


	protected $scene
		= [
			'add' => [
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

			'del' => [
				'id',
			],

			'setDefault' => [
				'id',
			],

			'setRefundDefault' => [
				'id',
			],

		];


}