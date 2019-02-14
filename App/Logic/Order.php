<?php
/**
 * 订单列表逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2016 WenShuaiKeJi Inc. (http://www.wenshuai.cn)
 * @license    http://www.wenshuai.cn
 * @link       http://www.wenshuai.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;
class Order extends Logic
{
	// 取消订单
	const state_cancel = 0;
	// 未支付订单
	const state_new = 10;
	// 已支付
	const state_pay = 20;
	// 已发货
	const state_send = 30;
	// 已收货，交易成功
	const state_success = 40;
	// 未评价
	const state_unevaluate = 40;
	// 已评价
	const ORDER_EVALUATE = 40; // todo
	//订单结束后可评论时间，15天，60*60*24*15
	const ORDER_EVALUATE_TIME = 1296000; // todo 需要可修改

	const allowed_order_states
		= [
			'state_close',
			'state_new',
			'state_pay',
			'state_send',
			'state_success',
			'state_cancel',
			'state_refund',
			'state_unevaluate',
		];

	// 待付款
	const group_state_new = 0;
	// 正在进行中(待开团)
	const group_state_pay = 1;
	// 拼团成功
	const group_state_success = 2;
	// 拼团失败
	const group_state_fail = 3;

	const allowed_order_group_states
		= [
			'group_state_new',
			'group_state_pay',
			'group_state_success',
			'group_state_fail',
		];
	/**
	 * @var string
	 */
	private $groupStateType;
	/**
	 * @var int
	 */
	private $orderType;
	/**
	 * @var array
	 */
	private $condition;
	/**
	 * @var string
	 */
	private $condition_string;
	/**
	 * @var array
	 */
	private $userIds;
	/**
	 * @var int
	 */
	private $print;
	/**
	 * @var string
	 */
	private $stateType;
	/**
	 * @var string
	 */
	private $keywordsType;
	/**
	 * @var mixed
	 */
	private $keywords;
	/**
	 * @var array
	 */
	private $createTime;
	/**
	 * @var array
	 */
	private $page;
	/**
	 * @var string
	 */
	private $order = 'id desc';
	/**
	 * @var string
	 */
	private $field = '*';

	/**
	 * @var array
	 */
	private $alias
		= [
			'order' => 'order',
		];
	/**
	 * @var array
	 */
	private $extend
		= [
			'order_goods',
			'order_extend',
			'user',
		];

	private $make = null;

	public function createTime( array $create_time ) : Order
	{
		if( count( $create_time ) != 2 ){
			throw new \InvalidArgumentException( "create_time error" );
		} else{
			$this->createTime = $create_time;
			return $this;
		}
	}

	public function stateType( string $state_type ) : Order
	{
		if( !in_array( $state_type, self::allowed_order_states ) ){
			throw new \InvalidArgumentException( "state error" );
		} else{
			$this->stateType = $state_type;
			return $this;
		}
	}

	public function groupStateType( string $group_state_type ) : Order
	{
		if( !in_array( $group_state_type, self::allowed_order_group_states ) ){
			throw new \InvalidArgumentException( "group_state error" );
		} else{
			$this->groupStateType = $group_state_type;
			return $this;
		}
	}

	public function orderType( int $order_type ) : Order
	{
		if( !in_array( $order_type, [1, 2] ) ){
			throw new \InvalidArgumentException( "order_type error" );
		} else{
			$this->orderType = $order_type;
			return $this;
		}
	}

	public function users( string $type, array $params ) : Order
	{
		if( !in_array( $type, ['id'] ) ){
			throw new \InvalidArgumentException( "users error" );
		} else{
			$this->userIds = $params;
			return $this;
		}
	}

	public function keywords( string $type, $keywords ) : Order
	{
		if( !in_array( $type, ['goods_name', 'order_no', 'receiver_name', 'receiver_phone', 'courier_number'] ) ){
			throw new \InvalidArgumentException( "keywords error" );
		} else{
			$this->keywordsType = $type;
			$this->keywords     = $keywords;
			return $this;
		}
	}

	public function print( int $stateCode ) : Order
	{
		if( !in_array( $stateCode, [0, 1] ) ){
			throw new \InvalidArgumentException( "print error" );
		} else{
			$this->print = $stateCode;
			return $this;
		}
	}

	public function feedback( string $type ) : Order
	{
		if( !in_array( $type, ['todo', 'closed'] ) ){
			throw new \InvalidArgumentException( "feedback error" );
		} else{
			$this->feedback = $type;
			return $this;
		}
	}

	/**
	 * @param array $condition
	 * @throws \Exception
	 */
	public function __construct( array $condition = [], string $condition_string = '' )
	{
		$this->condition        = $condition;
		$this->condition_string = $condition_string;


	}

	public function buildCondition() : void
	{
		// todo 什么意思？@孙泉
//		$this->condition['all_agree_refound'] = 0;//默认为0，1是订单的全部商品都退了

		if( !empty( $this->stateType ) ){

			$this->condition['state'] = constant( 'self::'.$this->stateType );

			//          if( $this->stateType === 'state_unevaluate' ){
			//                $this->condition['evaluate_state'] = 0; // 评价状态 0未评价，1已评价
			//            }
			if( $this->stateType === 'state_cancel' ){
				$this->condition['refund_state'] = 0;
			}

		}

		if( !empty( $this->groupStateType ) ){
			$this->condition['group_state'] = constant( 'self::'.$this->groupStateType );
		}

		if( !empty( $this->orderType ) ){
			$this->condition['goods_type'] = $this->orderType;
		}

		if( !empty( $this->print ) ){
			$this->condition['is_print'] = $this->print;
		}

		if( !empty( $this->createTime ) ){
			$this->condition['create_time'] = [
				'between',
				$this->createTime,
			];
		}

		if( !empty( $this->userIds ) ){
			$this->condition['user_id'] = ['in', $this->userIds];
		}
		$prefix             = \EasySwoole\EasySwoole\Config::getInstance()->getConf( 'MYSQL.prefix' );
		$table_order_extend = $prefix."order_extend";
		$table_order_goods  = $prefix."order_goods";
		if( !empty( $this->keywords ) && !empty( $this->keywordsType ) ){
			switch( $this->keywordsType ){
			case 'goods_name':
				$this->condition["order.id"] = [
					'exp',
					"in (SELECT GROUP_CONCAT(order_id) FROM $table_order_goods WHERE goods_title LIKE '%".$this->keywords."%' GROUP BY order_id)",
				];
			break;
			case 'order_no':
				$this->condition['sn'] = ['like', '%'.$this->keywords.'%'];
			break;

			case 'receiver_name':
				$this->condition["order.id"] = [
					'exp',
					"in (SELECT GROUP_CONCAT(id) FROM $table_order_extend WHERE reciver_name LIKE '%".$this->keywords."%' GROUP BY id)",
				];
			break;

			case 'receiver_phone':
				$this->condition["order.id"] = [
					'exp',
					"in (SELECT GROUP_CONCAT(id) FROM $table_order_extend WHERE receiver_phone LIKE '%".$this->keywords."%' GROUP BY id)",
				];
			break;

			case 'courier_number':
				$this->condition['trade_no'] = ['like', '%'.$this->keywords.'%'];
			break;
			}
		}

		$table_order_refund = $prefix."order_refund";

		if( !empty( $this->feedback ) ){
			//维权状态：退款处理中 todo、退款结束 closed
			$this->condition['refund_state'] = ['>', 0]; // 退款状态:0是无退款,1是部分退款,2是全部退款
			$this->condition['lock_state']   = ['>', 0];   // 锁定状态:0是正常,大于0是锁定,默认是0
			switch( $this->feedback ){
			case 'todo':
				$this->condition["id"] = [
					'exp',
					"in (SELECT GROUP_CONCAT(id) FROM $table_order_refund WHERE handle_state in(0,20))",
				];
			break;
			case 'closed':
				$this->condition["id"] = [
					'exp',
					"in (SELECT GROUP_CONCAT(id) FROM $table_order_refund WHERE handle_state in(10,30))",
				];
			break;
			}
		}

	}

	public function alias( string $table_name, string $alias_name ) : Order
	{
		$this->alias[$table_name] = $alias_name;
		return $this;
	}

	public function page( array $page ) : Order
	{
		$this->page = $page;
		return $this;
	}

	public function field( string $field ) : Order
	{
		$this->field = $field;
		return $this;
	}

	public function extend( array $extend ) : Order
	{
		$this->extend = $extend;
		return $this;
	}

	public function order( string $order ) : Order
	{
		$this->order = $order;
		return $this;
	}

	private function make() : \App\Model\Order
	{
		if( $this->make ){
			return $this->make;
		} else{
			$this->buildCondition();
			$model = new \App\Model\Order;
			return $model;
		}
	}

	public function count() : int
	{
		return $this->make()->count();
	}

	public function list() : array
	{
		return $this->make()->getOrderList( $this->condition,  $this->field, $this->order, $this->page, $this->extend );
	}

	public function info() : array
	{
		return $this->make()->getOrderInfo( $this->condition, $this->condition_string, $this->field, $this->extend );
	}


	/**
	 * 支付订单
	 * @param    string $pay_sn
	 * @param    string $payment_code
	 * @param    string $trade_no
	 * @throws \Exception
	 * @return   array
	 */
	public function pay( string $pay_sn, string $payment_code, string $trade_no ) : bool
	{
		$order_model = new \App\Model\Order;
		$order_model->startTransaction();
		try{
			// 修改支付状态
			$order_pay_info = \App\Model\OrderPay::init()->getOrderPayInfo( ['pay_sn' => $pay_sn, 'pay_state' => 0] );
			if( empty( $order_pay_info ) ){
				throw new \Exception( '订单支付信息不存在' );
			}
			$order_condition = [
				'pay_sn' => $pay_sn,
				'state'  => self::state_new,
			];
			$order_info      = \App\Model\Order::init()->getOrderInfo( $order_condition );
			if( empty( $order_info ) ){
				throw new \Exception( '订单不存在' );
			}
			$update = \App\Model\OrderPay::init()->editOrderPay( ['pay_sn' => $pay_sn], ['pay_state' => 1] );
			if( !$update ){
				$order_model->rollback();
				throw new \Exception( '更新订单支付状态失败' );
			}
			// 修改订单
			$order_update = [
				'state'          => self::state_pay,
				'payment_time'   => time(),
				'payment_code'   => $payment_code,
				'trade_no'       => $trade_no,    //支付宝交易号
				'out_request_no' => 'HZ01RF00'.$order_info['id'], //支付宝：标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
			];

			//判断是否为拼团订单
			if( $order_info['goods_type'] == 2 ){
				$group_state  = 2;
				$grouping_num = \App\Model\Order::init()->getOrderColumn( ['group_sign' => $order_info['group_sign'], 'state' => self::state_pay, 'group_state' => 2], 'id' );//已刨除自身
				if( $order_info['group_people_num'] == $order_info['group_men_num'] && $order_info['group_men_num'] == (count( $grouping_num ) + 1) ){
					$group_state = 3;
				}
				$order_update = array_merge( $order_update, ['group_state' => $group_state] );
			}

			$order_update_result = \App\Model\Order::init()->editOrder( $order_condition, $order_update );
			if( !$order_update_result ){
				$order_model->rollback();
				throw new \Exception( '更新订单状态失败' );
			}

			//修改整团订单拼团状态为拼团成功 刨除自身(上步已更改)
			if( isset( $group_state ) && $group_state == 3 ){
				$order_update_result = \App\Model\Order::init()->editOrder( ['group_sign' => $order_info['group_sign'], 'id' => ['neq', $order_info['id']]], ['group_state' => $group_state] );
				if( !$order_update_result ){
					$order_model->rollback();
					throw new \Exception( '更新整团拼团状态失败' );
				}
			}

			//记录订单日志
			$insert = \App\Model\OrderLog::init()->addOrderLog( [
				'order_id'    => $order_info['id'],
				'role'        => 'buyer',
				'msg'         => "支付成功，支付平台交易号 : {$trade_no}",
				'order_state' => self::state_pay,
			] );
			if( !$insert ){
				$order_model->rollback();
				throw new \Exception( '记录订单日志出现错误' );
			}
			$order_model->commit();
			return true;
		} catch( \Exception $e ){
			$order_model->rollback();
			\ezswoole\Log::write( "第三方支付通知成功后，更改订单状态失败：".$e->getMessage() );
			return false;
		}
	}
}