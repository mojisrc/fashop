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
	 * 获得数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getOrderExtendCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 查询普通的数据和软删除的数据
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getWithTrashedOrderExtendList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1, 20], $group = '' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getWithTrashedOrderExtendCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->withTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->withTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 只查询软删除的数据
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getOnlyTrashedOrderExtendList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1, 20], $group = '' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data;
	}

	/**
	 * 只查询软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getOnlyTrashedOrderExtendCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->onlyTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->onlyTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
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
	 * 获得排除字段的信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getOrderExtendExcludeInfo( $condition = [], $condition_str = '', $exclude = '' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getWithTrashedOrderExtendInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的排除字段数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getWithTrashedOrderExtendExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 只查询软删除的数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getOnlyTrashedOrderExtendInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 只查询软删除的排除字段数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getOnlyTrashedOrderExtendExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getOrderExtendId( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getOrderExtendValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getOrderExtendColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setIncOrderExtend( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setDecOrderExtend( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertOrderExtend( $insert = [] )
	{
		return $this->add( $insert ) ;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllOrderExtend( $insert = [] )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function updateOrderExtend( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function updateAllOrderExtend( $update = [] )
	{
		return $this->editMulti( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 * @param   $condition_str
	 */
	public function delOrderExtend( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->del();
	}


}
