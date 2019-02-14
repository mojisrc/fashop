<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/6
 * Time: 上午10:31
 *
 */

namespace App\Logic;


class UserTemp
{
	/**
	 * 更新用户的消费情况
	 * @param int $user_id
	 * @return mixed
	 */
	public function updateCostInfo( int $user_id )
	{
		$find          = \App\Model\UserTemp::getUserTempInfo( ['user_id' => $user_id] );
		if( !$find ){
			\App\Model\UserTemp::init()->addUserTemp( ['user_id' => $user_id] );
		}
		$order_goods_db                      = db( 'OrderGoods' );
		$condition['order.state']            = ['>=', 20];
		$condition['order_goods.lock_state'] = 0;
		$condition['order.user_id']         = $user_id;

		$cost_price = $order_goods_db->alias( 'order_goods' )->where( $condition )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );

		$cost_times = $order_goods_db->alias( 'order_goods' )->where( $condition )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->count();

		$resent_cost_time = \App\Model\Order::init()->where( ['user_id' => $user_id] )->order( 'payment_time desc' )->value( 'payment_time' );

		$cost_average = sprintf( "%.2f", ($cost_price / $cost_times) );

		return \App\Model\UserTemp::init()->editUserTemp( ['user_id' => $user_id], [
			'cost_average_price' => $cost_average,
			'cost_times'         => $cost_price,
			'cost_price'         => $cost_times,
			'resent_cost_time'   => $resent_cost_time ? $resent_cost_time : null,
		] );
	}
}