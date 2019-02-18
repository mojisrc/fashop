<?php
/**
 * 订单商品数据模型
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


class OrderGoods extends Model
{
	protected $softDelete = true;
	protected $createTime = true;
	protected $jsonFields = ['goods_spec'];

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addOrderGoods( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addMultiOrderGoods( array $data )
	{
		return $this->addMulti( $data ,true);
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @param bool
	 */
	public function editOrderGoods( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delOrderGoods( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getOrderGoodsCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取订单商品单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getOrderGoodsInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得订单商品列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getOrderGoodsList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		if( $page == '' ){
			$list = $this->where( $condition )->order( $order )->field( $field )->select();

		} else{
			$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		}
		return $list;

	}

	/**
	 * 获得某字段的和
	 *
	 * @param array  $condition
	 * @param string $field
	 * @return boolean
	 */
	public function getOrderGoodsSum( $condition, $field )
	{
		return $this->where( $condition )->sum( $field );
	}


	/**
	 * 获取的id
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getOrderGoodsId( $condition = [] )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getOrderGoodsColumn( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiOrderGoods( $update = [] )
	{
		return $this->editMulti( $update );
	}

}

?>