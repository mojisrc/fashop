<?php
/**
 * 订单支付记录模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;


class OrderPay extends Model
{
	protected $softDelete = true;

	public function addOrderPay( array $data )
	{
		return $this->add( $data );
	}

	public function editOrderPay( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function getOrderPayInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

}

?>