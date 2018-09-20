<?php
/**
 * 权限业务逻辑处理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Logic\Server;

use ezswoole\Validate;
use ezswoole\Db;

class Login
{
	/**
	 * PC 下 密码登陆记录
	 * @param string $username
	 * @param string $wechat_qr_sign wechat_qr表的sign
	 * @return bool
	 * @author 韩文博
	 */
	public function pcPasswordLogin( string $username, string $wechat_qr_sign = null ) : ? array
	{
		if( Validate::is( 'phone', $username ) === true ){
			$condition['phone'] = $username;
		} elseif( Validate::is( 'email', $username ) ){
			$condition['email'] = $username;
		} else{
			return null;
		}

		$userModel = model( 'User' );

		$user = $userModel->getUserInfo( $condition, 'id,wechat_openid' );

		if( !$user['wechat_openid'] && $wechat_qr_sign ){
			$this->bindByWechatQrSign( $user['id'], $wechat_qr_sign );
		}

		if( $user ){
			$accessTokenLogic = new \App\Logic\AccessToken();
			return $accessTokenLogic->createAccessToken( $user['id'], time() );
		} else{
			return null;
		}
	}

	/**
	 * PC 下 短信验证码登陆
	 * @param string $phone
	 * @return bool
	 * @author 韩文博
	 */
	public function pcSmsCodeLogin( string $phone, string $wechat_qr_sign = null ) : ?array
	{
		$user = model( 'User' )->getUserInfo( ['phone' => $phone], 'id,wechat_openid' );

		if( $user ){
			if( !$user['wechat_openid'] && $wechat_qr_sign ){
				$this->bindByWechatQrSign( $user['id'], $wechat_qr_sign );
			}
			$accessTokenLogic = new \App\Logic\AccessToken();
			return $accessTokenLogic->createAccessToken( $user['id'], time() );
		} else{
			return null;
		}
	}

	/**
	 * PC 下 微信验证码登陆
	 * @param string $wechat_qr_sign
	 * @return bool
	 * @author 韩文博
	 */
	public function pcWechatQrLogin( string $wechat_qr_sign ) : ?array
	{
		// 获得用户的openid
		$wechat_openid = Db::name( 'QrScanLog' )->where( ['wechat_qr_sign' => $wechat_qr_sign] )->value( 'wechat_openid' );
		if( $wechat_openid ){
			$user = model( 'User' )->getUserInfo( ['wechat_openid' => $wechat_openid], 'id' );
			if( $user ){
				$accessTokenLogic = new \App\Logic\AccessToken();
				return $accessTokenLogic->createAccessToken( $user['id'], time() );
			} else{
				return null;
			}
		} else{
			return null;
		}
	}

	private function bindByWechatQrSign( int $user_id, string $wechat_qr_sign )
	{
		// 绑定微信
		$wechat_qr_id = Db::name( 'WechatQr' )->where( ['sign' => $wechat_qr_sign] )->value( 'id' );
		if( $wechat_qr_id > 0 ){
			$wechat_openid = Db::name( 'QrScanLog' )->where( ['wechat_qr_sign' => $wechat_qr_sign] )->value( 'wechat_openid' );
			if( $wechat_openid ){
				model( 'User' )->editUser( ['id' => $user_id], ['wechat_openid' => $wechat_openid] );
			}
		}
	}
}

?>
