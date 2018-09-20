<?php
/**
 * 买家退款\退款退
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

class Orderrefund extends Server
{
	/**
	 * 退款原因
	 * @method GET
	 * @param int refund_type 1为仅退款,2为退货退款
	 * @author 韩文博
	 */
	public function reasonList()
	{
		if( !isset( $this->get['refund_type'] ) || !in_array( $this->get['refund_type'], [1, 2] ) ){
			$this->send( Code::param_error );
		} else{
			$list = model( 'OrderRefundReason' )->getOrderRefundReasonList( [
				'type' => $this->get['refund_type'],
			], '*', 'id asc', '1,1000' );
			$this->send( Code::success, [
				'list' => $list,
			] );
		}
	}

	/**
	 * 申请商品退款
	 * @method POST
	 * @param int    $order_goods_id 子订单ID 必需
	 * @param int    $refund_type    1为仅退款,2为退货退款 必需
	 * @param string $reason         退款原因 必须
	 * @param float  $refund_amount  退款的金额 必需
	 * @param string $user_explain   退款说明 非必需
	 * @param array  $images         照片凭证 非必须 最多三张
	 * @param int    $user_receive  用户选择是否收到货物 默认0未发货(Order state=20) 1未收到货 2已收到货 卖家未发货(已付款)时无需传此参数
	 * @author 孙泉
	 *
	 */
	public function apply()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validate( $this->post, 'Server/OrderRefund.apply' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				try{
					$user                  = $this->getRequestUser();
					$this->post['user_id'] = $user['id'];
					$refound_logic         = new \App\Logic\Server\OrderRefund( (array)$this->post );
					$result                = $refound_logic->create();
					if( $result === true ){
						$this->send( Code::success );
					} else{
						$this->send( Code::error );
					}
				} catch( \Exception $e ){
					$this->send( Code::error, [], $e->getMessage() );
				}
			}
		}
	}

	/**
	 * 退款记录
	 * @method GET
	 * @param int    $page
	 * @param int    $rows
	 * @param string $keywords      关键字
	 * @param string $keywords_type 类型order_sn，refund_sn，goods_title
	 * @param array  $create_time   start 开始时间 end 结束时间
     * @param array $ids          id数组
     * @author 孙泉
	 */
	public function list()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user                 = $this->getRequestUser();
			$refund_model         = model( 'OrderRefund' );
			$condition['user_id'] = ['in', model('User')->getUserAllIds($user['id'])];
			$keyword_type         = ['order_sn', 'refund_sn', 'goods_title'];
			if( isset( $this->get['keywords'] ) && trim( $this->get['keywords'] ) != '' && in_array( $this->get['keywords_type'], $keyword_type ) ){
				$type             = $this->get['keywords_type'];
				$condition[$type] = ['like', '%'.$this->get['keywords'].'%'];
			}
			if( isset( $this->get['create_time'] ) ){
				$condition['create_time'] = ['between', $this->get['create_time'],];
			}
            if(isset($get['ids']) && is_array($get['ids'])){
                $condition['id'] = ['in', $get['ids']];
            }

			$count       = $refund_model->where( $condition )->count();
			$refund_list = $refund_model->getOrderRefundList( $condition, '*', 'id desc', $this->getPageLimit() );
			$this->send( Code::success, [
				'list'         => $refund_list ? $refund_list : [],
				'total_number' => $count,
			] );
		}
	}

	/**
	 * 退款记录详情
	 * @method GET
	 * @param int id 退款列表里的id
	 * @author 孙泉
	 */
	public function info()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user = $this->getRequestUser();
			if( !isset( $this->get['id'] ) ){
				$this->send( Code::param_error );
			} else{
				$info = model( 'OrderRefund' )->getOrderRefundInfo( [
					'id'      => intval( $this->get['id'] ),
					'user_id' => ['in', model('User')->getUserAllIds($user['id'])],
				] );
				$this->send( Code::success, ['info' => $info] );
			}
		}
	}

	/**
	 * 添加退货快递单号，只有管理员审核通过(handle_state为20)的退款退货才可以填写订单号
	 * @method   post
	 * @param  int    $id               退款记录id
	 * @param  string $tracking_company 物流公司
	 * @param  int    $tracking_no      物流单号
	 * @param  string $tracking_phone   手机号
	 * @param  string $tracking_explain 说明 非必须
	 * @param  string $tracking_images  凭证 最多6张
	 * @author 孙泉
	 */
	public function setTrackingNo()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validate( $this->post, 'Server/OrderRefund.setTrackingNo' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				$user                  = $this->getRequestUser();
				$order_refund_model    = model( 'OrderRefund' );
				$condition['id']       = $this->post['id'];
				$condition['user_id']  = ['in', model('User')->getUserAllIds($user['id'])];
				$condition['is_close'] = 0;

                $update['tracking_company'] = $this->post['tracking_company'];
                $update['tracking_no']      = $this->post['tracking_no'];
                $update['tracking_phone']   = $this->post['tracking_phone'];
                $update['tracking_time']    = time();

				//说明
				if( isset( $this->post['tracking_explain'] ) ){
					$update['tracking_explain'] = $this->post['tracking_explain'];
				}

				// 照片凭证 非必须 最多6张
				if( !empty( $this->post['tracking_images'] ) ){
					if( count( $this->post['tracking_images'] ) > 6 ){
						return $this->send( Code::error, [], '最多6张凭证' );
					} else{
						$update['tracking_images'] = $this->post['tracking_images'];
					}
				}

				$refund_data = $order_refund_model->getOrderRefundInfo( $condition, 'handle_state,refund_type' );
				if( !$refund_data ){
					return $this->send( Code::error, [], '退款信息不存在' );

				}
				if( (int)$refund_data['handle_state'] != 20 ){
					return $this->send( Code::error, [], '管理员审核通过才可以填写订单号' );
				}
				if( (int)$refund_data['refund_type'] != 2 ){
					return $this->send( Code::error, [], '退货退款类型才可以填写订单号' );
				}
				$order_res = $order_refund_model->editOrderRefund( $condition, $update );
				if( !$order_res ){
					return $this->send( Code::error, [], '添加物流单号失败' );
				}
				$this->send( Code::success );
			}
		}
	}

	/**
	 * 撤销退款
	 * @method POST
	 * @param int id 退款表id
	 * @author 孙泉
	 * handle_state 平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成) 50取消(用户主动撤销) 51取消(用户主动收货)
	 */
	public function revoke()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validate( $this->post, 'Server/OrderRefund.revoke' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				$refund_model      = model( 'OrderRefund' );
				$order_goods_model = model( 'OrderGoods' );
				$order_model       = model( 'Order' );
				$refund            = $refund_model->getOrderRefundInfo( ['id' => $this->post['id']] );
				// 只有未处理的可以撤销退款
				if( $refund['handle_state'] != 0 ){
					return $this->send( Code::error, [], '只有未处理的可以撤销退款' );
				} else{
					$order_id = $refund['order_id'];
					$refund_model->startTrans();
					$refund_res = $refund_model->editOrderRefund( ['id' => $this->post['id']], [
						'handle_time'    => time(),
						'handle_message' => '用户撤销退款申请',
						'is_close'       => 1,   //此退款关闭
						'order_lock'     => 1,   //锁定类型:1为不用锁定,2为需要锁定
						'handle_state'   => 50,  //平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成) 50取消(用户主动撤销) 51取消(用户主动收货)
					] );
					if( !$refund_res ){
						$refund_model->rollback();
						return $this->send( Code::error, [], '撤销失败' );
					}
					// 更改订单状态 解锁 子订单解锁
					$order_goods_res = $order_goods_model->editOrderGoods( [
						'lock_state' => 1,
						'id'         => $refund['order_goods_id'],
					], [
						'lock_state'          => 0,
						'refund_handle_state' => 50,
						'refund_id'           => 0,

					] );

					if( !$order_goods_res ){
						$refund_model->rollback();
						return $this->send( Code::error );
					}
					$have_lock = $refund_model->where( [
						'order_id'   => $order_id,
						'order_lock' => 2,
						'is_close'   => 0,
					] )->find();
					//该总订单下已锁定未关闭的退款记录
					if( !$have_lock ){
						//没有代表总订单可以解锁
						$order_res = $order_model->editOrder( [
							'id'         => $order_id,
							'lock_state' => ['egt', 1],
						], [
							'refund_state' => 0,//退款状态:0是无退款,1是部分退款,2是全部退款
							'lock_state'   => 0,
							'delay_time'   => time(),
						] );
						if( !$order_res ){
							$refund_model->rollback();
							return $this->send( Code::error );
						}
					}
					$refund_model->commit();
					$this->send( Code::success );
				}
			}
		}
	}

}
