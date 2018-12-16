<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/14
 * Time: 下午1:28
 *
 */

namespace App\HttpController\Server;

use App\HttpController\AccessTokenAbstract;
use ezswoole\Request;
use App\Utils\Code;
use EasySwoole\Config as AppConfig;

abstract class Server extends AccessTokenAbstract
{
	/**
	 * 当访问
	 * @param $actionName
	 */
	protected function onRequest( $actionName ) : ?bool
	{
		parent::onRequest( $actionName );
		$this->request = Request::getInstance();
		if( $this->request->method() === 'OPTIONS' ){
			$this->send( Code::success );
			$this->response()->end();
			return false;
		} else{
			return true;
		}
	}

	protected function send( $code = 0, $data = [], $message = null )
	{
		$this->response()->withAddedHeader( 'Access-Control-Allow-Origin', AppConfig::getInstance()->getConf( 'response.access_control_allow_origin' ) );
		$this->response()->withAddedHeader( 'Content-Type', 'application/json; charset=utf-8' );
		$this->response()->withAddedHeader( 'Access-Control-Allow-Headers', AppConfig::getInstance()->getConf( 'response.access_control_allow_headers' ) );
		$this->response()->withAddedHeader( 'Access-Control-Allow-Methods', AppConfig::getInstance()->getConf( 'response.access_control_allow_methods' ) );

		$this->response()->withStatus( 200);

		$content = [
			"code"   => $code,
			"result" => $data,
			"msg"    => $message,
		];
		$this->response()->write( json_encode( $content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
		wsdebug()->send( $content, 'debug' );
	}
}
