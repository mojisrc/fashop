<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/6
 * Time: 8:07 PM
 *
 */

namespace App\Broadcast;


class BroadcastController
{
	protected $args = [];

	/**
	 * @var \swoole_websocket_server $webSocketServer
	 */
	private $server;

	function __construct()
	{
		$this->server = \EasySwoole\Core\Swoole\ServerManager::getInstance()->getServer();
	}

	final public function getServer() : \swoole_websocket_server
	{
		return $this->server;
	}

	/**
	 * send名字为了统一 http的send
	 * 约束好要返回的格式
	 * @param int         $fd
	 * @param int         $code
	 * @param array       $data
	 * @param string|null $msg
	 */
	public function send( int $fd, int $code, array $data = [], string $msg = null ) : void
	{
		$this->server->push( $fd, json_encode( [
			"action" => $this->getArg( 'action' ),
			"code"   => $code,
			"result" => $data,
			"msg"    => $msg,
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
	}

	public function setArg( $key, $item ) : void
	{
		$this->args[$key] = $item;
	}

	public function getArg( $key )
	{
		if( isset( $this->args[$key] ) ){
			return $this->args[$key];
		} else{
			return null;
		}
	}

}