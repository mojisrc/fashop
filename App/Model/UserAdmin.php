<?php
/**
 * 管理员
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



class UserAdmin extends Model
{
	protected $createTime = true;
	protected $softDelete = true;
	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addUserAdmin( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
	 */
	public function editUserAdmin( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delUserAdmin( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 获取权限角色单条数据
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getUserAdminInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getUserAdminList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>