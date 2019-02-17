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
			'mobile_phone' => 'require|phone|checkMobilePhone',
			'type'         => 'require',
		];
	protected $message
		= [
	        'id.require'           => '参数错误',
	        'truename.require'     => '请输入收货人姓名',
	        'area_id.require'      => '请选择所在地区',
	        'address.require'      => '请输入详细地址',
	        'type.require'         => '请选择地址类型',
	        'mobile_phone.require' => '请输入手机号码',
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

    protected function checkMobilePhone( $value, $rule, $data )
    {
        if( !$this->is( $value, 'phone', $data ) ){
            return '手机号格式不对，请重新输入';
        }
        return true;
    }

}