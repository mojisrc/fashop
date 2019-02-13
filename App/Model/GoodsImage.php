<?php
/**
 * 商品图片数据模型
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

class GoodsImage extends Model
{
	protected $softDelete = true;
	public function addGoodsImage( array $data )
	{
		return $this->add( $data );
	}

	public function addMultiGoodsImage( $data )
	{
		return $this->addMulti( $data );
	}


	public function delGoodsImage( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 列表更多
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGoodsImageMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 20], $group = '' )
	{
		$data = $this->join( 'goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getGoodsImageMoreCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->join( 'goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->count();

		} else{
			return $this->join( 'goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->count( "DISTINCT ".$distinct );
		}
	}

}

?>