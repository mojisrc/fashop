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



//

class GoodsSku extends Model
{
	protected $jsonFields = ['spec', 'goods_spec'];

	const STATE1   = 1; // 出售中
	const STATE0   = 0; // 下架
	const STATE10  = 10; // 违规
	const VERIFY1  = 1; // 审核通过
	const VERIFY0  = 0; // 审核失败
	const VERIFY10 = 10; // 等待审核


	public function addGoodsSku( array $data )
	{
		return $this->add( $data );
	}


	public function addMultiGoodsSku( $data )
	{
		return $this->addMulti( $data );
	}

	public function getGoodsSkuList( $condition, $field = '*', $order = 'id desc', $page = [1, 10] ) : array
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}


	public function editGoodsSku( array $condition, array $data )
	{
		return $this->where( $condition )->edit( $data );
	}


	public function editMultiGoodsSku( $update = [] )
	{
		return $this->editMulti( $update );
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
	 * 获取单条在售商品SKU信息
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getGoodsSkuOnlineInfo( array $condition = [], $field = '*' )
	{
		$condition['is_on_sale'] = 1;
		$goods_info              = $this->join( 'goods', 'goods_sku.goods_id = goods.id', 'LEFT' )->where( $condition )->field( $field )->find();
		return $goods_info;
	}

	/**
	 * @param $condition
	 * @return array|bool|int|null
	 */
	public function getGoodsSkuCount( $condition )
	{
		return $this->where( $condition )->count();
	}

}

?>