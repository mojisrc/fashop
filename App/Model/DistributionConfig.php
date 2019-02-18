<?php
/**
 * 分销配置
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




class DistributionConfig extends Model
{
	protected $softDelete = true;
    protected $jsonFields = ['value'];
    protected $primaryKey = 'sign';

	/**
	 * 列表
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getDistributionConfigList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->where( $condition )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDistributionConfigInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @return
	 */
	public function getDistributionConfigValue( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getDistributionConfigColumn( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->column( $field );
	}


	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertDistributionConfig( $insert = [] )
	{
		return $this->add( $insert ) ;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllDistributionConfig( $insert = [] )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateDistributionConfig( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiDistributionConfig( $update = [] )
	{
        return $this->editMulti( $update );
	}

	/**
	 * 删除
	 * @param    array $condition
	 */
	public function delDistributionConfig( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

}
