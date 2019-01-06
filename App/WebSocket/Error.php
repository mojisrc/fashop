<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/5
 * Time: 10:01 PM
 *
 */

namespace App\WebSocket;

use App\Utils\WebSocketCode as Code;

class Error extends BaseController
{
	function handel()
	{
		/**
		 * @var \Exception $exception
		 */
		$exception = $this->request()->getArg('exception');
		$this->send( Code::server_error ,[],$exception->getTraceAsString());
	}
}