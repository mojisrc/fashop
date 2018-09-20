<?php
/**
 * 交易新模型
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
use EasySwoole\Core\Component\Di;

class Trade extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';
	protected $tableName = '';
	/**
	 * 订单处理天数
	 *
	 */
	public function getMaxDay($day_type = 'all') {
		$max_data = array(
			'order_cancel'   => 7, //未选择支付方式时取消订单
			'order_confirm'  => 10, //买家不收货也没退款时自动完成订单
			'order_refund'   => 15, //收货完成后可以申请退款退货
			'refund_confirm' => 7, //卖家不处理退款退货申请时按同意处理
			'return_confirm' => 7, //卖家不处理收货时按弃货处理
			'return_delay'   => 5, //退货的商品发货多少天以后才可以选择没收到
		);
		if ($day_type == 'all') {
			return $max_data;
		}
		//返回所有
		if (intval($max_data[$day_type]) < 1) {
			$max_data[$day_type] = 1;
		}
		//最小的值设置为1
		return $max_data[$day_type];
	}
	/**
	 * 订单状态
	 *
	 */
	public function getOrderState($type = 'all') {
		$state_data = array(
			'order_cancel'    => \App\Logic\Order::state_cancel, //0:已取消
			'order_default'   => \App\Logic\Order::state_new, //10:未付款
			'order_paid'      => \App\Logic\Order::state_pay, //20:已付款
			'order_shipped'   => \App\Logic\Order::state_send, //30:已发货
			'order_completed' => \App\Logic\Order::state_success, //40:已收货
		);
		if ($type == 'all') {
			return $state_data;
		}
		//返回所有
		return $state_data[$type];
	}
	/**
	 * 更新订单
	 * @param int $user_id 会员编号
	 * @param int $id 店铺编号
	 */
	public function editOrderPay($user_id = 0, $id = 0) {
		$order_cancel  = $this->getMaxDay('order_cancel'); //未选择支付方式时取消订单的天数
		$day           = time() - $order_cancel * 60 * 60 * 24;
		$order_confirm = $this->getMaxDay('order_confirm'); //买家不收货也没锁定订单时自动完成订单的天数
		$shipping_day  = time() - $order_confirm * 60 * 60 * 24;
		$order_default = $this->getOrderState('order_default'); //订单状态10:未付款
		$order_shipped = $this->getOrderState('order_shipped'); //订单状态30:已发货
		$condition     = " ((state='" . $order_default . "' and create_time<" . $day . ") or (state='" . $order_shipped . "' and lock_state=0 and delay_time<" . $shipping_day . "))"; //待支付(10)和待收货(30)
		$condition_sql = "";
		if ($user_id > 0) {
			$condition_sql = " user_id = '" . $user_id . "' and ";
		}
		if ($id > 0) {
			$condition_sql = " id = '" . $id . "' and ";
		}
		$condition_sql = $condition_sql . $condition;
		$field         = 'id,user_id,id,create_time,payment_time,delay_time,state';
		$order_list    = $this->table('__ORDER__')->field($field)->where($condition_sql)->select();
		// Language::read('refund');
		if (!empty($order_list) && is_array($order_list)) {
			foreach ($order_list as $k => $v) {
				$order_id              = $v['id']; //订单编号
				$order_state           = $v['state']; //订单状态
				$log_array             = array();
				$log_array['log_role'] = 'system';
				$log_array['log_time'] = time();
				$log_array['order_id'] = $order_id;
				switch ($order_state) {
				case $order_default:
					$order_time = $v['create_time']; //订单生成时间
					if (intval($order_time) < $day) {
						//超期时取消订单
						$state_info           = lang('order_max_day') . $order_cancel . lang('order_max_day_cancel');
						$log_array['log_msg'] = $state_info;
						$this->editOrderCancel($order_id, $log_array);
					}
					break;
				case $order_shipped:
					$order_time = $v['delay_time'];
					if (intval($order_time) < $shipping_day) {
						//超期时自动完成订单
						$state_info           = lang('order_max_day') . $order_confirm . lang('order_max_day_confirm');
						$log_array['log_msg'] = $state_info;
						$this->editOrderFinnsh($order_id, $log_array);
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
	 * @param int $order_id 订单编号
	 * @param	array	$log_array	订单记录信息
	 */
	public function editOrderCancel($order_id, $log_array) {
		$goods_list = $this->table('__ORDER_GOODS__')->field('order_id,goods_num,goods_id')->where(array('order_id' => $order_id))->select(); //订单商品
		if (!empty($goods_list) && is_array($goods_list)) {
			foreach ($goods_list as $k => $v) {
				$goods_id              = $v['goods_id'];
				$goods_num             = $v['goods_num'];
				$condition             = array();
				$condition['id']       = $goods_id;
				$condition['sale_num'] = array('egt', $goods_num);
				$data                  = array();
				$data['stock']       = array('exp', 'stock+' . $goods_num); //库存
				$data['sale_num']      = array('exp', 'sale_num-' . $goods_num); //销售记录
				$state                 = $this->table('__GOODS__')->where($condition)->update($data);
			}
			$order_cancel         = $this->getOrderState('order_cancel'); //订单状态0:已取消
			$order_array          = array();
			$order_array['state'] = $order_cancel;
			$model_order          = model('Order');
			$state                = $model_order->editOrder($order_array, array('id' => $order_id)); //更新订单
			if ($state) {
				$log_array['order_state'] = $order_array['state'];
				$state                    = $model_order->addOrderLog($log_array);
			}
			return $state;
		}
		return false;
	}
	/**
	 * 更新退款申请
	 * @param int $user_id 会员编号
	 * @param int $id 店铺编号
	 */
	public function editRefundConfirm($user_id = 0, $id = 0) {
		// Language::read('refund');
		$refund_confirm = $this->getMaxDay('refund_confirm'); //卖家不处理退款申请时按同意并弃货处理
		$day            = time() - $refund_confirm * 60 * 60 * 24;
		$condition      = " seller_state=1 and create_time<" . $day; //状态:1为待审核,2为同意,3为不同意
		$condition_sql  = "";
		if ($user_id > 0) {
			$condition_sql = " user_id = '" . $user_id . "'  and ";
		}
		if ($id > 0) {
			$condition_sql = " id = '" . $id . "' and ";
		}
		$condition_sql                  = $condition_sql . $condition;
		$refund_array                   = array();
		$refund_array['refund_state']   = '2'; //状态:1为处理中,2为待管理员处理,3为已完成
		$refund_array['seller_state']   = '2'; //卖家处理状态:1为待审核,2为同意,3为不同意
		$refund_array['return_type']    = '1'; //退货类型:1为不用退货,2为需要退货
		$refund_array['seller_time']    = time();
		$refund_array['seller_message'] = lang('order_max_day') . $refund_confirm . lang('order_day_refund');
		$this->table('__REFUND_RETURN__')->where($condition_sql)->update($refund_array);

		$return_confirm = $this->getMaxDay('return_confirm'); //卖家不处理收货时按弃货处理
		$day            = time() - $return_confirm * 60 * 60 * 24;
		$condition      = " seller_state=2 and goods_state=2 and return_type=2 and delay_time<" . $day; //物流状态:1为待发货,2为待收货,3为未收到,4为已收货
		$condition_sql  = "";
		if ($user_id > 0) {
			$condition_sql = " user_id = '" . $user_id . "'  and ";
		}
		if ($id > 0) {
			$condition_sql = " id = '" . $id . "' and ";
		}
		$condition_sql                  = $condition_sql . $condition;
		$refund_array                   = array();
		$refund_array['refund_state']   = '2'; //状态:1为处理中,2为待管理员处理,3为已完成
		$refund_array['return_type']    = '1'; //退货类型:1为不用退货,2为需要退货
		$refund_array['seller_message'] = lang('order_max_day') . $return_confirm . '天未处理收货，按弃货处理';
		$this->table('__REFUND_RETURN__')->where($condition_sql)->update($refund_array);
	}
	/**
	 * 自动收货完成订单
	 * @param int $order_id 订单编号
	 * @param	array	$log_array	订单记录信息
	 */
	public function editOrderFinnsh($order_id, $log_array = array()) {
		$field           = 'id,user_id,user_name,id,sn,amount,payment_code,state';
		$order           = $this->table('__ORDER__')->field($field)->where(array('id' => $order_id))->find();
		$order_shipped   = $this->getOrderState('order_shipped'); //订单状态30:已发货
		$order_completed = $this->getOrderState('order_completed'); //订单状态40:已收货
		if ($order['state'] == $order_shipped) {
			// 确认已经完成发货
			if (empty($log_array)) {
				$log_array['order_id'] = $order_id;
				$log_array['role']     = 'system';
				$log_array['msg']      = lang('order_completed');
				$log_array['time']     = time();
			}
			$state                        = true;
			$order_array                  = array();
			$order_array['finnshed_time'] = time();
			$order_array['state']         = $order_completed;
			$model_order                  = model('Order');
			$state                        = $model_order->editOrder($order_array, array('id' => $order_id)); //更新订单状态为已收货
			$log_array['order_state']     = $order_array['state'];
			if ($state) {
				$state = $model_order->addOrderLog($log_array);
			}
			// 订单处理记录信息
			return $state;
		} else {
			return false;
		}
	}
	/**
	 * 处理邀请的好友购买成功送优惠券的逻辑
	 * @datetime 2017-06-15T16:37:05+0800
	 * @author 韩文博
	 * @return   [type]
	 */
	// public function handleFriendBuied() {
	// 	 model('Message','Logic')->addVoucherSendMessage($user_id, $title, $body, $order_id)
	// }
    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelTrade($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>