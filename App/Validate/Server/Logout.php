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

namespace App\Validate\Server;

use ezswoole\Validate;
use ezswoole\Db;
use App\Logic\Server\Login as LoginLogic;

class Logout extends Validate
{
	protected $rule
		= [
			'access_token' => 'require|checkAccessToken',
		];
	protected $message
		= [
			'username.require' => "AccessToken必填",
		];
	protected $scene
		= [
			'pc'         => [
				'access_token',
			],
			// 微信公众平台
			'wechatMp'   => [
				'access_token',
			],
			// 微信小程序
			'wechatMini' => [
				'access_token',
			],
			// 手机站
			'wap'        => [
				'access_token',
			],
			'app'        => [
				'access_token',
			],
		];

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkAccessToken( $value, $rule, $data )
	{
		// 获得token信息
		$loginLogic        = new LoginLogic();
		$access_token_data = $loginLogic->getAccessTokenData( $value );
		$current_time      = time();
		// 是否过期
		if( !empty( $access_token_data ) || ($current_time > $access_token_data['exp']) ){
			return "AccessToken无效 或 AccessToken已过期";
		}
		// 是否存在
		$condition['id']         = $access_token_data['id'];
		$condition['state']      = 1;
		$condition['is_logout']  = 0;
		$condition['is_invalid'] = 0;
		$find                    = Db::name( 'AccessToken' )->where( $condition )->field( 'id,expire_time' )->find();
		if( !$find ){
			return "AccessToken无效";
		} elseif( $access_token_data['exp'] !== $find['expire_time'] ){
			return "AccessToken 过期信息有误";
		} else{
			return true;
		}
	}
}