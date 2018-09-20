<?php
/**
 * 订单管理
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
use App\Logic\Order as OrderLogic;

/**
 * 订单
 * Class Order
 * @package App\HttpController\Admin
 */
class Order extends Admin
{
	/**
	 * 订单列表
	 * @method GET | POST
	 * @param string $state_type     未付款'state_new', 已付款'state_pay', 已发货'state_send', 已完成'state_success', 已取消'state_cancel' 退款'state_refund' 为评价'state_unevaluate'
	 * @param array  $create_time    [开始时间,结束时间]
	 * @param string $feedback_state 维权状态：退款处理中 todo、退款结束 closed
	 * @param array  $user_id        用户id
	 * @param int    $is_print       1打印 0未打印
	 * @param string $keywords_type  商品名称goods_name 、订单号order_no、收货人姓名 receiver_name、收货人电话 receiver_phone、 快递单号courier_number
	 * @param string $keywords       关键词
	 * @param
	 */
	public function list()
	{
		$param = !empty( $this->post ) ? $this->post : $this->get;

		$orderLogic = new OrderLogic();

		if( isset( $param['create_time'] ) ){
			$orderLogic->createTime( $param['create_time'] );
		}
		if( isset( $param['state_type'] ) && $param['state_type']!='all' ){
			$orderLogic->stateType( $param['state_type'] );
		}

        if( isset( $param['user_ids'] ) && is_array($param['user_ids']) ){
            $user_ids = [];
            foreach ($param['user_ids'] as $key => $value) {
                $user_ids = array_merge($user_ids,model('User')->getUserAllIds($value));
            }
            $orderLogic->users( 'id', $user_ids );
        }

        if( isset( $param['is_print'] ) ){
			$orderLogic->print( $param['is_print'] );
		}

		if( isset( $param['keywords'] ) && isset( $param['keywords_type'] ) ){
			$orderLogic->keywords( $param['keywords_type'], $param['keywords'] );
		}

		if( isset( $param['feedback_state'] ) ){
			$orderLogic->feedback( $param['feedback_state'] );
		}

		$orderLogic->page( $this->getPageLimit() )->extend( [
			'order_goods',
			'order_extend',
			'user',
		] );

		$count = $orderLogic->count();
		$list  = $orderLogic->list();

		$this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );
	}

	/**
	 * 订单数量
	 * @method GET | POST
	 * @param array  $create_time    [开始时间,结束时间]
	 * @param string $feedback_state 维权状态：退款处理中 todo、退款结束 closed
	 * @param array  $user_id        用户id
	 * @param int    $is_print       1打印 0未打印
	 * @param string $keywords_type  商品名称goods_name 、订单号order_no、收货人姓名 receiver_name、收货人电话 receiver_phone、 快递单号courier_number
	 * @param string $keywords       关键词
	 * @param array  $state_types    状态集合，不需要的可以不填，减少浪费
	 * @param
	 */
	public function stateNum()
	{
		$param = !empty( $this->post ) ? $this->post : $this->get;

		$orderLogic = new OrderLogic();

		if( isset( $param['create_time'] ) ){
			$orderLogic->createTime( $param['create_time'] );
		}

		if( isset( $param['user_ids'] ) && is_array($param['user_ids']) ){
            $user_ids = [];
            foreach ($param['user_ids'] as $key => $value) {
                $user_ids = array_merge($user_ids,model('User')->getUserAllIds($value));
            }
            $orderLogic->users( 'id', $user_ids );
        }

		if( isset( $param['is_print'] ) ){
			$orderLogic->print( $param['is_print'] );
		}

		if( isset( $param['keywords'] ) && isset( $param['keywords_type'] ) ){
			$orderLogic->keywords( $param['keywords_type'], $param['keywords'] );
		}

		if( isset( $param['feedback_state'] ) ){
			$orderLogic->feedback( $param['feedback_state'] );
		}

		if( isset( $param['state_types'] ) ){

			if( in_array( 'state_new', $param['state_types'] ) ){
				$result['state_new'] = $orderLogic->stateType( 'state_new' )->count();
			}
			if( in_array( 'state_send', $param['state_types'] ) ){
				$result['state_send'] = $orderLogic->stateType( 'state_send' )->count();
			}
			if( in_array( 'state_success', $param['state_types'] ) ){
				$result['state_success'] = $orderLogic->stateType( 'state_success' )->count();
			}
			if( in_array( 'state_close', $param['state_types'] ) ){
				$result['state_close'] = $orderLogic->stateType( 'state_close' )->count();
			}
			if( in_array( 'state_unevaluate', $param['state_types'] ) ){
				$result['state_unevaluate'] = $orderLogic->stateType( 'state_unevaluate' )->count();
			}
			if( in_array( 'state_refund', $param['state_types'] ) ){
				$result['state_refund'] = $orderLogic->stateType( 'state_refund' )->count();
			}
			return $this->send( Code::success, $result );

		} else{
			$this->send( Code::param_error );
		}
	}

	/**
	 * 订单详情
	 * @method     GET
	 * @param int $id 订单ID
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Admin/Order.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$order_id        = $this->get['id'];
			$condition['id'] = $order_id;
			$order_info      = model( 'Order' )->getOrderInfo( $condition, '*', [
				'order_extend',
				'order_goods',
				'user',
			] );
			if( empty( $order_info ) ){
				$this->send( Code::error, [], '没有该订单' );
			} else{
				$log_list     = model( 'Order' )->getOrderLogList( ['order_id' => $order_id] );
				$refund_model = model( 'OrderRefund' );
				$return_list  = $refund_model->getOrderRefundList( ['order_id' => $order_id, 'refund_type' => 2] );
				$refund_list  = $refund_model->getOrderRefundList( ['order_id' => $order_id, 'refund_type' => 1] );
				$this->send( Code::success, [
					'info'        => $order_info,
					'order_log'   => $log_list,
					'return_list' => $return_list,
					'refund_list' => $refund_list,
				] );
			}
		}
	}

	/**
	 * 设置发货
	 * @method POST
	 * @param int    $id              订单id 必须
	 * @param string $remark          发货备注
	 * @param string $deliver_name    发货人
	 * @param string $deliver_phone   发货人电话
	 * @param string $deliver_address 发货人详细地址
	 * @param int    $express_id      物流公司id
	 * @param int    $need_express    是否需要物流
	 * @param string $tracking_no     物流单号
	 */
	public function setSend()
	{
		if( $this->validate( $this->post, 'Admin/Order.setSend' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$order_id = $this->post['id'];

			$order_info = model( 'Order' )->getOrderInfo( ['id' => $order_id], '*', [
				'order_extend',
				'order_goods',
			] );

			if( !$order_info ){
				return $this->send( Code::error, [], '未找到该订单' );
			}
			// 为了修改
			if( $order_info['state'] !== 20 && $order_info['state'] !== 30 ){
				return $this->send( Code::error, [], '非未发货状态'.$order_info['state'] );
			}

			if( $order_info['refund_state'] != 0 || $order_info['refund_state'] != 0 ){
				return $this->send( Code::error, [], '退款状态中不可设置发货' );
			}

			try{
				$order_model = model( 'Order' );
				$order_model->startTrans();
				$data                    = [];
				$data['deliver_name']    = $this->post['deliver_name'];
				$data['deliver_phone']   = $this->post['deliver_phone'];
				$data['deliver_address'] = $this->post['deliver_address'];
				$data['need_express']    = $this->post['need_express'];
				if( isset( $this->post['remark'] ) ){
					$data['remark'] = $this->post['remark'];
				}
				if( isset( $this->post['express_id'] ) ){
					$data['express_id'] = $this->post['express_id'];
				}
				if( isset( $this->post['tracking_no'] ) ){
					$data['tracking_no'] = $this->post['tracking_no'];
				}

				$now_time              = time();
				$data['tracking_time'] = $now_time;

				$condition['id'] = $order_id;
				$update          = $order_model->editOrderExtend( $condition, $data );
				if( !$update ){
					throw new \Exception( '修改失败' );
				}

				$data               = [];
				$data['state']      = OrderLogic::state_send;
				$data['delay_time'] = $now_time;
				$update             = $order_model->editOrder( $condition, $data );
				if( !$update ){
					$order_model->rollback();
					$this->send( Code::error, [], "订单状态修改失败" );
				} else{
					$order_model->commit();
					$user = $this->getRequestUser();
					$order_model->addOrderLog( [
						'user'     => $user['username'],
						'order_id' => $order_id,
						'role'     => 'seller',
						'msg'      => '发出了货物',
					] );
					$this->send( Code::success );
				}

			} catch( \Exception $e ){
				$order_model->rollback();
				$this->send( Code::error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 物流查询 根据快递100提供接口进行查询
	 * @method GET
	 * @param int    $express_id  物流公司ID
	 * @param string $tracking_no 物流单号
	 */
	public function logisticsQuery()
	{
		if( $this->validate( $this->get, 'Admin/Order.logisticsQuery' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$express_model = model( 'Express' );

			$kuaidi100_code = $express_model->getExpressValue( ['id' => $this->get['express_id']], 'kuaidi100_code' );

			if( empty( $kuaidi100_code ) ){
				$this->send( Code::param_error );
			} else{
				$nu = $this->get['tracking_no'];
				$this->send( Code::success, ['link' => "https://www.kuaidi100.com/chaxun?com={$kuaidi100_code}&nu={$nu}"] );
			}
		}
	}
}

?>