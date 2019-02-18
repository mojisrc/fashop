<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019-02-18
 * Time: 23:25
 *
 */

namespace App\Utils;


class Pay
{
	public static function alipay(){
		$aliConfig = new \EasySwoole\Pay\AliPay\Config();
		$aliConfig->setGateWay(\EasySwoole\Pay\AliPay\GateWay::NORMAL);
		$aliConfig->setAppId($payment['']);
		$aliConfig->setPublicKey('阿里公钥');
		$aliConfig->setPrivateKey('阿里私钥');
	}
}