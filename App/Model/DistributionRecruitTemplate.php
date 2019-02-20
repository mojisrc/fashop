<?php
/**
 * 分销招募计划模板
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




class DistributionRecruitTemplate extends Model
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
	public function getDistributionRecruitTemplateList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
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
	public function getDistributionRecruitTemplateCount( $condition = [], $distinct = '' )
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
	public function getDistributionRecruitTemplateInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertDistributionRecruitTemplate( $insert = [] )
	{
		return $this->add( $insert );
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function addMultiDistributionRecruitTemplate( $insert = [] )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateDistributionRecruitTemplate( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiDistributionRecruitTemplate( $update = [] )
	{
		return $this->editMulti( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 */
	public function delDistributionRecruitTemplate( $condition = [] )
	{
        return $this->where( $condition )->del();
	}

}
