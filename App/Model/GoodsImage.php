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
	 * todo废弃
	 * 列表更多
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGoodsImageList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 20] )
	{
		$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $data;
	}

}

?>