<?php
/**
 * 权限角色数据模型
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

class AuthGroup extends Model
{

	protected $type
		= [
			'rule_ids' => 'array',
		];

	/**
	 * 添加
	 * @datetime 2017-10-17 15:19:34
	 * @param  array $data
	 * @return int pk
	 */
	public function addAuthGroup( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @datetime 2017-10-17 15:19:34
	 * @param array $data
	 * @return boolean
	 */
	public function addAuthGroupAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-10-17 15:19:34
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editAuthGroup( $condition = [], $data = [] )
	{
		return $this->edit( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-10-17 15:19:34
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delAuthGroup( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @datetime 2017-10-17 15:19:34
	 * @param array $condition 条件
	 * @return int
	 */
	public function getAuthGroupCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取权限角色单条数据
	 * @datetime 2017-10-17 15:19:34
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getAuthGroupInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得权限角色列表
	 * @datetime 2017-10-17 15:19:34
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getAuthGroupList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>