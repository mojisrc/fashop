<?php
/**
 * 限时折扣数据模型
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


class Discount extends Model
{
	protected $softDelete = true;

	protected $jsonFields = ['partake'];

	/**
	 * 列表
	 * @param         $condition
	 * @param         $field
	 * @param         $order
	 * @param  string $page
	 * @return             [列表数据]
	 */
	public function getDiscountList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $data;
	}

	/**
	 * 列表更多
	 * @param         $condition
	 * @param         $field
	 * @param         $order
	 * @param  string $page
	 * @return
	 */
	public function getDiscountMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->alias( 'xx1' )->join( '__XX2__ xx2', 'xx1.id = xx2.xx1_id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据
	 * @return
	 */
	public function getWithTrashedDiscountList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->withTrashed()->where( $condition )->order( $order )->field( $field )->page( $page )->select();  //查询普通的数据和软删除的数据
		return $data;
	}

	/**
	 * 只查询软删除的数据
	 * @return
	 */
	public function getOnlyTrashedDiscountList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->onlyTrashed()->where( $condition )->order( $order )->field( $field )->page( $page )->select(); //只查询软删除的
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDiscountCount( $condition = [] )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDiscounMoretCount( $condition = [] )
	{
		return $this->alias( 'xx1' )->join( '__XX2__ xx2', 'xx1.id = xx2.xx1_id', 'LEFT' )->where( $condition )->count();
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDiscountInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 修改数据
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateDiscount( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 *
	 * @param array $update 数据
	 */
	public function updateAllDiscount( $update )
	{
		return $this->editMulti( $update );
	}

	/**
	 * 加入单条数据
	 *
	 * @param array $insert 数据
	 */
	public function insertDiscount( $insert )
	{
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 加入多条数据
	 *
	 * @param array $insert 数据
	 */
	public function insertAllDiscount( $insert )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 删除
	 *
	 * @param array $insert 数据
	 */
	public function delDiscount( $condition )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @return
	 */
	public function getDiscountId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取的某个字段
	 * @param   $condition
	 * @return
	 */
	public function getDiscountValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取的某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getDiscountColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 获取的某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setIncDiscount( $condition, $field, $num )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 获取的某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setDecDiscount( $condition, $field, $num )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

}
