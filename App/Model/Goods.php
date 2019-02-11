<?php
/**
 * 商品主表数据模型
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

//

class Goods extends Model
{
	//	protected $softDelete = true;
	protected $createTime = true;


	protected $jsonFields
		= [
			'category_ids',
			'sku_list',
			'images',
			'body',
			'spec_list',
			'image_spec_images',
		];
	const STATE1 = 1; // 出售中
	const STATE0 = 0; // 下架

	/**
	 * 新增商品数据
	 * @param array $insert 数据
	 * @return integer pk
	 */
	public function addGoods( $data )
	{
		return $this->add( $data );
	}

	/**
	 * 新增多条商品数据
	 * @param array $insert
	 * @return bool
	 */
	public function addGoodsAll( $insert )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 商品列表
	 * @param array  $condition 条件
	 * @param array  $field     字段
	 * @param string $page      分页
	 * @param string $order     排序
	 * @return array
	 */
	public function getGoodsList( $condition, $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		if( $page ){
			$list = $this->where( $condition )->order( $order )->field( $field )->select();
		} else{
			$list = $this->where( $condition )->field( $field )->order( $order )->page( $page )->select();
		}

		return $list ?? [];
	}

	/**
	 * 出售中的商品列表
	 * @param array  $condition 条件
	 * @param array  $field     字段
	 * @param string $page      分页
	 * @param string $order     排序
	 * @return array
	 */
	public function getGoodsOnlineList( $condition, $field = '*', $order = "id desc", $page = [1,10] )
	{
		$condition['is_on_sale'] = self::STATE1;

		return $this->getGoodsList( $condition, $field, $order, $page );
	}

	/**
	 * 仓库中的商品列表
	 * @param array  $condition 条件
	 * @param array  $field     字段
	 * @param string $page      分页
	 * @param string $order     排序
	 * @return array
	 */
	public function getGoodsOfflineList( $condition, $field = '*', $order = "id desc", $page = [1,10] )
	{
		$condition['is_on_sale'] = self::STATE0;
		return $this->getGoodsList( $condition, $field, $order, $page );
	}

	/**
	 * 计算商品库存
	 * @param array $goods_list
	 * @return array|boolean
	 */
	public function calculateStorage( $goods_list, $stock_alarm = 0 )
	{
		// 计算库存
		if( !empty( $goods_list ) ){
			foreach( $goods_list as $value ){
				$goodscommonid_array[] = $value['id'];
			}
			$stock       = model( 'Goods' )->getGoodsList( [
				'goods_id' => [
					'in',
					$goodscommonid_array,
				],
			], 'stock,goods_id,id', '', '', '1,10000' );
			$stock_array = [];
			foreach( $stock as $val ){
				if( !isset( $stock_array[$val['goods_id']] ) ){
					$stock_array[$val['goods_id']] = [];
				}
				if( $stock_alarm != 0 && $val['stock'] <= $stock_alarm ){
					$stock_array[$val['goods_id']]['alarm'] = true;
				}
				if( !isset( $stock_array[$val['goods_id']]['sum'] ) ){
					$stock_array[$val['goods_id']]['sum'] = $val['stock'];
				} else{
					$stock_array[$val['goods_id']]['sum'] += $val['stock'];
				}
				if( !isset( $stock_array[$val['goods_id']]['id'] ) ){
					$stock_array[$val['goods_id']]['id'] = $val['id'];
				} else{
					$stock_array[$val['goods_id']]['id'] = $val['id'];
				}

			}
			return $stock_array;
		} else{
			return false;
		}
	}

	/**
	 * 更新商品数据
	 * @param array $update    更新数据
	 * @param array $condition 条件
	 * @return boolean
	 */
	public function editGoods( $condition, $update )
	{
		return $this->edit( $update, $condition, true );
	}

	/**
	 * 更新商品数据
	 * @param array $update    更新数据
	 * @param array $condition 条件
	 * @return boolean
	 */
	public function editGoodsNoLock( $update, $condition )
	{
		$condition['lock'] = 0;
		return $this->edit( $update, $condition, true );
	}

	/**
	 * 锁定商品
	 * @param array $condition
	 * @return boolean
	 */
	public function editGoodsLock( $condition )
	{
		$update = ['lock' => 1];
		return $this->edit( $update, $condition, true );
	}

	/**
	 * 解锁商品
	 * @param array $condition
	 * @return boolean
	 */
	public function editGoodsUnlock( $condition ) : bool
	{
		$update = ['lock' => 0];
		return $this->edit( $update, $condition, true );
	}

	/**
	 * 获取单条商品信息
	 * @param array  $condition
	 * @param string $field
	 * @return array
	 */
	public function getGoodsInfo( $condition, $field = '*' ) : array
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得商品数量
	 * @param array  $condition
	 * @param string $field
	 * @return int
	 */
	public function getGoodsCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 出售中的商品数量
	 * @param array $condition
	 * @return int
	 */
	public function getGoodsOnlineCount( $condition )
	{
		$condition['is_on_sale'] = self::STATE1;
		return $this->getGoodsCount( $condition );
	}

	/**
	 * 仓库中的商品数量
	 * @param array $condition
	 * @return int
	 */
	public function getGoodsOfflineCount( $condition )
	{
		$condition['is_on_sale'] = self::STATE0;
		return $this->getGoodsCount( $condition );
	}


	public function comments()
	{
		return $this->hasMany( 'GoodsSku', 'goods_id' )->field( 'goods_id,id,price,stock' );
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @return
	 */
	public function getGoodsId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取的某个字段
	 * @param   $condition
	 * @return
	 */
	public function getGoodsValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取的某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getGoodsColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 获取的某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setIncGoods( $condition, $field, $num )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 获取的某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setDecGoods( $condition, $field, $num )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function updateAllGoods( $update = [] )
	{
		return $this->editMulti( $update );
	}

}

?>