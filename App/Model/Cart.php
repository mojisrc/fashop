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
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addCart( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addCartAll( $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editCart( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delCart( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @datetime 2018-01-30 20:26:18
	 * @param array $condition 条件
	 * @return int
	 */
	public function getCartCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取购物车单条数据
	 * @datetime 2018-01-30 20:26:18
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getCartInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得购物车列表
	 * @datetime 2018-01-30 20:26:18
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getCartList( $condition = [], $field = '*', $order = '', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateCart( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getCartValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getCartColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}
}

?>