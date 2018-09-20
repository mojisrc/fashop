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

class Payment extends Validate
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
		if( !in_array( $value, ['wechat','wechat_app', 'wechat_mini', 'wechat_mp', 'wechat_wap'] ) ){
			return "不存在该类型";
		}else{
			return true;
		}
	}

	protected function checkConfig( $value, $rule, $data )
	{
		switch( $data['type'] ){
		case 'wechat':
//			if( !isset( $value['app_id'] ) ){
//				return 'app_id必填';
//			}
			if( !isset( $value['mch_id'] ) ){
				return 'mch_id必填';
			}
			if( !isset( $value['key'] ) ){
				return 'key必填';
			}
//			if( !isset( $value['app_secret'] ) ){
//				return 'app_secret必填';
//			}
//			if( !isset( $value['appid'] ) ){
//				return 'appid必填';
//			}
//			if( !isset( $value['miniapp_id'] ) ){
//				return 'miniapp_id必填';
//			}
//			if( !isset( $value['notify_url'] ) ){
//				return 'notify_url必填';
//			}
//			if( !isset( $value['cert_client'] ) ){
//				return 'cert_client必填';
//			}
//			if( !isset( $value['cert_key'] ) ){
//				return 'cert_key必填';
//			}
		break;
		case 'wechat_mini':
			if( !isset( $value['app_id'] ) ){
				return 'app_id必填';
			}
			if( !isset( $value['app_secret'] ) ){
				return 'app_secret必填';
			}
		break;
		default :
			return '没有该支付方式';
			break;
		}
		return true;
	}
}