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
	 * @param $data
	 * @return bool|int
	 */
	public function addGoods( $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param        $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 * @throws \EasySwoole\Mysqli\Exceptions\OrderByFail
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
	 * @param        $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getGoodsOnlineList( $condition, $field = '*', $order = "id desc", $page = [1, 10] )
	{
		$condition['is_on_sale'] = self::STATE1;
		return $this->getGoodsList( $condition, $field, $order, $page );
	}


	/**
	 * 仓库中的商品列表
	 * @param        $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getGoodsOfflineList( $condition, $field = '*', $order = "id desc", $page = [1, 10] )
	{
		$condition['is_on_sale'] = self::STATE0;
		return $this->getGoodsList( $condition, $field, $order, $page );
	}

	/**
	 * 计算商品库存
	 * @param     $goods_list
	 * @param int $stock_alarm
	 * @return array|bool
	 */
	public function calculateStorage( $goods_list, $stock_alarm = 0 )
	{
		// 计算库存
		if( !empty( $goods_list ) ){
			foreach( $goods_list as $value ){
				$goods_array[] = $value['id'];
			}
			$stock       = model( 'Goods' )->getGoodsList( [
				'goods_id' => ['in', $goods_array,],
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
	 * @param $condition
	 * @param $data
	 * @return bool|mixed
	 */
	public function editGoods( $condition, $data )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * @param        $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getGoodsInfo( $condition, $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * @param $condition
	 * @return array|bool|int|null
	 */
	public function getGoodsCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 出售中的商品数量
	 * @param $condition
	 * @return array|bool|int|null
	 */
	public function getGoodsOnlineCount( $condition )
	{
		$condition['is_on_sale'] = self::STATE1;
		return $this->getGoodsCount( $condition );
	}

	/**
	 * 仓库中的商品数量
	 * @param $condition
	 * @return array|bool|int|null
	 */
	public function getGoodsOfflineCount( $condition )
	{
		$condition['is_on_sale'] = self::STATE0;
		return $this->getGoodsCount( $condition );
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
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiGoods( array $update )
	{
		return $this->editMulti( $update );
	}

}

?>