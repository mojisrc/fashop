<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/5
 * Time: 下午23:51
 *
 */

namespace App\WebSocket;

use EasySwoole\Core\Component\Spl\SplArray;
use App\Biz\AccessToken as AccessTokenLogic;

/**
 * Class AccessTokenController
 * @package App\HttpController
 */
class AccessTokenController extends BaseController
{
	protected $accessToken;
	protected $accessTokenData;
	protected $acceessTokenLogic;

	final protected function getRequestAccessToken() : ?String
	{
		if( $this->accessToken ){
			return $this->accessToken;
		} else{
			$param = $this->request()->getArg( 'param' );
			if( !empty( $param ) && isset( $param['access_token'] ) ){
				return $param['access_token'];
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
}