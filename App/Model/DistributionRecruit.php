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
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getDistributionRecruitInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
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
	 * @param   $condition_str
	 */
	public function delDistributionRecruit( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->del();
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelDistributionRecruit( $condition = [] )
	{
		return $this->save( ['delete_time' => time()], $condition );
	}

}
