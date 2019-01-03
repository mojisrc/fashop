<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/7
 * Time: 下午5:41
 *
 */

namespace FaShopTest\utils;

use EasySwoole\Core\Utility\Curl\Response as EsResponse;


class Response
{
	public $data;
	public $response;
	public function __construct( EsResponse $response )
	{
		$this->response = $response;
		$this->data = json_decode(  $response->getBody(), true );
	}
}