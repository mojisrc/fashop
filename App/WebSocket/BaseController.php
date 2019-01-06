<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/4
 * Time: 5:29 PM
 *
 */

namespace App\WebSocket;

use EasySwoole\Core\Socket\AbstractInterface\WebSocketController;

class BaseController extends WebSocketController
{
	// todo 不适合推送到多用户 后期改变写法
	public function send( int $code, array $data = [], string $msg = null ) : void
	{
		$this->response()->write( json_encode( [
			"action" => $this->request()->getArg( 'action' ),
			"sign"   => $this->request()->getArg( 'sign' ),
			"code"   => $code,
			"result" => $data,
			"msg"    => $msg,
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
	}
}