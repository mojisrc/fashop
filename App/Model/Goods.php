<?php
/**
 * 商品主表数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;

use ezswoole\Model;
use traits\model\SoftDelete;

class Goods extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	protected $type
		= [
			'category_ids'      => 'json',
			'sku_list'          => 'json',
			'images'            => 'json',
			'body'              => 'json',
			'spec_list'         => 'json',
			'image_spec_images' => 'json',
		];

	const STATE1   = 1; // 出售中
	const STATE0   = 0; // 下架
	// const STATE10  = 10; // 违规
	// const VERIFY1  = 1; // 审核通过
	// const VERIFY0  = 0; // 审核失败
	// const VERIFY10 = 10; // 等待审核

	/**
	 * 新增商品数据
	 * @author 韩文博
	 * @param array $insert 数据
	 * @return integer pk
	 */
	public function addGoods( $data )
	{
		$data['create_time'] = time();
		$result              = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 新增多条商品数据
	 * @param array $insert
	 * @return bool
	 */
	public function addGoodsAll( $insert )
	{
		return $this->insertAll( $insert );
	}

	/**
	 * 商品列表
	 * @author 韩文博
	 * @param array  $condition 条件
	 * @param array  $field     字段
	 * @param string $page      分页
	 * @param string $order     排序
	 * @return array
	 */
	public function getGoodsList( $condition, $field = '*', $order = 'id desc', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : [];
	}

	/**
	 * 出售中的商品列表
	 * @author 韩文博
	 * @param array  $condition 条件
	 * @param array  $field     字段
	 * @param string $page      分页
	 * @param string $order     排序
	 * @return array
	 */
	public function getGoodsOnlineList( $condition, $field = '*', $order = "id desc", $page = '1,10' )
	{
		$condition['is_on_sale'] = self::STATE1;

		return $this->getGoodsList( $condition, $field, $order, $page );
	}

	/**
	 * 仓库中的商品列表
	 * @author 韩文博
	 * @param array  $condition 条件
	 * @param array  $field     字段
	 * @param string $page      分页
	 * @param string $order     排序
	 * @return array
	 */
	public function getGoodsOfflineList( $condition, $field = '*', $order = "id desc", $page = '1,10' )
	{
		$condition['is_on_sale'] = self::STATE0;
		return $this->getGoodsList( $condition, $field, $order, $page );
	}

	/**
	 * 违规的商品列表
	 * @author 韩文博
	 * @param array  $condition 条件
	 * @param array  $field     字段
	 * @param string $page      分页
	 * @param string $order     排序
	 * @return array
	 */
	// public function getGoodsLockUpList( $condition, $field = '*', $order = "id desc", $page = '1,10' )
	// {
	// 	$condition['is_on_sale'] = self::STATE10;
	// 	return $this->getGoodsList( $condition, $field, $order, $page );
	// }

	/**
	 * 计算商品库存
	 * @author 韩文博
	 * @param array $goods_list
	 * @return array|boolean
	 */
	public function calculateStorage( $goods_list, $stock_alarm = 0 )
	{
		// 计算库存
		if( !empty( $goods_list ) ){
			$goodsid_array = [];
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
	 * @author 韩文博
	 * @param array $update    更新数据
	 * @param array $condition 条件
	 * @return boolean
	 */
	public function editGoods( $condition, $update )
	{
		return $this->update( $update, $condition, true );
	}

	/**
	 * 更新商品数据
	 * @author 韩文博
	 * @param array $update    更新数据
	 * @param array $condition 条件
	 * @return boolean
	 */
	public function editGoodsNoLock( $update, $condition )
	{
		$condition['lock'] = 0;
		return $this->update( $update, $condition, true );
	}

	/**
	 * 锁定商品
	 * @author 韩文博
	 * @param array $condition
	 * @return boolean
	 */
	public function editGoodsLock( $condition )
	{
		$update = ['lock' => 1];
		return $this->update( $update, $condition, true );
	}

	/**
	 * 解锁商品
	 * @author 韩文博
	 * @param array $condition
	 * @return boolean
	 */
	public function editGoodsUnlock( $condition ) : bool
	{
		$update = ['lock' => 0];
		return $this->update( $update, $condition, true );
	}

	/**
	 * 获取单条商品信息
	 * @author 韩文博
	 * @param array  $condition
	 * @param string $field
	 * @return array
	 */
	public function getGoodsInfo( $condition, $field = '*' ) : array
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : [];
	}

	/**
	 * 获得商品数量
	 * @author 韩文博
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
	 * @author 韩文博
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
	 * @author 韩文博
	 * @param array $condition
	 * @return int
	 */
	public function getGoodsOfflineCount( $condition )
	{
		$condition['is_on_sale'] = self::STATE0;
		return $this->getGoodsCount( $condition );
	}

	public function getGoodsAsGoodsShowInfo( $condition, $field = '*' )
	{
		$field = $this->_asGoodsShow( $field );
		return $this->getGoodsInfo( $condition, $field );
	}

	/**
	 * show = 1 为出售中，show = 0为未出售（仓库中，违规，等待审核）
	 * @author 韩文博
	 * @param string $field
	 * @return string
	 */
	private function _asGoodsShow( $field )
	{
		return $field.',(`is_on_sale`='.self::STATE1.') as `show`';
	}

	public function comments()
	{
		return $this->hasMany( 'GoodsSku', 'goods_id' )->field( 'goods_id,id,price,stock' );
	}

    /**
     * 获取的id
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getGoodsId($condition) {
        return $this->where($condition)->value('id');
    }

    /**
     * 获取的某个字段
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getGoodsValue($condition, $field) {
        return $this->where($condition)->value($field);
    }
    /**
     * 获取的某个字段列
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getGoodsColumn($condition, $field) {
        return $this->where($condition)->column($field);
    }

    /**
     * 获取的某个字段+1
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function setIncGoods($condition, $field, $num) {
        return $this->where($condition)->setInc($field, $num);
    }
    /**
     * 获取的某个字段+1
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function setDecGoods($condition, $field, $num) {
        return $this->where($condition)->setDec($field, $num);
    }

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelGoods( $condition )
	{
		$find = $this->where( $condition )->find();
		if( $find ){
			return $find->delete();
		} else{
			return false;
		}

	}

    /**
     * 修改多条数据
     * @param  [type] $update           [更新数据]
     */
    public function updateAllGoods($update = array()) {
        return $this->saveAll($update);
    }

}

?>