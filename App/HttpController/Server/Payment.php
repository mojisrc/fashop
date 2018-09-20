<?php
/**
 * 支付入口
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use App\Logic\Pay\Notice\Wechat\Trade;
use App\Utils\Code;
use ezswoole\Log;
class Payment extends Server
{
	/**
	 * 支付方式列表
	 * @method GET
	 * @author 韩文博
	 */
	public function list()
	{
		$list = model( "Payment" )->getPaymentList( ['status' => 1], 'type,name', '', '1,1000' );
		$this->send( Code::class, ['list' => $list] );
	}

	/**
	 * 微信app支付回调
	 */
	public function wechatN()
	{
		try{
			$config = \ezswoole\Db::name( "Payment" )->where( ['type' => 'wechat'] )->find();
			$config = [
				'appid'       => isset( $config['appid'] ) ? $config['appid'] : null,
				'app_id'      => isset( $config['app_id'] ) ? $config['app_id'] : null,
				'miniapp_id'  => isset( $config['miniapp_id'] ) ? $config['miniapp_id'] : null,
				'mch_id'      => isset( $config['mch_id'] ) ? $config['mch_id'] : null,
				'key'         => isset( $config['key'] ) ? $config['key'] : null,
				'notify_url'  => isset( $config['notify_url'] ) ? $config['notify_url'] : null,
				'cert_client' => EASYSWOOLE_ROOT."/".isset( $config['cert_client'] ) ? $config['cert_client'] : null,
				'cert_key'    => EASYSWOOLE_ROOT."/".isset( $config['cert_key'] ) ? $config['cert_key'] : null,
				'log'         => [
					'file'  => EASYSWOOLE_ROOT.'/Log/wechat.log',
					'level' => 'debug',
				],
			];
			$notice = new Trade( $config );
			if( $notice->check() === true ){
				$data         = $notice->getData();
				$out_trade_no = $data->out_trade_no; //商户订单号
				$trade_no     = $data->transaction_id; //交易号
				$orderLogic   = new \App\Logic\Order();
				$result       = $orderLogic->pay( (string)$out_trade_no, 'wechat', (string)$trade_no );
				if( $result ){
					$this->response()->write( 'success' );
				} else{
					Log::write( "微信支付处理订单失败" );
				}
			} else{
				Log::write( "微信支付通知验证失败" );
			}
		} catch( \Exception $e ){
			Log::write( "微信支付通知处理失败：".$e->getMessage() );
		}

	}
}
