<?php
/**
 * 限时折扣商品数据模型
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


class DiscountGoods extends Model
{
	protected $softDelete = true;

	/**
	 * 列表
	 * @param         $condition
	 * @param         $field
	 * @param         $order
	 * @param  string $page
	 * @return             [列表数据]
	 */
	public function getDiscountGoodsList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		if( $page == '' ){
			$data = $this->where( $condition )->order( $order )->field( $field )->select();

		} else{
			$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();

		}
		return $data;
	}

	/**
	 * 列表更多
	 * @param         $condition
	 * @param         $field
	 * @param         $order
	 * @param  string $page
	 * @return
	 */
	public function getDiscountGoodsMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->alias( 'discount_goods' )->join( '__GOODS__ goods', 'discount_goods.goods_id = goods.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据
	 * @return
	 */
	public function getWithTrashedDiscountGoodsList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->withTrashed()->where( $condition )->order( $order )->field( $field )->page( $page )->select();  //查询普通的数据和软删除的数据
		return $data;
	}

	/**
	 * 只查询软删除的数据
	 * @return
	 */
	public function getOnlyTrashedDiscountGoodsList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{
		$data = $this->onlyTrashed()->where( $condition )->order( $order )->field( $field )->page( $page )->select(); //只查询软删除的
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDiscountGoodsCount( $condition = [] )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDiscounGoodsMoretCount( $condition = [] )
	{
		return $this->alias( 'discount_goods' )->join( '__GOODS__ goods', 'discount_goods.goods_id = goods.id', 'LEFT' )->where( $condition )->count();
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDiscountGoodsInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateDiscountGoods( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 *
	 * @param array $update 数据
	 */
	public function updateAllDiscountGoods( $update )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 加入单条数据
	 *
	 * @param array $insert 数据
	 */
	public function insertDiscountGoods( $insert )
	{
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 加入多条数据
	 *
	 * @param array $insert 数据
	 */
	public function insertAllDiscountGoods( $insert )
	{
		return $this->saveAll( $insert );
	}

	/**
	 * 删除
	 *
	 * @param array $insert 数据
	 */
	public function delDiscountGoods( $condition )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @return
	 */
	public function getDiscountGoodsId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取的某个字段
	 * @param   $condition
	 * @return
	 */
	public function getDiscountGoodsValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取的某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getDiscountGoodsColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 获取的某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setIncDiscountGoods( $condition, $field, $num )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 获取的某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setDecDiscountGoods( $condition, $field, $num )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}



	/**
	 * 获得商品sku列表
	 * @param         $condition
	 * @param         $field
	 * @param         $order
	 * @param  string $page
	 * @return
	 */
	public function getGoodsSkuMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20] )
	{

		if( $page == '' ){
			$data = $this->alias( 'goods_sku' )->join( '__DISCOUNT_GOODS__ discount_goods', 'goods_sku.id = discount_goods.goods_sku_id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->select();

		} else{
			$data = $this->alias( 'goods_sku' )->join( '__DISCOUNT_GOODS__ discount_goods', 'goods_sku.id = discount_goods.goods_sku_id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->select();

		}

		return $data;
	}


	/**
	 * 获得商品sku数量
	 * @param   $condition
	 * @return
	 */
	public function getGoodsSkuMoreCount( $condition = [] )
	{
		return $this->alias( 'goods_sku' )->join( '__DISCOUNT_GOODS__ discount_goods', 'goods_sku.id = discount_goods.goods_sku_id', 'LEFT' )->where( $condition )->count();

	}

}
