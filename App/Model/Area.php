<?php
/**
 * 地区数据模型
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

class Area extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addArea( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addAreaAll( array $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editArea( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delArea( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 获取地区单条数据
	 * @param array  $condition 条件
	 * @param string|array $field     字段
	 * @return array
	 */
	public function getAreaInfo( $condition = [], $field = '*' )
	{
		return $this->where( $condition )->field( $field )->find();
	}

	/**
	 * 获得地区列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getAreaList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		return $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
	}

	/**
	 * todo 废弃
	 * 获取id
	 * @param $condition
	 */
	public function getAreaId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * todo 废弃
	 * 获取某个字段
	 * @param   $condition
	 */
	public function getAreaValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * todo 废弃
	 * 获取某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getAreaColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}
}

?>