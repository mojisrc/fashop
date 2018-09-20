<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/21
 * Time: 下午10:46
 *
 */

namespace App\Utils;

use EasySwoole\Config;
use Overtrue\EasySms\EasySms;

class SystemSms
{
	private $results;

	public function send( string $to, string $code ) : bool
	{
		$sms_provider = model('SmsProvider')->getSmsProviderInfo(['status'=>1]);
		$config = [
			// HTTP 请求的超时时间（秒）
			'timeout'  => 5.0,
			// 默认发送配置
			'default'  => [
				// 网关调用策略，默认：顺序调用
				'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
				// 默认可用的发送网关
				'gateways' => [
					'alidayu',
				],
			],
			// 可用的网关配置
			'gateways' => [
				'errorlog' => [
					'file' => EASYSWOOLE_ROOT.'/Runtime/Log/easy-sms.log',
				],
				'aliyun'   => [
					'access_key_id'     => $sms_provider['access_key_id'],
					'access_key_secret' => $sms_provider['access_key_secret'],
				],
			],
		];
		$easySms = new EasySms( $config );

		try{
			$result = $easySms->send( $to, [
				'template' => 'SMS_122297317',
				'data'     => [
					'code' => $code,
				],
			], ['aliyun'] );
			return $result ? true : false;
		}catch(\Exception $e){
			$this->results = $e->results;
			return false;
		}


	}

	public function getResult(){
		return $this->results;
	}
}