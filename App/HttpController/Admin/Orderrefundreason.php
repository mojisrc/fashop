<?php

namespace App\HttpController\Admin;
use App\Utils\Code;
/**
 * 退款\退款退货原因控制器
 */
class Orderrefundreason extends Admin
{
	/**
	 * 退款\退款退货原因列表
	 * @method GET
	 * @param int type  1未收到货 2已收到货
	 * @param int page 页数
	 * @param int rows 条数
	 */
	public function index()
	{
		$condition = [];
		$get       = $this->get;

		if( $get['type'] != '' )
			$condition['type'] = $get['type']; //1未收到货 1已收到货

		//分页
		$count = \App\Model\OrderRefundReason::init()->where( $condition )->count();
		$field = '*';
		$order = 'id desc';
		$list  = \App\Model\OrderRefundReason::getOrderRefundReasonList( $condition, $field, $order, $this->getPageLimit() );

		$result                 = [];
		$result['total_number'] = $count;
		$result['list']         = $list;
		return $this->send( Code::success, $result, 'SUCCESS' );
	}

	/**
	 * 添加
	 * @method POST
	 * @param title 标题
	 * @param type  1未收到货 2已收到货
	 */
	public function add()
	{
		if( $this->post ){
			$post = $this->post;
			if( !$post['title'] ){
				return $this->send( Code::error );
			}
			if( !$post['type'] ){
				return $this->send( Code::error );

			}
			$insert = $post;
			$id     = \App\Model\OrderRefundReason::insertOrderRefundReason( $insert );
			if( !$id ){
				return $this->send( Code::error );

			}

			//记录行为
			action_log( 'update_order_refund_reason', 'order_refund_reason', $id, $this->user['id'] );
			return $this->send( Code::success );
		}
	}

	/**
	 * 详情
	 * @method GET
	 * @param id
	 */
	public function detail()
	{
		$get = $this->get;
		if( !$get['id'] ){
			return $this->send( Code::error );
		}
		$condition       = [];
		$condition['id'] = $get['id'];
		$field           = '*';
		$row             = \App\Model\OrderRefundReason::getOrderRefundReasonInfo( $condition, $field );


		$result         = [];
		$result['info'] = $row;
		return $this->send( Code::success, $result, 'SUCCESS' );

	}

	/**
	 * 修改
	 * @method POST
	 * @param id
	 * @param title 标题
	 * @param type  1未收到货 2已收到货
	 */
	public function edit()
	{
		if( $this->post ){
			$post = $this->post;
			if( !$post['id'] ){
				return $this->send( Code::error );
			}

			if( !$post['title'] ){
				return $this->send( Code::error );
			}
			if( !$post['type'] ){
				return $this->send( Code::error );
			}
			$condition['id'] = $post['id'];
			$update          = $post;
			unset( $update['id'] );

			$result = \App\Model\OrderRefundReason::init()->editOrderRefundReason( $update, $condition );
			if( !$result ){
				return $this->send( Code::error );

			}
			//记录行为
			action_log( 'update_order_refund_reason', 'order_refund_reason', $post['id'], $this->user['id'] );
			return $this->send( Code::success );
		}
	}

	/**
	 * 删除
	 * @method GET
	 * @param id
	 */
	public function del()
	{
		$post = $this->post;
		if( !$get['id'] ){
			return $this->send( Code::param_error );
		}

		$condition       = [];
		$condition['id'] = $post['id'];

		$result = \App\Model\OrderRefundReason::init()->delOrderRefundReason( $condition );
		if( !$result ){
			return $this->send( Code::error );

		}
		//记录行为
		action_log( 'update_order_refund_reason', 'order_refund_reason', $post['id'], $this->user['id'] );
		return $this->send( Code::success );
	}
}

?>