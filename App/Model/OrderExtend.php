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

	/**
	 * 列表
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getOrderExtendList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1, 20], $group = '' )
	{
		if( $page ){
			$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getOrderExtendInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}


	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function addOrderExtend( $insert = [] )
	{
		return $this->add( $insert );
	}


}
