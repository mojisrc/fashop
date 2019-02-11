<?php
/**
 * 收获地址数据模型
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

use ezswoole\Model;


class Address extends Model
{
	protected $softDelete = true;

	/**
	 * 取得买家默认收货地址
	 * @param    array $condition
	 * @return   array
	 */
	public function getDefaultAddressInfo( $condition = [], $field = '' )
	{
		$condition['is_default'] = 1;
		return $this->where( $condition )->field( $field )->find();
	}

	/**
	 * 获得某条收获地址的详情
	 * @param    array $condition
	 * @return   array
	 */
	public function getAddressInfo( $condition = [], $field = '' )
	{
		return $this->where( $condition )->field( $field )->find();
	}

	/**
	 * 获得收获地址列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $group
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getAddressList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		return $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
	}

	/**
	 * 新增地址
	 * @param    array $data
	 * @return   integer pk
	 */
	public function addAddress( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 更新地址信息
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editAddress( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除地址
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delAddress( $condition = [] )
	{
		return $this->where( $condition )->del();
	}
}
