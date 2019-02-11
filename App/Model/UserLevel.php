<?php
/**
 * 用户级别数据模型
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


class UserLevel extends Model
{
	protected $softDelete = true;
	protected $createTime = true;


	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addUserLevel( $data = [] )
	{
		$data['create_time'] = time();
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addUserLevelAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editUserLevel( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delUserLevel( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getUserLevelCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取用户级别单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getUserLevelInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得用户级别列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getUserLevelList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	/**
	 * 获取用户级别单个值
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getUserLevelValue( $condition = [], $field = 'id' )
	{
		$info = $this->where( $condition )->value( $field, true );
		return $info;
	}

	/**
	 * 获取用户级别列
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getUserLevelColumn( $condition = [], $field = 'id' )
	{
		$info = $this->where( $condition )->column( $field );
		return $info;
	}
}

?>