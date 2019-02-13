<?php
/**
 * 满减优惠数据模型
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




class Fullcut extends Model
{
	protected $softDelete = true;

	protected $jsonFields = [
		'partake',
		//层级 至多5个,每个(包涵fll_price满XXX元,minus减XXX元,discountsXXX折,type满减类型 默认0减XXX元  1打XXX折)
		'hierarchy'
	];

	/**
	 * 列表
	 * @param         $condition
	 * @param         $field
	 * @param         $order
	 * @param  string $page
	 * @return             [列表数据]
	 */
	public function getFullcutList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $data;
	}


	/**
	 * 查询普通的数据和软删除的数据
	 * @return
	 */
	public function getWithTrashedFullcutList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->withTrashed()->where( $condition )->order( $order )->field( $field )->page( $page )->select();  //查询普通的数据和软删除的数据
		return $data;
	}

	/**
	 * 只查询软删除的数据
	 * @return
	 */
	public function getOnlyTrashedFullcutList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
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
	public function getFullcutCount( $condition = [] )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getFullcutInfo( $condition = [], $field = '*' )
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
	public function updateFullcut( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 *
	 * @param array $update 数据
	 */
	public function editMultiFullcut( $update )
	{
		return $this->editMulti( $update );
	}

	/**
	 * 加入单条数据
	 *
	 * @param array $insert 数据
	 */
	public function insertFullcut( $insert )
	{
		return $this->add( $insert );
	}

	/**
	 * 加入多条数据
	 *
	 * @param array $insert 数据
	 */
	public function insertAllFullcut( $insert )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 删除
	 *
	 * @param array $insert 数据
	 */
	public function delFullcut( $condition )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @return
	 */
	public function getFullcutId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取的某个字段
	 * @param   $condition
	 * @return
	 */
	public function getFullcutValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取的某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getFullcutColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 获取的某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setIncFullcut( $condition, $field, $num )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 获取的某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setDecFullcut( $condition, $field, $num )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

}
