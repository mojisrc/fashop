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

class AuthGroupPolicy extends Model
{
	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addAuthGroupPolicy( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delAuthGroupPolicy( $condition = [] )
	{
		return $this->where( $condition )->del();
	}
}

?>
