<?php
/**
 * 商品SKU数据模型
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

class GoodsSku extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	protected $type
		= [
			'spec' => 'json',
		];

	const STATE1   = 1; // 出售中
	const STATE0   = 0; // 下架
	const STATE10  = 10; // 违规
	const VERIFY1  = 1; // 审核通过
	const VERIFY0  = 0; // 审核失败
	const VERIFY10 = 10; // 等待审核

	/**
	 * 新增商品数据
	 * @author 韩文博
	 * @param array $insert 商品数据
	 * @return integer pk
	 */
	public function addGoodsSku( $insert )
	{
		$result = $this->allowField( true )->save( $insert );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 新增多条商品数据
	 * @param array $insert
	 */
	public function addGoodsSkuAll( $insert )
	{
		return $this->insertAll( $insert );
	}

	/**
	 * 循环新增商品数据
	 * @author 韩文博
	 * @param array $insert 商品数据
	 * @return integer pk
	 */
	public function addForGoodsSku( $insert )
	{
		$result = $this->data( $insert, true )->isUpdate( false )->save();
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 商品SKU列表
	 * @author 韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @param string $order     排序
	 * @param string $page      分页
	 * @return array 二维数组
	 */
	public function getGoodsSkuList( $condition, $field = '*', $order = 'id desc', $page = '1,10' ) : array
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : [];
	}

	/**
	 * 在售商品SKU列表
	 * @author 韩文博
	 * @param array   $condition 条件
	 * @param string  $field     字段
	 * @param string  $group     分组
	 * @param string  $order     排序
	 * @param int     $limit     限制
	 * @param int     $page      分页
	 * @param boolean $lock      是否锁定
	 * @return array
	 */
	public function getGoodsSkuOnlineList( $condition, $field = '*', $page = '1,10', $order = 'id desc', $limit = 1000, $group = '', $lock = false )
	{
		$condition['state'] = self::STATE1;
		return $this->getGoodsSkuList( $condition, $field, $group, $order, $page );
	}

	/**
	 * 商品SUK列表 show = 1 为出售中，show = 0为未出售（仓库中，违规，等待审核）
	 * @author 韩文博
	 * @param array  $condition
	 * @param string $field
	 * @return multitype:
	 */
	public function getGoodsSkuAsGoodsSkuShowList( $condition, $field = '*' )
	{
		$field = $this->_asGoodsSkuShow( $field );
		return $this->getGoodsSkuList( $condition, $field );
	}

	/**
	 * 更新商品SUK数据
	 * @param array $data      更新数据
	 * @param array $condition 条件
	 */
	public function editGoodsSku( $condition, $data )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * @method      遍历更新
	 * @method GET
	 * @date        2017-08-01
	 * @Author      作者
	 * @param       [type]     $data [description]
	 * @return      [type]           [description]
	 */
	public function editForGoodsSku( $data )
	{
		return $this->data( $data, true )->isUpdate( true )->save();
	}

	/**
	 * 修改多条数据
	 * @param  [type] $update           [更新数据]
	 */
	public function updateAllGoodsSku( $update = [] )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 获取单条商品SKU信息
	 * @author 韩文博
	 * @param array  $condition
	 * @param string $field
	 * @return array
	 */
	public function getGoodsSkuInfo( $condition, $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : [];
	}

	/**
	 * 获取单条商品SKU信息
	 * @author 韩文博
	 * @param array  $condition
	 * @param string $field
	 * @return array
	 */
	public function getGoodsSkuOnlineInfo( array $condition = [], $field = 'goods_sku.*' )
	{
		try{
			$condition['is_on_sale'] = 1;
			$goods_info              = $this->alias( 'goods_sku' )->join( 'goods', 'goods_sku.goods_id = goods.id', 'LEFT' )->where( $condition )->field( $field )->find();
			return $goods_info ? $goods_info->toArray() : null;
		} catch( \Exception $e ){
			trace( $e->getMessage() );
			return null;
		}

	}

	/**
	 * 获取单条商品SKU信息，show = 1 为出售中，show = 0为未出售（仓库中，违规，等待审核）
	 * @author 韩文博
	 * @param array  $condition
	 * @param string $field
	 * @return array
	 */
	public function getGoodsSkuAsGoodsSkuShowInfo( $condition, $field = '*' )
	{
		$field = $this->_asGoodsSkuShow( $field );
		return $this->getGoodsSkuInfo( $condition, $field );
	}

	/**
	 * 获得商品SKU某字段的和
	 * @author 韩文博
	 * @param array  $condition
	 * @param string $field
	 * @return boolean
	 */
	public function getGoodsSkuSum( $condition, $field )
	{
		return $this->where( $condition )->sum( $field );
	}

	/**
	 * 获得商品SKU数量
	 * @author 韩文博
	 * @param array  $condition
	 * @param string $field
	 * @return int
	 */
	public function getGoodsSkuCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获得出售中商品SKU数量
	 * @author 韩文博
	 * @param array  $condition
	 * @param string $field
	 * @return int
	 */
	public function getGoodsSkuOnlineCount( $condition, $field = '*' )
	{
		$condition['state'] = self::STATE1;
		return $this->where( $condition )->field( $field )->count( 'DISTINCT goods_common_id' );
	}

	/**
	 * 获取的id
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getGoodsSkuId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取的某个字段
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getGoodsSkuValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取的某个字段列
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getGoodsSkuColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 删除商品SKU信息
	 * @author 韩文博
	 * @param array $condition
	 * @return boolean
	 */
	public function delGoodsSku( $condition )
	{
		return $this->where( $condition )->delete();
	}


	/**
	 * 获取某个字段+1
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function setIncGoodsSku( $condition, $field, $num )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 获取某个字段+1
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function setDecGoodsSku( $condition, $field, $num )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

	/**
	 * 软删除
	 * @param    array $condition
	 *                           TODO 批量软删除
	 */
	public function softDelGoodsSku( $condition )
	{
		$find = $this->where( $condition )->find();
		if( $find ){
			return $find->delete();
		} else{
			return false;
		}
	}

}

?>