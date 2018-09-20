<?php
/**
 * 购买流程
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

use App\Utils\Code;
use App\Logic\Pay\Notice\Facade as PayNoticeFacade;
use ezswoole\Log;
use Yansongda\Pay\Pay;

class Buy extends Server
{
	/**
	 * 计算购买项
	 * @method POST
	 * @param array $cart_ids   购物车id集合
	 * @param int   $address_id 地址id
	 * @author 韩文博
	 */
	public function calculate()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user = $this->getRequestUser();
				$data = [
					'user_id'    => $user['id'],
					'cart_ids'   => $this->post['cart_ids'],
					'address_id' => $this->post['address_id'],
					'user_info'  => (array)$user,
				];

				$model_buy       = new \App\Logic\Server\Buy\Buy( $data );
				$calculateResult = $model_buy->calculate();

				$this->send( Code::success, [
					'goods_amount'         => $calculateResult->getGoodsAmount(),
					'pay_amount'           => $calculateResult->getPayAmount(),
					'goods_freight_list'   => $calculateResult->getGoodsFreightList(),
					'freight_unified_fee'  => $calculateResult->getFreightUnifiedFee(),
					'freight_template_fee' => $calculateResult->getFreightTemplateFee(),
					'pay_freight_fee'      => $calculateResult->getPayFreightFee(),
				] );
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 创建购买订单
	 * @method POST
	 * @param int    $way        购买途径，`cart` 购物车、`right_now` 立即购买
	 * @param int    $address_id 收货地址id
	 * @param array  $cart_ids   购物车id集合
	 * @param string $message    买家留言
	 * @author 韩文博
	 *
	 */
	public function create()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user      = $this->getRequestUser();
				$model_buy = new \App\Logic\Server\Buy\Buy( [
					'user_id'    => $user['id'],
					'cart_ids'   => $this->post['cart_ids'],
					'address_id' => $this->post['address_id'],
					'message'    => isset( $this->post['message'] ) ? $this->post['message'] : null,
					'user_info'  => ['id' => $user['id'], 'username' => $user['username']],
				] );
				$result    = $model_buy->createOrder();
				if( $model_buy->getOrderId() ){
					$this->send( Code::success, [
						'order_id' => $result->getOrderId(),
						'pay_sn'   => $result->getPaySn(),
					] );
				} else{
					$this->send( Code::error );
				}
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 支付信息
	 * @method GET
	 * @param string $pay_sn 订单的sn码
	 * @author 韩文博
	 */
	public function info()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validate( $this->get, 'Server/Buy.info' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				try{
					$user        = $this->getRequestUser();
					$pay_sn      = $this->get['pay_sn'];
					$order_model = model( 'Order' );
					$pay_info    = $order_model->getOrderPayInfo( ['pay_sn' => $pay_sn, 'user_id' => $user['id']] );
					if( empty( $pay_info ) ){
						return $this->send( Code::error, [], '不存在该订单' );
					} else{
						$condition['pay_sn'] = $pay_sn;
						$condition['state']  = ['in', [\App\Logic\Order::state_new, \App\Logic\Order::state_pay]];
						$order_info          = $order_model->getOrderInfo( $condition, 'id,state,pay_name,amount,sn' );
						if( empty( $order_info ) ){
							return $this->send( Code::error, [], '未找到需要支付的订单' );
						}
						$pay_amount    = $order_info['amount'];
						$payment_model = model( 'Payment' );
						$payment_list  = $payment_model->getPaymentList( ['status' => 1], 'type,name', '', '1,100' );
						if( empty( $payment_list ) ){
							return $this->send( Code::error, [], '未找到可匹配的支付方式' );
						}
						$this->send( Code::success, [
							'order_id'     => $order_info['id'],
							'pay_amount'   => $pay_amount,
							'payment_list' => $payment_list,
						] );
					}
				} catch( \Exception $e ){
					$this->send( Code::server_error, [], $e->getMessage() );
				}
			}
		}
	}

	/**
	 * 支付
	 * @method POST
	 * @param string $order_type        订单支付类型，goods_buy商品购买，predeposit预存款充值
	 * @param string $pay_sn            订单的sn码
	 * @param string $payment_code      支付方式的标识码，在该接口上级的逻辑的接口上有返回，用来调起服务器端的支付方式的策略
	 *                                  支付方式 wechat wechat_app wechat_mini wechat_wap
	 * @param string $openid            微信的openid 非必需 只有微信支付的情况下可能需要
     * @param string $payment_channel   支付渠道 "wechat"  "wechat_mini" "wechat_app"
	 * @author   韩文博
	 */
	public function pay()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validate( $this->post, 'Server/Buy.pay' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				try{
					$user    = $this->getRequestUser();
					$payment = model( "Payment" )->getPaymentInfo( ['type' => $this->post['payment_code'], 'status' => 1] );
					if( !$payment ){
						$this->send( Code::error, [], '系统不支持选定的支付方式' );
					} else{
						$order_model = model( 'Order' );
						$pay_info    = model( 'OrderPay' )->getOrderPayInfo( [
							'pay_sn'    => $this->post['pay_sn'],
							'user_id'   => $user['id'],
							'pay_state' => 0,
						] );
						$order_info  = $order_model->getOrderInfo( [
							'pay_sn' => $this->post['pay_sn'],
							'state'  => \App\Logic\Order::state_new,
						], 'id,pay_sn,amount' );
						$amount      = $order_info['amount'] * 100;
						if( empty( $pay_info ) || empty( $order_info ) ){
							return $this->send( Code::error, [], '该订单不存在' );
						} else{
							switch( $this->post['payment_channel'] ){
							case 'wechat_mini':
								$options = Pay::wechat( $this->getPayConfig( $payment['config'], $this->post['payment_channel'] ) )->miniapp( [
									'attach'       => 'goods_buy',
									'out_trade_no' => $order_info['pay_sn'],
									'body'         => '商品购买_'.$pay_info['pay_sn'],
									'total_fee'    => "{$amount}",
									'openid'       => model( 'UserOpen' )->getUserOpenValue( ['user_id' => $user['id']], '', 'openid' ),
								] );
							break;
							default:
								# code...
							break;
							}

							$this->send( Code::success, $options );
						}
					}
				} catch( \Exception $e ){
					\ezswoole\Log::write( $e->getMessage() );
					$this->send( Code::server_error );
				}
			}
		}
	}

	/**
	 * 微信异步通知处理
	 * @method GET+post
	 * @author 韩文博
	 *
	 */
	public function wechatNotify()
	{
		try{
			$payment = model( "Payment" )->getPaymentInfo( ['type' => 'wechat'] );
			$notice  = PayNoticeFacade::wechat( $this->getPayConfig( $payment['config'], 'wechat' ) );
			if( $notice->check() === true ){
				$data       = $notice->getData();
				$orderLogic = new \App\Logic\Order();
				$result     = $orderLogic->pay( (string)$data->out_trade_no, 'wechat', (string)$data->transaction_id );
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

	/**
	 * todo 需要废弃
	 * 小程序回调
	 */
	public function wechatMiniNotify()
	{
		try{
			$payment = model( "Payment" )->getPaymentInfo( ['type' => 'wechat'] );
			$notice  = PayNoticeFacade::wechat( $this->getPayConfig( $payment['config'], 'wechat_mini' ) );
			if( $notice->check() === true ){
				$data       = $notice->getData();
				$orderLogic = new \App\Logic\Order();
				$result     = $orderLogic->pay( (string)$data->out_trade_no, 'wechat_mini', (string)$data->transaction_id );
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

	/**
	 * @param array $config
     * @param string $payment_channel 支付渠道
	 * @return array
	 * @author 韩文博
	 */
	private function getPayConfig( array $config, string $payment_channel ) : array
	{
	    $notify_url = "";
        switch ($payment_channel) {
            case 'wechat':
                $notify_url = "https://demo.fashop.cn/Server/Buy/wechatNotify";
                break;
            case 'wechat_mini':
                $notify_url = "https://demo.fashop.cn/Server/Buy/wechatMiniNotify";
                break;
            case 'wechat_app':
                $notify_url = "";
                break;
        }

		return [
			'appid'       => isset( $config['appid'] ) ? $config['appid'] : null,// APP APPID
			'app_id'      => isset( $config['app_id'] ) ? $config['app_id'] : null, // 公众号 APPID
			'miniapp_id'  => isset( $config['miniapp_id'] ) ? $config['miniapp_id'] : null,// 小程序 APPID
			'mch_id'      => isset( $config['mch_id'] ) ? $config['mch_id'] : null,
			'key'         => isset( $config['key'] ) ? $config['key'] : null,
			'notify_url'  => $notify_url,
			'cert_client' => EASYSWOOLE_ROOT."/".isset( $config['apiclient_cert'] ) ? $config['apiclient_cert'] : null,
			'cert_key'    => EASYSWOOLE_ROOT."/".isset( $config['apiclient_key'] ) ? $config['apiclient_key'] : null,
			'log'         => [
				'file'  => EASYSWOOLE_ROOT.'/Log/wechat.log',
				'level' => 'debug', // todo
			],
		];
	}
}
