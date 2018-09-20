<?php
/**
 * 卖家退款
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2016 WenShuaiKeJi Inc. (http://www.wenshuai.cn)
 * @license    http://www.wenshuai.cn
 * @link       http://www.wenshuai.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use App\Logic\OrderRefund as RefundLogic;

/**
 * 退款退货
 * Class Orderrefund
 * @package App\HttpController\Admin
 */
class Orderrefund extends Admin
{
	/**
	 * 退款售后列表
	 * @method GET
	 * @param string $keywords_type 类型 商品名称goods_name 、订单号order_no、收货人姓名 receiver_name、收货人电话 receiver_phone、 退款编号refund_sn
	 * @param string $keywords      关键词
	 * @param array  $create_time   时间区间[开始时间戳,结束时间戳]
	 * @param int    $refund_type   申请类型:1为仅退款,2为退货退款
	 * @param int    $handle_state  退款状态 1申请退款，等待商家确认 2同意申请，等待买家退货 3买家已发货，等待收货  4已收货，确认退款 5退款成功 6退款关闭
	 * @param int    $order_type    排序 1申请时间早到晚  2申请时间晚到早
	 * @author   孙泉
	 */
	public function list()
	{
		$refundLogic = new \App\Logic\OrderRefundSearch( (array)$this->get );
        $refundLogic->page( $this->getPageLimit() );
		$this->send( Code::success, [
			'total_number' => $refundLogic->count(),
			'list'         => $refundLogic->list(),
		] );
	}

