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



//

class GoodsImage extends Model
{
	protected $createTime = true;


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
	 * todo alias 并且说明不需要————GOODS__
	 * 列表更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGoodsImageMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getGoodsImageMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

}

?>