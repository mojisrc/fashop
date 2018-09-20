<?php
/**
 * 退款\退款退货
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;

use ezswoole\Model;
use traits\model\SoftDelete;

class OrderRefund extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	protected $type
		= [
			'goods_spec'      => 'json',
			'images'          => 'json',
			'tracking_images' => 'json',
			'user_images'     => 'json',
		];

	/**
	 * 增加退款\退款退货
	 * @param
	 * @return int
	 */
	public function addOrderRefund( $refund_array, $order = [], $goods = [] )
	{
		if( !empty( $order ) && is_array( $order ) ){
			$refund_array['order_id']     = $order['id'];
			$refund_array['order_sn']     = $order['sn'];
			$refund_array['payment_code'] = $order['payment_code']; //支付方式 根据支付方式不同 走的退款接口不一样
			$refund_array['trade_no']     = $order['trade_no'];    //支付宝交易号OR微信交易号
			$refund_array['user_id']      = $order['user_id'];
			$refund_array['user_name']    = $order['user_name'];
			$refund_array['order_state']  = $order['state'];        //此时订单的状态
			$refund_array['order_amount'] = $order['amount'];        //总订单支付金额
		}
		if( !empty( $goods ) && is_array( $goods ) ){
			$refund_array['goods_id']          = $goods['goods_id'];
			$refund_array['goods_sku_id']      = $goods['goods_sku_id'];
			$refund_array['order_goods_id']    = $goods['id'];
			$refund_array['goods_title']       = $goods['goods_title'];
			$refund_array['goods_img']         = $goods['goods_img'];
			$refund_array['goods_spec']        = $goods['goods_spec'];
			$refund_array['goods_num']         = $goods['goods_num'];
			$refund_array['goods_pay_price']   = $goods['goods_pay_price'];
			$refund_array['goods_freight_fee'] = $goods['goods_freight_fee'];
		}
		return $this->save( $refund_array ) ? $this->id : false;
	}

	/**
	 * 订单锁定
	 * @param
	 * @return bool
	 */
	public function editOrderLock( $order_id, $refund_state )
	{
		$order_id = intval( $order_id );
		if( $order_id > 0 ){
			$condition            = [];
			$condition['id']      = $order_id;
			$data                 = [];
			$data['lock_state']   = ['exp', 'lock_state+1'];
			$data['refund_state'] = $refund_state; //退款状态:0是无退款,1是部分退款,2是全部退款
			$result               = model( 'Order' )->editOrder( $condition, $data );
			return $result;
		}
		return false;
	}


	/**
	 * 订单解锁
	 *
	 * @param
	 * @return bool
	 */
	public function editOrderUnlock( $order_id, $refund_state )
	{
		$order_id = intval( $order_id );
		if( $order_id > 0 ){
			$condition               = [];
			$condition['id']         = $order_id;
			$condition['lock_state'] = ['egt', 1];
			$data                    = [];
			$data['lock_state']      = ['exp', 'lock_state-1'];
			$data['delay_time']      = time();
			$data['refund_state']    = $refund_state; //退款状态:0是无退款,1是部分退款,2是全部退款
			$result                  = model( 'Order' )->editOrder( $condition, $data );
			return $result;
		}
		return false;
	}

	/**
	 * 商品锁定
	 *
	 * @param id pk
	 * @return bool
	 */
	public function editOrderGoodsLock( $id, $refund_id )
	{
		$id = intval( $id );
		if( $id > 0 ){
			$condition                   = [];
			$condition['id']             = $id;
			$data                        = [];
			$data['lock_state']          = ['exp', 'lock_state+1'];
			$data['refund_handle_state'] = 0; //退款平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成) 只有锁定时才管用
			$data['refund_id']           = $refund_id;
			$result                      = model( 'OrderGoods' )->editOrderGoods( $condition, $data );
			return $result;
		}
		return false;
	}

	/**
	 * 商品解锁
	 *
	 * @param
	 * @return bool
	 */
	public function editOrderGoodsUnlock( $id )
	{
		$id = intval( $id );
		if( $id > 0 ){
			$condition               = [];
			$condition['id']         = $id;
			$condition['lock_state'] = ['egt', '1'];
			$data                    = [];
			$data['lock_state']      = ['exp', 'lock_state-1'];
			$result                  = model( 'OrderGoods' )->editOrderGoods( $condition, $data );
			return $result;
		}
		return false;
	}


	/**
	 * 更改退款信息
	 *
	 * @param array $data
	 * @param array $condition
	 * @param boolean
	 */
	public function editOrderRefund( $condition, $data )
	{
		return !!$this->update( $data, $condition, true )->saveResult;
	}

	/**
	 * 取退款记录
	 *
	 * @param
	 * //类型:refund_type 1为退款,2为退货
	 * @return array
	 */
	public function getOrderRefundList( $condition = [], $field = '*', $order = 'id desc', $page = '1,20' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : [];
	}

	/**
	 * 退款\退款退货申请编号
	 *
	 * @param
	 * @return string
	 */
	public function getOrderRefundSn( $id )
	{
		$result = mt_rand( 100, 999 ).substr( 100 + $id, - 3 ).date( 'ymdHis' );
		return $result;
	}

	/**
	 * 取一条记录
	 *
	 * @param
	 * @return array
	 */
	public function getOrderRefundInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 根据订单取商品的退款\退款退货状态
	 *
	 * @param
	 * @return array | false
	 */
	public function getOrderGoodsRefundList( $order_list = [] )
	{
		if( empty( $order_list ) ){
			return false;
		}
		$trade_logic  = model( 'Trade', 'Logic' );
		$refund_list  = $this->where( [
			'order_id' => [
				'in',
				array_column( $order_list, 'id' ),
			],
		] )->order( 'id desc' )->select()->toArray();
		$refund_goods = []; // 已经提交的退款\退款退货商品
		if( !empty( $refund_list ) && is_array( $refund_list ) ){
			foreach( $refund_list as $key => $value ){
				$order_id = $value['order_id']; // 订单编号
				$goods_id = $value['order_goods_id']; // 订单商品表编号
				if( empty( $refund_goods[$order_id][$goods_id] ) ){
					$refund_goods[$order_id][$goods_id] = $value;
				}
			}
		}

		// 订单状态：0(已取消)10(默认):未付款;20:已付款;30:已发货;40:已收货;
		if( !empty( $order_list ) && is_array( $order_list ) ){
			foreach( $order_list as $key => $value ){
				$order_id                    = $key;
				$value['extend_order_goods'] = [];
				$goods_list                  = $value['extend_order_goods']; //订单商品
				$order_state                 = $value['state']; //订单状态
				$order_paid                  = $trade_logic->getOrderState( 'order_paid' ); //订单状态20:已付款
				$payment_code                = $value['payment_code']; //支付方式
				if( $order_state == $order_paid && $payment_code != 'offline' ){
					// 已付款未发货的非货到付款订单可以申请取消
					$order_list[$order_id]['refund'] = 1;
				} elseif( $order_state > $order_paid && !empty( $goods_list ) && is_array( $goods_list ) ){
					// 已发货后对商品操作
					$refund = $this->getOrderRefundState( $value ); //根据订单状态判断是否可以退款\退款退货
					foreach( $goods_list as $k => $v ){
						$goods_id = $v['id']; //订单商品表编号
						if( $v['goods_pay_price'] > 0 ){
							//实际支付额大于0的可以退款
							$v['refund'] = $refund;
						}
						if( !empty( $refund_goods[$order_id][$goods_id] ) ){
							$seller_state = $refund_goods[$order_id][$goods_id]['seller_state']; //卖家处理状态:1为待审核,2为同意,3为不同意
							if( $seller_state == 3 ){
								$order_list[$order_id]['complain'] = 1; // 不同意可以发起投诉
							} else{
								$v['refund'] = 0; // 已经存在处理中或同意的商品不能再操作
							}
							$v['extend_refund'] = $refund_goods[$order_id][$goods_id];
						}
						$goods_list[$k] = $v;
					}
				}
				$order_list[$order_id]['extend_order_goods'] = [];
				$order_list[$order_id]['extend_order_goods'] = $goods_list;
			}
		}
		return $order_list;
	}

	/**
	 * 根据订单取商品的退款\退款退货状态
	 * @param
	 * @return array
	 */
	public function getOrderGoodsRefundInfo( $order_info = [] )
	{
		if( empty( $order_info ) ){
			return false;
		}
		$trade_logic  = model( 'Trade', 'Logic' );
		$refund_list  = $this->where( ['order_id' => $order_info['id']] )->order( 'id desc' )->select()->toArray();
		$refund_goods = []; // 已经提交的退款\退款退货商品
		if( !empty( $refund_list ) && is_array( $refund_list ) ){
			foreach( $refund_list as $key => $value ){
				$goods_id = $value['order_goods_id']; // 订单商品表编号
				if( empty( $refund_goods[$goods_id] ) ){
					$refund_goods[$goods_id] = $value;
				}
			}
		}
		// 订单状态：0(已取消)10(默认):未付款;20:已付款;30:已发货;40:已收货;
		if( !empty( $order_info ) && is_array( $order_info ) ){
			$goods_list   = $order_info['extend_order_goods']; //订单商品
			$order_state  = $order_info['state']; //订单状态
			$order_paid   = $trade_logic->getOrderState( 'order_paid' ); //订单状态20:已付款
			$payment_code = $order_info['payment_code']; //支付方式
			if( $order_state == $order_paid && $payment_code != 'offline' ){
				// 已付款未发货的非货到付款订单可以申请取消
				$order_info['refund'] = 1;
			} elseif( $order_state > $order_paid && !empty( $goods_list ) && is_array( $goods_list ) ){
				// 已发货后对商品操作
				$refund = $this->getOrderRefundState( $order_info ); //根据订单状态判断是否可以退款\退款退货
				foreach( $goods_list as $k => $v ){
					$goods_id = $v['id']; //订单商品表编号
					if( $v['goods_pay_price'] > 0 ){
						// 实际支付额大于0的可以退款
						$v['refund'] = $refund;
					}
					if( !empty( $refund_goods[$goods_id] ) ){
						$seller_state = $refund_goods[$goods_id]['seller_state']; //卖家处理状态:1为待审核,2为同意,3为不同意
						if( $seller_state == 3 ){
							$order_info['complain'] = 1; // 不同意可以发起投诉
						} else{
							$v['refund'] = 0; //已经存在处理中或同意的商品不能再操作
						}
						$v['extend_refund'] = $refund_goods[$goods_id];
					}
					$goods_list[$k] = $v;
				}
			}
			$order_info['extend_order_goods'] = $goods_list;
		}
		return $order_info;
	}

	/**
	 * 根据订单判断投诉订单商品是否可退款
	 *
	 * @param
	 * @return array
	 */
	public function getComplainOrderRefundList( $order )
	{
		$list         = [];
		$refund_list  = []; //已退或处理中商品
		$refund_goods = []; //可退商品
		if( !empty( $order ) && is_array( $order ) ){
			$order_id              = $order['id'];
			$order_list[$order_id] = $order;
			$order_list            = $this->getOrderGoodsRefundList( $order_list );
			$order                 = $order_list[$order_id];
			$goods_list            = $order['extend_order_goods'];
			$order_amount          = $order['amount']; //订单金额
			$order_refund_amount   = $order['refund_amount']; //订单退款金额
			foreach( $goods_list as $k => $v ){
				$goods_id          = $v['id']; //订单商品表编号
				$v['refund_state'] = 3;
				if( !empty( $v['extend_refund'] ) ){
					$v['refund_state'] = $v['extend_refund']['seller_state']; //卖家处理状态为3,不同意时能退款
				}
				if( $v['refund_state'] > 2 ){
					// 可退商品
					$goods_pay_price = $v['goods_pay_price']; //商品实际成交价
					if( $order_amount < ($goods_pay_price + $order_refund_amount) ){
						$goods_pay_price      = $order_amount - $order_refund_amount;
						$v['goods_pay_price'] = $goods_pay_price;
					}
					$v['goods_refund']       = $v['goods_pay_price'];
					$refund_goods[$goods_id] = $v;
				} else{
					// 已经存在处理中或同意的商品不能再退款
					$refund_list[$goods_id] = $v;
				}
			}
		}
		$list = [
			'refund' => $refund_list,
			'goods'  => $refund_goods,
		];
		return $list;
	}

	/**
	 * 根据订单状态判断是否可以退款\退款退货
	 *
	 * @param
	 * @return array
	 */
	public function getOrderRefundState( $order )
	{
		$refund          = 0; //默认不允许退款\退款退货
		$order_state     = $order['state']; //订单状态
		$trade_logic     = model( 'Trade', 'Logic' );
		$order_shipped   = $trade_logic->getOrderState( 'order_shipped' ); //30:已发货
		$order_completed = $trade_logic->getOrderState( 'order_completed' ); //40:已收货

		switch( $order_state ){
		case $order_shipped:
			$payment_code = $order['payment_code']; //支付方式
			if( $payment_code != 'offline' ){
				// 货到付款订单在没确认收货前不能退款\退款退货
				$refund = 1;
			}
		break;
		case $order_completed:
			$order_refund = $trade_logic->getMaxDay( 'order_refund' ); //15:收货完成后可以申请退款\退款退货
			$delay_time   = $order['delay_time'] + 60 * 60 * 24 * $order_refund;
			if( $delay_time > time() ){
				$refund = 1;
			}
		break;
		default:
			$refund = 0;
		break;
		}

		return $refund;
	}

	/**
	 * 向模板页面输出退款\退款退货状态
	 *
	 * @param
	 * @return array
	 */
	public function getOrderRefundStateArray( $type = 'all' )
	{
		$state_array = [
			1 => '待审核',
			2 => '同意',
			3 => '不同意',
		]; //卖家处理状态:1为待审核,2为同意,3为不同意

		$admin_array = [
			1 => '处理中',
			2 => '待处理',
			3 => '已完成',
		]; //确认状态:1为买家或卖家处理中,2为待平台管理员处理,3为退款\退款退货已完成
		$state_data  = [
			'seller' => $state_array,
			'admin'  => $admin_array,
		];
		if( $type == 'all' ){
			return $state_data;
		}
		//返回所有
		return $state_data[$type];
	}

	/**
	 * 退货退款数量
	 *
	 * @param array $condition
	 * @return int
	 */
	public function getOrderRefundCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获得任意字段
	 * @param array $condition
	 * @param array $update_data
	 */
	public function getOrderRefundValue( $condition = [], $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取退款数据的文字描述
	 * @param  data 退款表数据
	 * @return [type]            [description]
	 */
	public function getOrderRefundDesc( $data )
	{
		$state_desc = '';
		// 1 申请退款，等待商家确认 2同意申请，等待买家退货 3买家已发货，等待收货  4已收货，确认退款 5退款成功 6退款关闭
		// 退款关闭状态中应包含商家拒绝的申请，买家主动撤销的申请等
		if( $data['handle_state'] = 0 ){//平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成)
			$state_desc = '申请退款，等待商家确认';

		} elseif( $data['handle_state'] == 20 && $data['refund_type'] == 2 && $data['shipping_code'] == null && $data['shipping_time'] == 0 ){
			$state_desc = '同意申请，等待买家退货';

		} elseif( $data['handle_state'] == 20 && $data['refund_type'] == 2 && $data['shipping_code'] != null && $data['shipping_time'] > 0 && $data['receive'] == 1 ){
			$state_desc = '买家已发货，等待收货';

		} elseif( $data['handle_state'] == 20 && $data['refund_type'] == 2 && $data['shipping_code'] != null && $data['shipping_time'] > 0 && $data['receive'] == 2 ){
			$state_desc = '已收货，确认退款';

		} elseif( $data['handle_state'] == 30 ){
			$state_desc = '退款成功';

		} elseif( $data['is_close'] == 1 ){
			$state_desc = '退款关闭';

		}
		return $state_desc;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelOrderRefund( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}
}