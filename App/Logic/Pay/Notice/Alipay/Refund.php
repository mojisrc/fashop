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

namespace App\Logic\Pay\Notice\Alipay;
use Yansongda\Pay\Log;

class Refund extends Notice
{
	final public function check() : bool
	{
		try{
			$data = $this->pay->verify();
			$this->setData($data);
			if( isset( $this->data->gmt_refund ) || isset($this->data->refund_fee) ){
				// 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
				$order_model = model( 'Audition' );
				$this->order = $order_model->where( [
					'out_trade_no' => $this->data->out_trade_no,
					'trade_no'=>$this->data->trade_no,
				] )->find();

				// 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
				// 4、验证app_id是否为该商户本身。
				if( $this->data->app_id !== $this->config['app_id'] ){
					trace( "app_id 错误", 'debug' );
					return false;
				}
				if( $this->order['id'] > 0 ){
					return true;
				} else{
					trace( "没有该订单", 'debug' );
					return false;
				}
			} else{
				trace( "alipay check data trade_status fail" );
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
				'refund_time'  => strtotime($this->data->gmt_refund),

			] );
			if( !$result ){
				trace( "退款订单修改 失败", 'debug' );
				return false;
			}
		} else{
			return false;
		}
		Log::debug( 'Alipay notify', $this->data->all() );
		return true;
	}
}