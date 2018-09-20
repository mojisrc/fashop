<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/17
 * Time: 下午8:19
 *
 */

namespace EasySwoole;

class Websocket
{
	public static function register( \swoole_server $server){
		$server->on("message", function (\swoole_websocket_server $server, \swoole_websocket_frame $frame) {
			if($frame->data == 'pong'){
				$server->push($frame->fd, json_encode(['type' => 'pong', 'code' => 0, 'msg' => '服务器端保持心跳']));
			}
		});

		$server->on('open', function (\swoole_websocket_server $server, \swoole_http_request $request) {
			$server->push($request->fd, json_encode(['type' => 'open', 'code' => 0, 'msg' => '服务器请求连接']));
		});

		$server->on('close', function (\swoole_server $server, int $fd, int $reactorId) {
			$info = $server->connection_info( $fd );
			if( isset($info['websocket_status']) && $info['websocket_status'] === 3 ){
				$server->push( $fd, json_encode(['type' => 'close', 'code' => 0, 'msg' => '服务器链接关闭']) );
			}
		});
	}
}