<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/6
 * Time: 下午8:41
 *
 */

namespace App\Logic\Pay\Notice\Wechat;

use Yansongda\Pay\Log;

class Refund extends Notice
{
	final public function __construct( $config )
	{
		parent::__construct( $config );
	}

	final public function check() : bool
	{
		try{
			$content = request()->getEsRequest()->getSwooleRequest()->rawContent();
			$data = $this->pay->verify($content);
			trace('微信返回的数据，但这有加密   记得测试下','debug');
			trace($data,'debug');
			$this->setData( $data );
			if( isset( $this->data->refund_id ) || isset( $this->data->refund_fee ) ){
				// 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
				$order_model = model( 'Audition' );
				$this->order = $order_model->where( [
					'out_trade_no' => $this->data->out_trade_no,
					'trade_no'     => $this->data->transaction_id,
				] )->find();

				if( $this->order['id'] > 0 ){
					return true;
				} else{
					trace( "没有该订单", 'debug' );
					return false;
				}
			} else{
				trace( "wechat check data trade_status fail" );
				return false;
			}
		} catch( \Exception $e ){
			trace( $e->getMessage(), 'debug' );
			return false;
		}
	}

	final public function handle() : bool
	{
		if( $this->check() === true ){
			$order_model = model( 'Audition' );
			
			$result      = $order_model->editAudition( ['id' => $this->order['id']], [
				'refund_state' => 1,
				'refund_time'  => strtotime( $this->data->success_time ),
				'refund_fee'   => $this->data->refund_fee,
			] );
			if( !$result ){
				trace( "退款订单修改 失败", 'debug' );
				return false;
			}
		} else{
			return false;
		}
		Log::debug( 'Wechat notify', $this->data->all() );
		return true;
	}
}