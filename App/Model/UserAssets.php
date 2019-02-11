<?php
/**
 * 用户资产模型
 */

namespace App\Model;

use ezswoole\Model;

class UserAssets extends Model
{
	protected $softDelete = true;

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
	public function getUserAssetsList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
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
	public function getUserAssetsCount( $condition = [], $condition_str = '', $distinct = '' )
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
	public function getWithTrashedUserAssetsList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
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
	public function getWithTrashedUserAssetsCount( $condition = [], $condition_str = '', $distinct = '' )
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
	public function getOnlyTrashedUserAssetsList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
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
	public function getOnlyTrashedUserAssetsCount( $condition = [], $condition_str = '', $distinct = '' )
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
	public function getUserAssetsInfo( $condition = [], $condition_str = '', $field = '*' )
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
	public function getUserAssetsExcludeInfo( $condition = [], $condition_str = '', $exclude = '' )
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
	public function getWithTrashedUserAssetsInfo( $condition = [], $condition_str = '', $field = '*' )
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
	public function getWithTrashedUserAssetsExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
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
	public function getOnlyTrashedUserAssetsInfo( $condition = [], $condition_str = '', $field = '*' )
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
	public function getOnlyTrashedUserAssetsExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
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
	public function getUserAssetsId( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getUserAssetsValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getUserAssetsColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setIncUserAssets( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setDecUserAssets( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertUserAssets( $insert = [] )
	{
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllUserAssets( $insert = [] )
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
	public function updateUserAssets( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function updateAllUserAssets( $update = [] )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 * @param   $condition_str
	 */
	public function delUserAssets( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->del();
	}

}
