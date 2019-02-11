<?php
/**
 * 权限组角色数据模型
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

class AuthGroupAccess extends Model
{


	/**
	 * 添加
	 * @datetime 2017-10-17 15:20:26
	 * @param  array $data
	 * @return int pk
	 */
	public function addAuthGroupAccess( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @datetime 2017-10-17 15:20:26
	 * @param array $data
	 * @return boolean
	 */
	public function addAuthGroupAccessAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-10-17 15:20:26
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editAuthGroupAccess( $condition = [], $data = [] )
	{
		return $this->edit( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-10-17 15:20:26
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delAuthGroupAccess( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @datetime 2017-10-17 15:20:26
	 * @param array $condition 条件
	 * @return int
	 */
	public function getAuthGroupAccessCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取权限组角色单条数据
	 * @datetime 2017-10-17 15:20:26
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getAuthGroupAccessInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得权限组角色列表
	 * @datetime 2017-10-17 15:20:26
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getAuthGroupAccessList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>
