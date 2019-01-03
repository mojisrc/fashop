<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/7
 * Time: 下午5:24
 *
 */

namespace FaShopTest\utils;

use ezswoole\Curl as fashopCurl;


class Curl extends fashopCurl
{
	private $accessToken;
	private $baseUrl;

	/**
	 * @return mixed
	 */
	public function getBaseUrl()
	{
		return $this->baseUrl;
	}

	/**
	 * @param mixed $baseUrl
	 */
	public function setBaseUrl( string $baseUrl ) : void
	{
		$this->baseUrl = $baseUrl;
	}



	public function getAccessToken() : string
	{
		return $this->accessToken;
	}

	public function setAccessToken( string $access_token ) : void
	{
		$this->accessToken = $access_token;
	}



	public function loginRequest( string $method, string $url, array $param  = []) : Response
	{
		$param['header']['Access-Token'] = $this->getAccessToken();
		$response =  $this->request( $method, $this->getBaseUrl().$url, $param );
		return new Response($response);
	}
}