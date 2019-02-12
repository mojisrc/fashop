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

use App\Logic\OrderRefund as RefundLogic;
use App\Utils\Code;

/**
 * 退款退货
 * Class Orderrefund
 * @package App\HttpController\Admin
 */
class Orderrefund extends Admin
{
	/**
	 * TODO order_type 换成 sort_type
	 * 退款售后列表
	 * @method GET
	 * @param string $keywords_type 类型 商品名称goods_name 、订单号order_no、收货人姓名 receiver_name、收货人电话 receiver_phone、 退款编号refund_sn
	 * @param string $keywords      关键词
	 * @param array  $create_time   时间区间[开始时间戳,结束时间戳]
	 * @param int    $refund_type   申请类型:1为仅退款,2为退货退款
	 * @param int    $refund_state  退款状态 1 申请退款，等待商家确认 2同意申请，等待买家退货 3买家已发货，等待收货  4已收货，确认退款 5退款成功 6退款关闭 7同意退款，仅退款 8拒绝(驳回)
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
			$row               = \App\Model\OrderRefund::getOrderRefundInfo( ['id' => $this->get['id']] );
			$row['state_desc'] = \App\Model\OrderRefund::getOrderRefundDesc( $row );
			$this->send( Code::success, ['info' => $row] );
		}
	}

	/**
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
				// 判断是否已经处理
				$refund = \App\Model\OrderRefund::getOrderRefundInfo( ['id' => $this->post['id']] );
				if( !$refund ){
					return $this->send( Code::param_error, [], "查询退款信息失败" );
				} else{
					if( $refund['handle_state'] == $this->post['handle_state'] ){
						return $this->send( Code::param_error, [], "不可重复设置状态" );
					} else{
						try{
							$refund_logic = new RefundLogic();
							$refund_logic->handle( $refund, (array)$this->post );
							return $this->send( Code::success );
						} catch( \Exception $e ){
							return $this->send( Code::error, [], $e->getMessage() );
						}
					}
				}
			}
		}
	}

	/**
	 * 退款退货的订单 卖家确认收货
	 * @method POST
	 * @param int id 退款id
	 */
	public function receive()
	{
		if( $this->validate( $this->post, 'Admin/OrderRefund.receive' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$condition                = [];
			$condition['id']          = $this->post['id'];
			$condition['refund_type'] = 2;
			$condition['tracking_no'] = ['neq', null];
			$condition['receive']     = 1;
			$refund                   = \App\Model\OrderRefund::getOrderRefundInfo( ['id' => $this->post['id']] );
			if( !$refund ){
				return $this->send( Code::error, [], "未查询到可收货的退款记录" );
			} else{
				\App\Model\OrderRefund::startTrans();
				$result = \App\Model\OrderRefund::editOrderRefund( ['id' => $refund['id']], [
					'receive'      => 2,
					'receive_time' => time(),
				] );

				if( !$result ){
					\App\Model\OrderRefund::rollback();
					return $this->send( Code::error );
				}

				\App\Model\OrderRefund::commit();
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
		\App\Model\OrderRefund::startTrans();

		$order_goods_res = model( 'OrderGoods' )->editOrderGoods( ['id' => $data['order_goods_id']], ['refund_handle_state' => 30] );
		if( !$order_goods_res ){
			\App\Model\OrderRefund::rollback();
			return $this->send( Code::error, [], '退款失败' );
		}


		$res = \App\Model\OrderRefund::editOrderRefund( ['id' => $data['id']], [
			'handle_state' => 30,
			'success_time' => time(),
		] );
		if( !$res ){
			\App\Model\OrderRefund::rollback();
			return $this->send( Code::error, [], '退款失败' );
		}

		$log_data              = [];
		$log_data['user_id']   = $data['user_id'];
		$log_data['user_name'] = $data['user_name'];
		$log_data['amount']    = $data['refund_amount'];
		$log_data['state']     = 1;
		$log_data['pd_sn']     = $data['refund_sn'];
		$log_data['pd_id']     = $data['id'];
		$log_data['username']  = $data['user_name'];
		$pd_log_res            = \App\Model\PdLog::changePd( 'refund', $log_data );
		if( !$pd_log_res ){
			\App\Model\OrderRefund::rollback();
			return $this->send( Code::error, [], '退款失败' );
		} else{
			\App\Model\OrderRefund::commit();
			$this->send( Code::success );
		}
	}

	/**
	 * 退款操作 原路返回
	 * @method POST
	 * @param int $id
	 */
	public function refund()
	{
		if( $this->validate( $this->post, 'Admin/OrderRefund.refund' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$condition['id']           = $this->post['id'];
			$condition['handle_state'] = 20;
			$condition['is_close']     = 0;
			$refund                    = \App\Model\OrderRefund::getOrderRefundInfo( $condition );
			if( !$refund ){
				return $this->send( Code::param_error, [], "查询退款信息失败" );
			} else{
				try{
					$refund_logic = new RefundLogic();
					$refund_logic->refund( $refund );
					return $this->send( Code::success );
				} catch( \Exception $e ){
					return $this->send( Code::error, [], $e->getMessage() );
				}
			}

		}
	}

}
