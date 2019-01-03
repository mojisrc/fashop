<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/4
 * Time: 下午3:09
 *
 */
use App\HttpController\Admin\Admin;
class WechatTest extends PHPUnit\Framework\TestCase
{
	public function testPush()
	{

//		phpunit --bootstrap vendor/autoload.php --coverage-html reports/ tests/

//		$controller = new \App\Controller\Admin\Auth();
//		$controller->send(0);
		$this->assertEquals(-1, 0);
	}

}