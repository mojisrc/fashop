<?php
/**
 * 购物车数据模型
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

class Cart extends Model
{
	protected $createTime = true;
	protected $jsonFields = ['goods_spec'];

	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addCart( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
	 */
	public function editCart( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delCart( $condition = [] )
	{
		return $this->where( $condition )->del();
	}
	/**
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getCartInfo( $condition = [], $field = '*' )
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
	public function getCartList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

}

?>