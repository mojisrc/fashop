<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/20
 * Time: 下午7:22
 *
 */

namespace App\Logic;

use Firebase\JWT\JWT;


class VerifyCode
{
	const channelTypes   = ['sms', 'email'];
	const behaviourTypes = ['register', 'login', 'findPassword', 'editPassword','bindPhone'];

	// 人类反应间隔时间
	private $humanReactIntervalSeconds = 3;

	public function __construct()
	{

	}

	public function createToken() : string
	{
		$create_time       = time();
		$access_token_data = [
			// todo 上线后加入判断域名和上个页面地址的逻辑
			'create_time' => $create_time,
		];
		return JWT::encode( $access_token_data, "__verify_code_", ['HS256'] );
	}

	public function getTokenData( string $token ) : object
	{
		try{
			$access_token_data = JWT::decode( $token, "__verify_code_", ['HS256'] );
		} catch( \Firebase\JWT\ExpiredException $e ){
			return $e;
		} catch( \Firebase\JWT\SignatureInvalidException $e ){
			return $e;
		} catch( \Exception $e ){
			return $e;
		}
		return $access_token_data;
	}

	public function isHuman( string $token ) : bool
	{
		$token_data           = $this->getTokenData( $token );
		$request_current_time = time();

		// 当前请求的时间 和 token 生成的时间 小于人类反应的时间为假
		if( $request_current_time - $token_data['create_time'] < $this->humanReactIntervalSeconds ){
			return false;
		}

		return true;
	}

}