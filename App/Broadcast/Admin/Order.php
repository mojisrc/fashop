<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/6
 * Time: 2:48 PM
 *
 */

namespace App\Broadcast\Admin;

use App\Broadcast\BroadcastController;
use App\Biz\Fd;
use App\Utils\WebSocketCode as Code;
use EasySwoole\Core\Component\Logger;

class Order extends BroadcastController
{
	/**
	 * 支付过的订单消息推送
	 * @return bool
	 */
	function pay()
	{
		try{
			$client = new Fd();
			// 给管理员发送订单通知
			$client_id_array = $client->user( 1 );
			$server          = $this->getServer();
			foreach( $server->connections as $fd ){
				$connection[] = $fd;
			}
			if( !empty( $client_id_array ) ){
				foreach( $client_id_array as $fd ){
					$info = $server->connection_info( $fd );
					if( $info['websocket_status'] === 3 ){
						$this->send( $fd, Code::success, [
							'info' => $this->getArg( 'payload' ),
						] );
					};
				}
			}
			return true;
		} catch( \Exception $e ){
			Logger::getInstance()->log( $e->getTraceAsString() );
		}
	}
}