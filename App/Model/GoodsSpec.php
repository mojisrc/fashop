<?php
/**
 * 规格管理
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



class GoodsSpec extends Model
{
	protected $softDelete = true;

	public function addGoodsSpec( array $data )
	{
		return $this->add( $data );
	}

	public function editGoodsSpec( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}


	public function delGoodsSpec( $condition = [] )
	{
		return $this->where( $condition )->del();
	}


	public function getGoodsSpecInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得商品规格列表
	 * @param array  $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getGoodsSpecList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>