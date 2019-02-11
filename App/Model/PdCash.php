<?php
/**
 * 提现数据模型
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

class PdCash extends Model
{
	protected $softDelete = true;


	/**
	 * 取提现单信息总数
	 * @param array $condition
	 */
	public function getPdCashCount( $condition = [] )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 取得提现列表
	 * @param array  $condition
	 * @param string $page
	 * @param string $field
	 * @param string $order
	 */
	public function getPdCashList( $condition = [], $field = '*', $order = '', $page = '1,20' )
	{
		$data = $this->where( $condition )->field( $field )->order( $order )->page( $page )->select();
		return $data;
	}

	/**
	 * 添加提现记录
	 * @param array $data
	 */
	public function addPdCash( $data )
	{
		return $this->insertGetId( $data );
	}

	/**
	 * 编辑提现记录
	 * @param array $data
	 * @param array $condition
	 */
	public function editPdCash( $condition = [], $data )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 取得单条提现信息
	 * @param array  $condition
	 * @param string $field
	 */
	public function getPdCashInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 删除提现记录
	 * @param array $condition
	 */
	public function delPdCash( $condition )
	{
		return $this->where( $condition )->del();
	}

}
