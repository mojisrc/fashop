<?php
/**
 * 商品SKU数据模型
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

class GoodsSku extends Model
{
	protected $jsonFields = ['spec','goods_spec'];

	const STATE1   = 1; // 出售中
	const STATE0   = 0; // 下架
	const STATE10  = 10; // 违规
	const VERIFY1  = 1; // 审核通过
	const VERIFY0  = 0; // 审核失败
	const VERIFY10 = 10; // 等待审核

	/**
	 * 新增商品数据
	 * @param array $data 商品数据
	 * @return integer pk
	 */
	public function addGoodsSku( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 新增多条商品数据
	 * @param array $data
	 */
	public function addGoodsSkuAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 商品SKU列表
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @param string $order     排序
	 * @param string $page      分页
	 * @return array 二维数组
	 */
	public function getGoodsSkuList( $condition, $field = '*', $order = 'id desc', $page = '1,10' ) : array
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	/**
	 * 在售商品SKU列表
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
	 * @param array  $condition
	 * @param string $field
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
		return $this->where($condition)->edit($data);
	}


	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function updateAllGoodsSku( $update = [] )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 获取单条商品SKU信息
	 * @param array  $condition
	 * @param string $field
	 * @return array
	 */
	public function getGoodsSkuInfo( $condition, $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获取单条商品SKU信息
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
	 * @param   $condition
	 * @return
	 */
	public function getGoodsSkuId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取的某个字段
	 * @param   $condition
	 * @return
	 */
	public function getGoodsSkuValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取的某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getGoodsSkuColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 删除商品SKU信息
	 * @param array $condition
	 * @return boolean
	 */
	public function delGoodsSku( $condition )
	{
		return $this->where( $condition )->del();
	}


	/**
	 * 获取某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setIncGoodsSku( $condition, $field, $num )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 获取某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setDecGoodsSku( $condition, $field, $num )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

}

?>