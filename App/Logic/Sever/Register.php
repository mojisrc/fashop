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

use App\Logic\User as UserLogic;
use ezswoole\Validate;
use ezswoole\Db;

class Register
{

	public function pc( string $username, string $password, string $wechat_qr_sign )
	{
		$user_model                                       = model( 'User' );
		$data['username']                                 = $username;
		$data['password']                                 = UserLogic::encryptPassword( $password );
		$data[$this->getAccountRegisterType( $username )] = $username;
		if( $wechat_qr_sign ){
			// 绑定微信
			$wechat_qr_id = Db::name( 'WechatQr' )->where( ['sign' => $wechat_qr_sign] )->value( 'id' );
			if( $wechat_qr_id > 0 ){
				$wechat_openid = Db::name( 'QrScanLog' )->where( ['wechat_qr_sign' => $wechat_qr_sign] )->value( 'wechat_openid' );
				if( $wechat_openid ){
					$data['wechat_openid'] = $wechat_openid;
				}
			}
		}
		return $user_model->addUser( $data );
	}

	private function getAccountRegisterType( $username ) : string
	{
		if( Validate::is( $username, 'phone' ) === true ){
			return 'phone';
		}
		if( Validate::is( $username, 'email' ) === true ){
			return 'email';
		}
	}

}

?>
