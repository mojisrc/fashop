<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/4
 * Time: 4:37 PM
 *
 */

namespace App\WebSocket\Admin;

use App\Utils\WebSocketCode as Code;
use App\Logic\Fd;
use App\WebSocket\AccessTokenController;

class Member extends AccessTokenController
{
	function actionNotFound( ?string $actionName )
	{
		$this->send( Code::param_error );
	}

	function login()
	{

		try{
			$client = new Fd();
			$find   = $client->get( $this->client()->getFd() );
			if( $find ){
				$this->send( Code::param_error, [], '已经登陆' );
			} else{
				$addResult = $client->add( $this->getRequestAccessTokenData()['sub'], $this->client()->getFd() );
				if( $addResult ){
					$this->send( Code::success );
				} else{
					$this->send( Code::error );
				}
			}
		} catch( \Exception $e ){
			$this->send( Code::param_error, [], $e->getTraceAsString() );
		}
	}
}