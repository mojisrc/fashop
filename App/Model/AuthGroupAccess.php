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



class AuthGroupAccess extends Model
{
	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addAuthGroupAccess( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param $data
	 * @return bool
	 */
	public function addMultiAuthGroupAccess( $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
	 */
	public function editAuthGroupAccess( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delAuthGroupAccess( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getAuthGroupAccessInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得权限组角色列表
	 * @param array  $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getAuthGroupAccessList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>
