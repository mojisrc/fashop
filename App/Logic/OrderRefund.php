<?php
/**
 * 商品业务逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

class OrderRefund
{
	const order_no_need_lock = 1;
	const order_need_lock    = 2;
	const close              = 1;
	const unclose               = 0;
	const refuse             = 10;
	const agree              = 20;
	const complete           = 30;

	/**
	 * 获取退款列表后
	 * @date        2017-05-15
	 * @Author      作者
	 * @param       [数组]     $get  [传递的参数]
	 * @return      [数组]     $data [返回的参数]
	 */
	public function getOrderRefundList( $get )
	{
		$refund_model = model( 'OrderRefund' );
		$data         = [];
		$condition    = [];
		$keyword_type = ['order_sn', 'refund_sn', 'user_name', 'user_phone'];

        if( trim( $get['key'] ) != '' && in_array( $get['type'], $keyword_type ) ){
            $type             = $get['type'];
			$condition[$type] = ['like', '%'.$get['key'].'%'];
		}
		if( trim( $get['create_time_from'] ) != '' || trim( $get['create_time_to'] ) != '' ){
			$create_time_from = strtotime( trim( $get['create_time_from'] ) );
			$create_time_to   = strtotime( trim( $get['create_time_to'] ) );
			if( $create_time_from !== false || $create_time_to !== false ){
				$condition['create_time'] = ['time', [$create_time_from, $create_time_to]];
			}
		}

		if( $get['handle_state'] != '' ){
			$condition['handle_state'] = intval( $get['handle_state'] );
		}

		$order_lock = intval( $get['lock'] );
		if( $order_lock != 1 ){
			$order_lock = 2;
		}

		$order = 'create_time desc';
		if(isset($get['order_type'])){
            switch ($order) {
                case 1:
                    $order = 'create_time asc'; //申请时间早到晚
                    break;
                case 2:
                    $order = 'create_time desc';//申请时间晚到早
                    break;
            }
        }

		$condition['order_lock'] = $order_lock;
		// 分页
		$condition['refund_type'] = 1; //申请类型:1为仅退款,2为退货退款
		$count                    = $refund_model->where( $condition )->count();

		$Page         = new Page( $count, 10 );
		$page         = $get['page'] ? $get['page'].',10' : '1,10';

		$data['list'] = $refund_model->getOrderRefundList( $condition, '*', $order, $page );
		// $data['state_array'] = $refund_model->getOrderRefundStateArray('all');
		$data['page'] = $Page->show();
		return $data;
	}
}
