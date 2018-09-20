<?php
/**
 * 交易新模型
 * todo 重新理解定义该模型，存在有些模糊
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

class Trade
{
	/**
	 * 订单处理天数
	 * @method     GET
	 * @datetime 2017-05-29T10:53:23+0800
	 * @author   韩文博
	 * @param    string $day_type
	 * @return   int | array
	 */
	public function getMaxDay( $day_type = 'all' )
	{
		$max_data = [
			'order_cancel'   => config( 'db_setting.order_cancel_max_day' ), //未选择支付方式时取消订单
			'order_confirm'  => config( 'db_setting.order_confirm_max_day' ), //买家不收货也没退款时自动完成订单
			'order_refund'   => 15, //收货完成后可以申请退款退货
			'refund_confirm' => config( 'db_setting.refund_confirm_max_day' ), //卖家不处理退款退货申请时按同意处理
			'return_confirm' => 7, //卖家不处理收货时按弃货处理
			'return_delay'   => 5, //退货的商品发货多少天以后才可以选择没收到
		];
		if( $day_type == 'all' ){
			return $max_data;
		}
		// 返回所有
		if( intval( $max_data[$day_type] ) < 1 ){
			$max_data[$day_type] = 1;
		}
		// 最小的值设置为1
		return $max_data[$day_type];
	}

	/**
	 * 获得订单状态
	 * @datetime 2017-05-29T10:53:34+0800
	 * @author   韩文博
	 * @param    string $type
	 * @return   int | array
	 */
	public function getOrderState( $type = 'all' )
	{
		$state_data = [
			'order_cancel'    => \App\Logic\Order::state_cancel, //0:已取消
			'order_default'   => \App\Logic\Order::state_new, //10:未付款
			'order_paid'      => \App\Logic\Order::state_pay, //20:已付款
			'order_shipped'   => \App\Logic\Order::state_send, //30:已发货
			'order_completed' => \App\Logic\Order::state_success, //40:已收货
		];
		if( $type == 'all' ){
			return $state_data;
		}
		// 返回所有
		return $state_data[$type];
	}

	/**
	 * 更新订单
	 * @datetime 2017-05-29T10:54:31+0800
	 * @author   韩文博
	 * @param  integer $user_id
	 * @return bool
	 */
	public function editOrderPay( $user_id = 0 )
	{
		$order_cancel  = $this->getMaxDay( 'order_cancel' ); // 未选择支付方式时取消订单的天数
		$day           = time() - $order_cancel * 60 * 60 * 24;
		$order_confirm = $this->getMaxDay( 'order_confirm' ); // 买家不收货也没锁定订单时自动完成订单的天数
		$shipping_day  = time() - $order_confirm * 60 * 60 * 24;
		$order_default = $this->getOrderState( 'order_default' ); // 订单状态10:未付款
		$order_shipped = $this->getOrderState( 'order_shipped' ); // 订单状态30:已发货

		$condition_sql = "";
		if( $user_id > 0 ){
			$condition_sql = " user_id = '".$user_id."' and ";
		}
		$condition_sql .= " ((state='".$order_default."' and create_time<".$day.") or (state='".$order_shipped."' and lock_state=0 and delay_time<".$shipping_day."))"; //待支付(10)和待收货(30)

		$field      = 'id,user_id,id,create_time,payment_time,delay_time,state';
		$order_list = db( 'Order' )->field( $field )->where( $condition_sql )->select();

		if( !empty( $order_list ) && is_array( $order_list ) ){
			foreach( $order_list as $order_info ){
				$order_id                = $order_info['id']; // 订单编号
				$order_state             = $order_info['state']; //订单状态
				$log_data                = [];
				$log_data['role']        = 'system';
				$log_data['create_time'] = time();
				$log_data['order_id']    = $order_id;
				switch( $order_state ){
				case $order_default:
					$order_time = $order_info['create_time']; // 订单生成时间
					if( intval( $order_time ) < $day ){
						// 超期时取消订单
						$log_data['msg'] = lang( 'order_max_day' ).$order_cancel.lang( 'order_max_day_cancel' );
						$this->editOrderCancel( $order_id, $log_data );
					}
				break;
				case $order_shipped:
					$order_time = $order_info['delay_time'];
					if( intval( $order_time ) < $shipping_day ){
						// 超期时自动完成订单
						$log_data['msg'] = lang( 'order_max_day' ).$order_confirm.lang( 'order_max_day_confirm' );
						$this->editOrderFinish( $order_id, $log_data );
					}
				break;
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * 取消订单并退回库存
	 * @param int      $order_id 订单编号
	 * @param    array $log_data 订单记录信息
	 * @datetime 2017-05-29T10:53:23+0800
	 * @author   韩文博
	 */
	public function editOrderCancel( $order_id, $log_data )
	{
		$goods_list = model( 'OrderGoods' )->getOrderGoodsList( ['order_id' => $order_id], 'order_id,goods_num,goods_sku_id,goods_id', 'id desc', '1,10000' );
		if( !empty( $goods_list ) && is_array( $goods_list ) ){
			$GoodsSkuModel = model( 'GoodsSku' );
			foreach( $goods_list as $goods_info ){
				$goods_id              = $goods_info['goods_sku_id'];
				$goods_num             = $goods_info['goods_num'];
				$condition             = [];
				$condition['id']       = $goods_id;
				$condition['sale_num'] = ['egt', $goods_num];
				$data                  = [];
				$data['stock']         = ['exp', 'stock+'.$goods_num];
				$data['sale_num']      = ['exp', 'sale_num-'.$goods_num];
				$GoodsSkuModel->editGoodsSku( $condition, $data );
			}
			$orderData          = [];
			$orderData['state'] = \App\Logic\Order::state_cancel;
			$order_model        = model( 'Order' );
			$state              = $order_model->editOrder( ['id' => $order_id], $orderData ); //更新订单
			if( $state ){
				$log_data['order_state'] = $orderData['state'];
				$state                   = $order_model->addOrderLog( $log_data );
			}
			return $state;
		}
		return false;
	}

	/**
	 * 更新退款申请
	 * @param int $user_id 会员编号
	 * @datetime 2017-05-29T10:53:23+0800
	 * @author   韩文博
	 */
	public function editRefundConfirm( $user_id = 0 )
	{
		$refund_confirm            = $this->getMaxDay( 'refund_confirm' ); //卖家不处理退款申请时按同意并弃货处理
		$day                       = time() - $refund_confirm * 60 * 60 * 24;
		$condition                 = [];
		$condition['seller_state'] = 1; //状态:1为待审核,2为同意,3为不同意
		$condition['create_time']  = ['lt', $day];
		$condition['user_id']     = $user_id;

		$refund_data                   = [];
		$refund_data['refund_state']   = 2; //状态:1为处理中,2为待管理员处理,3为已完成
		$refund_data['seller_state']   = 2; //卖家处理状态:1为待审核,2为同意,3为不同意
		$refund_data['return_type']    = 1; //退货类型:1为不用退货,2为需要退货
		$refund_data['seller_time']    = time();
		$refund_data['seller_message'] = lang( 'order_max_day' ).$refund_confirm.lang( 'order_day_refund' );
		db( 'OrderRefund' )->where( $condition )->update( $refund_data );

		$return_confirm = $this->getMaxDay( 'return_confirm' ); //卖家不处理收货时按弃货处理
		$day            = time() - $return_confirm * 60 * 60 * 24;
		// 物流状态:1为待发货,2为待收货,3为未收到,4为已收货
		$condition                 = [];
		$condition['seller_state'] = 2; //状态:1为待审核,2为同意,3为不同意
		$condition['goods_state']  = 2;
		$condition['return_type']  = 2;
		$condition['delay_time']   = ['lt', $day];
		$condition['user_id']     = $user_id;

		$refund_data                   = [];
		$refund_data['refund_state']   = 2; //状态:1为处理中,2为待管理员处理,3为已完成
		$refund_data['return_type']    = 1; //退货类型:1为不用退货,2为需要退货
		$refund_data['seller_message'] = lang( 'order_max_day' ).$return_confirm.'天未处理收货，按弃货处理';
		db( 'OrderRefund' )->where( $condition )->update( $refund_data );
	}

	/**
	 * 自动收货完成订单
	 * @param int      $order_id 订单编号
	 * @param    array $log_data 订单记录信息
	 * @datetime 2017-05-29T10:53:23+0800
	 * @author   韩文博
	 */
	public function editOrderFinish( $order_id, $log_data = [] )
	{
		$order_model     = model( 'Order' );
		$order           = $order_model->getOrderInfo( ['id' => $order_id], 'id,user_id,user_name,id,sn,amount,payment_code,state' );
		$order_shipped   = $this->getOrderState( 'order_shipped' ); //订单状态30:已发货
		$order_completed = $this->getOrderState( 'order_completed' ); //订单状态40:已收货
		if( $order['state'] == $order_shipped ){
			// 确认已经完成发货
			if( empty( $log_data ) ){
				$log_data['order_id']    = $order_id;
				$log_data['role']        = 'system';
				$log_data['msg']         = "订单自动完成";
				$log_data['create_time'] = time();
			}
			$order_data                  = [];
			$order_data['finnshed_time'] = time();
			$order_data['state']         = $order_completed;
			$state                       = $order_model->editOrder( ['id' => $order_id], $order_data ); //更新订单状态为已收货
			$log_data['order_state']     = $order_completed;
			if( $state ){
				$state = $order_model->addOrderLog( $log_data );
			}
			// 订单处理记录信息
			return $state;
		} else{
			return false;
		}
	}

}

?>