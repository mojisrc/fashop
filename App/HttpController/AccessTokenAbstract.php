<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/26
 * Time: 下午5:40
 *
 */

namespace App\HttpController;

use EasySwoole\Spl\SplArray;
use ezswoole\Controller;
use App\Biz\AccessToken as AccessTokenLogic;

/**
 * Class AccessTokenAbstract
 * @package App\HttpController
 * @property \ezswoole\Request $request
 */
abstract class AccessTokenAbstract extends Controller
{
	protected $user = [];
	protected $accessToken;
	protected $accessTokenData;
	protected $acceessTokenLogic;
	protected $request;

	// todo 设置RequestUserBean
	final protected function getRequestUser()
	{
		if( empty( $this->user ) ){
			$access_token_data = $this->getRequestAccessTokenData();
			$condition['id']   = $access_token_data['sub'];
			$user              = \App\Model\User::init()->getUserInfo( $condition );
			if( !empty( $user ) ){
				$user_auxiliary = $this->getUserInfo( $user['id'] );
				return new SplArray( array_merge( $user, $user_auxiliary ) );
			} else{
				return false;
			}
		} else{
			return $this->user;
		}
	}

	final protected function getRequestAccessToken() : ?String
	{
		if( $this->accessToken ){
			return $this->accessToken;
		} else{
			$header = $this->request->header();
			if( !empty( $header ) && isset( $header['access-token'] ) ){
				return $header['access-token'];
			} else{
				return null;
			}
		}
	}

	final protected function getRequestAccessTokenData() : ?SplArray
	{
		if( $this->accessTokenData instanceOf SplArray ){
			return $this->accessTokenData;
		} else{
			$access_token = $this->getRequestAccessToken();
			if( $access_token ){
				$state = $this->getAccessTokenLogic()->checkAccessToken( $access_token );
				if( $state ){
					return new SplArray( $this->getAccessTokenLogic()->decode( $access_token ) );
				} else{
					return null;
				}
			} else{
				return null;
			}
		}
	}

	final protected function verifyResourceRequest() : bool
	{
		return $this->getRequestAccessTokenData() ? true : false;
	}

	final protected function getAccessTokenLogic() : AccessTokenLogic
	{
		if( !$this->acceessTokenLogic instanceof AccessTokenLogic ){
			$this->acceessTokenLogic = new AccessTokenLogic();
		}
		return $this->acceessTokenLogic;
	}

	/**
	 * 获得用户的相关信息
	 * @param $user_id
	 * @return array
	 */
	final protected function getUserInfo( $user_id )
	{
		$data                 = [];
		$condition['user_id'] = $user_id;
		$data['profile']      = \App\Model\UserProfile::init()->getUserProfileInfo( $condition );
		$data['assets']       = \App\Model\UserAssets::init()->getUserAssetsInfo( $condition );
		return $data;
	}
}