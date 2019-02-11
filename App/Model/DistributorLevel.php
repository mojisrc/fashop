<?php
/**
 * 分销员等级
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


class DistributorLevel extends Model
{
	protected $softDelete = true;

	protected $type
		= [
			'upgrade_rules' => 'json',
		];


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
	public function getDistributorLevelList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
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
	public function getDistributorLevelCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getDistributorLevelInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getDistributorLevelId( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getDistributorLevelValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getDistributorLevelColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setIncDistributorLevel( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setDecDistributorLevel( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertDistributorLevel( $insert = [] )
	{
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllDistributorLevel( $insert = [] )
	{
		return $this->saveAll( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function updateDistributorLevel( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function updateAllDistributorLevel( $update = [] )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 * @param   $condition_str
	 */
	public function delDistributorLevel( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->delete();
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelDistributorLevel( $condition = [] )
	{
		return $this->save( ['delete_time' => time()], $condition );
	}

}