	/**
	 * 退款详情
	 * @method GET
	 * @param  int id 退款表id
	 * @author   孙泉
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Admin/OrderRefund.info' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$refund_model      = model( 'OrderRefund' );
			$row               = $refund_model->getOrderRefundInfo( ['id' => $this->get['id']] );
			$row['state_desc'] = $refund_model->getOrderRefundDesc( $row );
			$this->send( Code::success, ['info' => $row] );
		}
	}

	/**
	 * todo 封装logic
	 * 退款审核
	 * @method POST
	 * @param int    $id
	 * @param int    $handle_state   处理状态  10  20
	 * @param string $handle_message 处理信息
	 *                               由于采用的是可输入的退款金额，无退款商品数量，所以无法减销量和库存！！！
	 *                               handle_state 平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成) 50取消(用户主动撤销) 51取消(用户主动收货)
	 */
	public function handle()
	{
		if( $this->validate( $this->post, 'Admin/OrderRefund.handle' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			if( !in_array( $this->post['handle_state'], [RefundLogic::refuse, RefundLogic::agree] ) ){
				$this->send( Code::param_error, [], '未知handle_state' );
			} else{
				$refund_model = model( 'OrderRefund' );
				// 判断是否已经处理
				$refund = $refund_model->getOrderRefundInfo( ['id' => $this->post['id']] );
				if( $refund['handle_state'] == $this->post['handle_state'] ){
					$this->send( Code::param_error, [], "不可重复设置状态" );
				} else{
					$refund_model->startTrans();
					$order_goods_model = model( 'OrderGoods' );
					$order_model       = model( 'Order' );
					switch( $this->post['handle_state'] ){
					case  RefundLogic::refuse :
						// 更改退款状态
						$result = $refund_model->editOrderRefund( ['id' => $this->post['id']], [
							'handle_state'   => RefundLogic::refuse,
							'handle_time'    => time(),
							'handle_message' => isset( $this->post['handle_message'] ) ? $this->post['handle_message'] : null,
							'is_close'       => RefundLogic::close,
						] );
						if( !$result ){
							$refund_model->rollback();
							return $this->send( Code::error );
						}
						// 拒绝 ：恢复 商品的锁定状态，判断是否还需要锁定订单
						$order_goods_res = $order_goods_model->editOrderGoods( [
							'id'         => $refund['order_goods_id'],
							'lock_state' => 1,
						], [
							'lock_state'          => 0,
							'refund_handle_state' => RefundLogic::refuse,
							'refund_id'           => 0,
						] );
						// 子订单解锁
						if( !$order_goods_res ){
							$refund_model->rollback();
							return $this->send( Code::error, [], "退款订单商品的状态错误" );
						}
						// 该总订单下已锁定未关闭的退款记录，用处：判断是否解锁主订单状态
						$exist_lock = $refund_model->where( [
							'order_id' => $refund['order_id'],
							'is_close' => RefundLogic::unclose,
						] )->find();
						if( !$exist_lock ){
							// 解锁总订单
							$order_res = $order_model->editOrder( [
								'id'         => $refund['order_id'],
								'lock_state' => ['neq', 0],
							], [
								'lock_state'   => 0,
								'delay_time'   => time(),
								'refund_state' => 0 // 退款状态:0是无退款,1是部分退款,2是全部退款(2的状态v1没用到)
							] );
							if( !$order_res ){
								$refund_model->rollback();
								return $this->send( Code::error, [], "退款的主订单退款状态错误" );
							}
						}
						$refund_model->commit();
						$this->send( Code::success );
					break;
					case RefundLogic::agree :

						if($refund['refund_type'] == 2){
						    $refund_update_state = RefundLogic::agree;
                        }else{
                            $refund_update_state = RefundLogic::complete;
                        }

						// 判断金额是否大于 总商品价格 + 运费（统一运费或者运费模板））
						if( $refund['refund_amount'] > ($refund['goods_pay_price'] + $refund['goods_freight_fee']) ){
							return $this->send( Code::error, [], '退款金额不得大于可退金额' );
						}

						// 更改退款状态
						$result = $refund_model->editOrderRefund( ['id' => $this->post['id']], [
							'refund_amount'  => $refund['refund_amount'],
							'handle_state'   => $refund_update_state,
							'handle_time'    => time(),
							'handle_message' => isset( $this->post['handle_message'] ) ? $this->post['handle_message'] : null,
						] );

						if( !$result ){
							$refund_model->rollback();
							return $this->send( Code::error );
						}
						// 同意 ： 设置 refund_handle_state = 30 是因为我们v1版本采用用户自行去支付平台退款的方式，这儿的退款同意，仅为标记作用
						$order_goods_res = $order_goods_model->editOrderGoods( [
							'lock_state' => 1,
							'id'         => $refund['order_goods_id'],
						], [
							'refund_handle_state' => $refund_update_state,
						] );
						if( !$order_goods_res ){
							$refund_model->rollback();
							return $this->send( Code::error, [], "退款订单商品的状态错误" );
						}
						// 查询所有的子订单都是退款同意的，设置订单为all_agree_refound
						$order_goods_ids    = $order_goods_model->where( ['order_id' => $refund['order_id']] )->column( 'id' );
						$refund_goods_count = $order_goods_model->where( [
							'id'                  => ['in', $order_goods_ids],
							'order_id'            => $refund['order_id'],
							'refund_handle_state' => RefundLogic::complete,
							'lock_state'          => 1,
						] )->count( "DISTINCT id" );
						if( count( $order_goods_ids ) === $refund_goods_count ){
							$order_res = $order_model->editOrder( ['id' => $refund['order_id']], ['all_agree_refound' => 1] );
							if( !$order_res ){
								$refund_model->rollback();
								return $this->send( Code::error, [], "修改订单全退状态失败" );
							}
						}
						$refund_model->commit();
						$this->send( Code::success );
					break;
					default :
						$this->send( Code::param_error, [], '未知handle_state' );
					break;
					}
				}
			}

		}
	}

	/**
	 * 退款退货的订单 卖家确认收货(收到买家退回来的订单以后才能退款) 收到货退款完成 这版没有退款
	 * @method POST
	 * @param int id 退款id
	 */
	public function receive()
	{
		if( $this->validate( $this->post, 'Admin/OrderRefund.receive' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
            $refund_model               = model('OrderRefund');
            $condition                  = [];
            $condition['id']            = $this->post['id'];
            $condition['refund_type']   = 2;
            $condition['shipping_code'] = ['neq', null];
            $condition['receive']       = 1;
            $refund                     = $refund_model->getOrderRefundInfo(['id' => $this->post['id']]);
            if(!$refund){
                return $this->send( Code::error, [], "未查询到可收货的退款记录" );
            }else{
                $refund_model->startTrans();
                $order_goods_model   = model('OrderGoods');
                $order_model         = model('Order');

                $refund_update_state = RefundLogic::complete;

                // 更改退款状态
                $result = $refund_model->editOrderRefund( ['id' => $refund['id']], [
                    'handle_state'   => $refund_update_state,
                    'handle_time'    => time(),
                    'receive'      => 2,
                    'receive_time' => time(),
                ] );

                if( !$result ){
                    $refund_model->rollback();
                    return $this->send( Code::error );
                }
                // 同意 ： 设置 refund_handle_state = 30 是因为我们v1版本采用用户自行去支付平台退款的方式，这儿的退款同意，仅为标记作用
                $order_goods_res = $order_goods_model->editOrderGoods( [
                       'lock_state' => 1,
                       'id'         => $refund['order_goods_id'],
                   ], [
                       'refund_handle_state' => $refund_update_state,
                   ] );
                if( !$order_goods_res ){
                    $refund_model->rollback();
                    return $this->send( Code::error, [], "退款订单商品的状态错误" );
                }
                // 查询所有的子订单都是退款同意的，设置订单为all_agree_refound
                $order_goods_ids    = $order_goods_model->where( ['order_id' => $refund['order_id']] )->column( 'id' );
                $refund_goods_count = $order_goods_model->where( [
                     'id'                  => ['in', $order_goods_ids],
                     'order_id'            => $refund['order_id'],
                     'refund_handle_state' => $refund_update_state,
                     'lock_state'          => 1,
                 ] )->count( "DISTINCT id" );
                if( count( $order_goods_ids ) === $refund_goods_count ){
                    $order_res = $order_model->editOrder( ['id' => $refund['order_id']], ['all_agree_refound' => 1] );
                    if( !$order_res ){
                        $refund_model->rollback();
                        return $this->send( Code::error, [], "修改订单全退状态失败" );
                    }
                }
                $refund_model->commit();
                $this->send( Code::success );
            }
		}
	}

	/**
	 * todo 下个版本使用
	 * 余额支付退款
	 * refund_fee 退款总金额,单位为分,可以做部分退款
	 */
	private function predepositRefund( array $data )
	{
		$refund_model = model( 'OrderRefund' );
		$refund_model->startTrans();

		$order_goods_res = model( 'OrderGoods' )->editOrderGoods( ['id' => $data['order_goods_id']], ['refund_handle_state' => 30] );
		if( !$order_goods_res ){
			$refund_model->rollback();
			return $this->send( Code::error, [], '退款失败' );
		}


		$res = $refund_model->editOrderRefund( ['id' => $data['id']], [
			'handle_state' => 30,
			'success_time' => time(),
		] );
		if( !$res ){
			$refund_model->rollback();
			return $this->send( Code::error, [], '退款失败' );
		}

		$pd_log_model          = model( 'PdLog' );
		$log_data              = [];
		$log_data['user_id']   = $data['user_id'];
		$log_data['user_name'] = $data['user_name'];
		$log_data['amount']    = $data['refund_amount'];
		$log_data['state']     = 1;
		$log_data['pd_sn']     = $data['refund_sn'];
		$log_data['pd_id']     = $data['id'];
		$log_data['username']  = $data['user_name'];
		$pd_log_res            = $pd_log_model->changePd( 'refund', $log_data );
		if( !$pd_log_res ){
			$refund_model->rollback();
			return $this->send( Code::error, [], '退款失败' );
		} else{
			$refund_model->commit();
			$this->send( Code::success );
		}
	}
}
