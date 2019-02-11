<?php
/**
 * 分销员
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


class Distributor extends Model
{
	protected $softDelete = true;
	protected $jsonFields = ['upgrade_rules'];

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
	public function getDistributorList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
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
	public function getDistributorCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->where( $condition_str )->count();
		} else{
			return $this->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 列表更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getDistributorMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'distributor' )->join( '__USER__ user', 'distributor.user_id = user.id', 'LEFT' )->join( '__USER__ invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'distributor' )->join( '__USER__ user', 'distributor.user_id = user.id', 'LEFT' )->join( '__USER__ invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}

		if( !$data ){
			return [];
		} else{
			$data = $data->toArray();

			foreach( $data as $key => $value ){
				$data[$key] = $this->stateDesc( $value );
			}

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
	public function getDistributorMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'distributor' )->join( '__USER__ user', 'distributor.user_id = user.id', 'LEFT' )->join( '__USER__ invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'distributor' )->join( '__USER__ user', 'distributor.user_id = user.id', 'LEFT' )->join( '__USER__ invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getDistributorInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 获得信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getDistributorMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'distributor' )->join( '__USER__ user', 'distributor.user_id = user.id', 'LEFT' )->join( '__USER__ invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getDistributorId( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getDistributorValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getDistributorColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setIncDistributor( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setDecDistributor( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertDistributor( $insert = [] )
	{
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllDistributor( $insert = [] )
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
	public function updateDistributor( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function updateAllDistributor( $update = [] )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 * @param   $condition_str
	 */
	public function delDistributor( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->del();
	}

	/**
	 * 软删除
	 * @param   $condition
	 */
	public function softDelDistributor( $condition = [] )
	{
		return $this->save( ['delete_time' => time()], $condition );
	}

	/**
	 * 状态描述
	 * @param   $update
	 */
	public function stateDesc( $data )
	{
		switch( intval( $data['state'] ) ){
		case 0:
			$state_desc = '待审核';
		break;
		case 1:
			$state_desc = '审核通过';
		break;
		case 2:
			$state_desc = '审核拒绝';
		break;
		}
		$data['state_desc'] = $state_desc;
		return $data;
	}
}
