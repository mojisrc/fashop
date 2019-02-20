<?php
/**
 * 拼团活动模型
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




class Group extends Model
{
	protected $softDelete = true;

	/**
	 * 列表
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGroupList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();

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
	public function getGroupCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->count();

		} else{
			return $this->where( $condition )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getGroupInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @return
	 */
	public function getGroupId( $condition = [] )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @return
	 */
	public function getGroupValue( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getGroupColumn( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setIncGroup( $condition = [], $field, $num = 1 )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @return
	 */
	public function setDecGroup( $condition = [], $field, $num = 1 )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertGroup( $insert = [] )
	{
		return $this->add( $insert ) ;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllGroup( $insert = [] )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateGroup( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiGroup( $update = [] )
	{
		return $this->editMulti( $update );
	}

	/**
	 * 删除
	 * @param   $condition

	 */
	public function delGroup( $condition = [] )
	{
        return $this->where( $condition )->del();
	}

	/**
	 * 状态描述
	 * @param   $update
	 */
	public function stateDesc( $data )
	{
		if( time() >= $data['start_time'] && time() <= $data['end_time'] ){
			$state_desc = '进行中';
		} elseif( time() < $data['start_time'] ){
			$state_desc = '未开始';

		} elseif( time() > $data['end_time'] ){
			$state_desc = '已结束';
		}

		if( $data['is_show'] == 0 ){
			$state_desc = '已失效';
		}
		$data['state_desc'] = $state_desc;
		return $data;
	}

}
