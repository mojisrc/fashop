<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/7
 * Time: 11:07 AM
 *
 */

namespace App\WebSocket;


use EasySwoole\Core\Socket\AbstractInterface\WebSocketController;

class Heartbeat extends WebSocketController
{
	function keep()
	{
		// 照顾wsdebug 测试调试工具，todo 废弃，遵循新的路由写法
		$this->response()->write( json_encode( [
			"type" => 'pong',
		] ) );
	}
}