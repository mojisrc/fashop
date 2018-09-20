<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/22
 * Time: 下午1:55
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;
use App\Utils\Code;

class Address extends Validate
{
	protected $rule
		= [
			'id'           => 'require',
			'truename'     => 'require',
			'province_id'  => 'require',
			'city_id'      => 'require',
			'area_id'      => 'require',
			'address'      => 'require',
			'type'         => 'require',
			'area_info'    => 'require',
			'mobile_phone' => 'require',
			'type'         => 'require',
		];
	protected $message
		= [
			'id.require'   => Code::param_error,
			'truename'     => Code::param_error,
			'area_id'      => Code::param_error,
			'address'      => Code::param_error,
			'type'         => Code::param_error,
			'mobile_phone' => Code::param_error,
		];
	protected $scene
		= [
			'info' => [
				'id',
			],
			'add'  => [
				'type',
				'truename',
				'area_id',
				'address',
				'mobile_phone',
				'is_default'
			],
			'edit' => [
				'id',
				'type',
				'truename',
				'area_id',
				'address',
				'mobile_phone',
				'is_default'
			],
			'del'  => [
				'id',
			],
		];


}