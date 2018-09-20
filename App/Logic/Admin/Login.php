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
namespace App\Logic\Admin;


class Login
{
	/**
	 * PC 下 密码登陆记录
	 * @param string $username
	 * @return bool
	 * @author 韩文博
	 * todo 3次密码登陆错误 禁止一定时间不允许登陆
	 */
	public function pcPasswordLogin( string $username ) : ? array
	{
		$condition['username']  = $username;
		$user = model( 'User' )->getUserInfo( $condition, 'id' );
		if( $user ){
			$accessTokenLogic = new \App\Logic\AccessToken();
			return $accessTokenLogic->createAccessToken( $user['id'], time() );
		} else{
			return null;
		}
	}
}

?>
