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
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getDefaultAddressInfo( $condition = [], $field = '*' )
	{
		$condition['is_default'] = 1;
		return $this->where( $condition )->field( $field )->find();
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getAddressInfo( $condition = [], $field = '*' )
	{
		return $this->where( $condition )->field( $field )->find();
	}
	/**
	 * @param array  $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getAddressList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		return $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
	}
	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addAddress( array $data )
	{
		return $this->add( $data );
	}
	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
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
