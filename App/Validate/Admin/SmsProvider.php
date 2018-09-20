<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/8
 * Time: 下午4:13
 *
 */

namespace App\Validate\Admin;


use ezswoole\Validate;

class SmsProvider extends Validate
{
	protected $rule
		= [
			'type'   => 'require|checkType',
			'config' => 'require|array|checkConfig',
		];
	protected $message
		= [];
	protected $scene
		= [
			'edit' => [
				'type',
				'config',
			],
			'status'=>[
				'type'
			],
			'info'=>[
				'type'
			],
		];

	protected function checkType( $value, $rule, $data )
	{
		if( !in_array( $value, ['aliyun'] ) ){
			return "不存在该类型";
		}else{
			return true;
		}
	}

	protected function checkConfig( $value, $rule, $data )
	{
		switch( $data['type'] ){
		case 'aliyun':
			if( !isset( $value['access_key_id'] ) ){
				return 'access_key_id必填';
			}
			if( !isset( $value['access_key_secret'] ) ){
				return 'access_key_secret必填';
			}
		break;
		}
		return true;
	}
}