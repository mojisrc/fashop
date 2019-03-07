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




class Distributor extends Model
{
	protected $softDelete = true;
	protected $jsonFields = ['upgrade_rules','message'];

	/**
	 * 列表
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getDistributorList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->where( $condition )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getDistributorCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->count();
		} else{
			return $this->where( $condition )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 列表更多
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getDistributorMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->join( 'user', 'distributor.user_id = user.id', 'LEFT' )->join( 'user AS invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->join( 'user', 'distributor.user_id = user.id', 'LEFT' )->join( 'user AS invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}

		if( !$data ){
			return [];
		} else{
			foreach( $data as $key => $value ){
				$data[$key] = $this->stateDesc( $value );
			}

		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getDistributorMoreCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->join( 'user', 'distributor.user_id = user.id', 'LEFT' )->join( 'user AS invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->count();

		} else{
			return $this->join( 'user', 'distributor.user_id = user.id', 'LEFT' )->join( 'user AS invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDistributorInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 获得信息更多
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDistributorMoreInfo( $condition = [], $field = '*' )
	{
		$data = $this->join( 'user', 'distributor.user_id = user.id', 'LEFT' )->join( 'user AS invite_user', 'distributor.inviter_id = invite_user.id', 'LEFT' )->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @return
	 */
	public function getDistributorId( $condition = [] )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @return
	 */
	public function getDistributorValue( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getDistributorColumn( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setIncDistributor( $condition = [], $field, $num = 1 )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @return
	 */
	public function setDecDistributor( $condition = [], $field, $num = 1 )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertDistributor( $insert = [] )
	{
		return $this->add( $insert );
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllDistributor( $insert = [] )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateDistributor( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiDistributor( $update = [] )
	{
		return $this->editMulti( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 */
	public function delDistributor( $condition = [] )
	{
		return $this->where( $condition )->del();
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
