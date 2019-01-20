<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/8/29
 * Time: 下午1:55
 *
 */

namespace App\HttpController;

use FastRoute\RouteCollector;
use EasySwoole\Core\Http\Request;
use EasySwoole\Core\Http\Response;
use EasySwoole\Core\Swoole\ServerManager;
use wsdebug\WsDebug;

class Router extends \EasySwoole\Core\Http\AbstractInterface\Router
{

	function register( RouteCollector $routeCollector )
	{
		$routeCollector->get( '/wsdebug', function( Request $request, Response $response ){
			$isSsl = request()->isSsl();
			$host  = request()->host();
			$port  = \Easyswoole\Config::getInstance()->getConf( "MAIN_SERVER.PORT" );
			if( $host === 'localhost' ){
				$host = '127.0.0.1';
			}
			if( filter_var( $host, FILTER_VALIDATE_IP ) ){
				$url = "{$host}:{$port}";
			} else{
				$url = $host;
			}
			$wsdebug = new WsDebug();
			$wsdebug->setHost( ($isSsl ? 'wss://' : 'ws://').$url );
			$wsdebug->setServer( ServerManager::getInstance()->getServer() );
			$response->write( $wsdebug->getHtml() );
			$response->end();
		} );
	}
}