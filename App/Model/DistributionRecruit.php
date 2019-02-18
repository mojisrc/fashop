<?php
/**
 * 分销招募计划
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




class DistributionRecruit extends Model
{
	protected $softDelete = true;
	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDistributionRecruitInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertDistributionRecruit( $insert = [] )
	{
		return $this->add( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateDistributionRecruit( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 */
	public function delDistributionRecruit( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

}
