<?php
/**
 *
 * 支付异步通知
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/7
 * Time: 下午12:04
 *
 */

namespace App\Logic\Pay\Notice;

use App\Logic\Pay\Notice\Alipay\Trade as AlipayTradeNotice;
use App\Logic\Pay\Notice\Alipay\Refund as AlipayRefundNotice;
use App\Logic\Pay\Notice\Wechat\Trade as WechatTradeNotice;
use App\Logic\Pay\Notice\Wechat\Refund as WechatRefundNotice;

use ezswoole\Request;

class  Facade
{
	/**
	 * @param array $config
	 * @return AlipayRefundNotice|AlipayTradeNotice
	 */
	final public static function alipay( array $config )
	{
		$request = Request::getInstance();
		$post    = $request->post();
		// 支付成功通知
		if( ($post['trade_status'] === 'TRADE_SUCCESS' || $post['trade_status'] === 'TRADE_FINISHED') ){
			$notice = new AlipayTradeNotice( $config );
		}
		// 退款通知
		if( isset( $post['gmt_refund'] ) ){
			$notice = new AlipayRefundNotice( $config );
		}
		return $notice;
	}

	/**
	 * @param array $config
	 * @return WechatRefundNotice|WechatTradeNotice
	 * @throws \Exception
	 * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
	 * @throws \ezswoole\db\exception\DataNotFoundException
	 * @throws \ezswoole\db\exception\ModelNotFoundException
	 * @throws \ezswoole\exception\PDOException
	 * @author 韩文博
	 */
	final public static function wechat( array $config = [] )
	{
		$request = Request::getInstance();
		$input   = $request->getInput();
		$post    = \Yansongda\Pay\Gateways\Wechat\Support::fromXml( $input );
		trace( ['input' => $post], 'debug' );
		if( empty( $config ) ){
			$config = \ezswoole\Db::name( "Payment" )->where( ['type' => 'wechat'] )->find();
		}
		$config = [
			'appid'       => isset( $config['appid'] ) ? $config['appid'] : null,
			'app_id'      => isset( $config['app_id'] ) ? $config['app_id'] : null,
			'miniapp_id'  => isset( $config['miniapp_id'] ) ? $config['miniapp_id'] : null,
			'mch_id'      => isset( $config['mch_id'] ) ? $config['mch_id'] : null,
			'key'         => isset( $config['key'] ) ? $config['key'] : null,
			'notify_url'  => isset( $config['notify_url'] ) ? $config['notify_url'] : null,
			'cert_client' => EASYSWOOLE_ROOT."/".isset( $config['apiclient_cert'] ) ? $config['apiclient_cert'] : null,
			'cert_key'    => EASYSWOOLE_ROOT."/".isset( $config['apiclient_key'] ) ? $config['apiclient_key'] : null,
			'log'         => [
				'file'  => EASYSWOOLE_ROOT.'/Runtime/Log/wechat.log',
				'level' => 'debug',
			],
		];
		// 支付成功通知
		if( $post['return_code'] === 'SUCCESS' && $post['result_code'] === 'SUCCESS' ){
			trace('WechatTradeNotice--------','debug');
			$notice = new WechatTradeNotice( $config );
		}
		// 退款通知
		if( $post['return_code'] === 'SUCCESS' && isset( $post['refund_status'] ) ){
			trace('WechatRefundNotice--------','debug');

			$notice = new WechatRefundNotice( $config );
		}
		trace('$notice--------','debug');

		return $notice;
	}

}