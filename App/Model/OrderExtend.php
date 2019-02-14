<?php
/**
 * 订单模型
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


class OrderExtend extends Model
{
	protected $softDelete = true;
	protected $jsonFields = ['reciver_info', 'invoice_info'];


	public function getOrderExtendList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 20] )
	{
		$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $data;
	}

	public function editOrderExtend( $condition, $data )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function addOrderExtend( $data )
	{
		return $this->add( $data );
	}


	public function getOrderExtendInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}


}
