<?php
/**
 * 拼团活动商品模型
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




class GroupGoods extends Model
{
	protected $softDelete = true;
	protected $jsonFields = ['spec'];

	/**
	 * 列表
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGroupGoodsList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->where( $condition )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getGroupGoodsCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->count();
		} else{
			return $this->where( $condition )->count( "DISTINCT ".$distinct );
		}
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
	public function getGroupGoodsMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getGroupGoodsMoreCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->count();

		} else{
			return $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getGroupGoodsInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 获得信息更多
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getGroupGoodsMoreInfo( $condition = [], $field = '*' )
	{
		$data = $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @return
	 */
	public function getGroupGoodsId( $condition = [] )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @return
	 */
	public function getGroupGoodsValue( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getGroupGoodsColumn( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @return
	 */
	public function setIncGroupGoods( $condition = [], $field, $num = 1 )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @return
	 */
	public function setDecGroupGoods( $condition = [], $field, $num = 1 )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertGroupGoods( $insert = [] )
	{
		return $this->add( $insert );
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function addMultiGroupGoods( $insert = [] )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function updateGroupGoods( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiGroupGoods( $update = [] )
	{
		return $this->editMulti( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 */
	public function delGroupGoods( $condition = [] )
	{
        return $this->where( $condition )->del();
	}

	/**
	 * 获得商品sku数量
	 * @param   $condition
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getGoodsSkuMoreCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->count();

		} else{
			return $this->join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 获得商品sku列表
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGoodsSkuMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
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
	public function getGroupGoodsSkuMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->group( $group )->select();
		} else{
			$data = $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getGroupGoodsSkuMoreCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->count();

		} else{
			return $this->join( 'group', 'group_goods.group_id = group.id', 'LEFT' )->join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 检查拼团商品
	 * @param   $group_id [拼团活动id]
	 * @return
	 */
	public function checkGoods( $group_id = 0, $condition = [] )
	{
		$goods_model = new \App\Model\Goods;
		$goods_ids   = $this->getGroupGoodsColumn( $condition, '', 'goods_id' );
		if( $goods_ids ){
			$online_goods_ids = $goods_model->getGoodsColumn( ['id' => ['in', $goods_ids], 'is_on_sale' => 1], 'id' );

			//返回出现在第一个数组中但其他数组中没有的值 [将要删除的商品]
			$difference_goods_del_ids = array_diff( $goods_ids, $online_goods_ids );

			if( $difference_goods_del_ids ){
				//删除活动下失效商品
				$group_goods_result = $this->delGroupGoods( ['group_id' => $group_id, 'goods_id' => ['in', $difference_goods_del_ids]] );
				if( !$group_goods_result ){
					return '删除活动下失效商品失败';
				}
			}
		}
		return true;
	}

	/**
	 * 检查拼团商品sku
	 * @param   $group_id [拼团活动id]
	 * @return
	 */
	public function checkGoodsSku( $group_id = 0, $condition = [] )
	{
		$goods_sku_model = new \App\Model\GoodsSku;
		$goods_sku_ids   = $this->where( $condition)->column('goods_sku_id' );

		if( $goods_sku_ids ){
			$online_goods_sku_ids = $goods_sku_model->where( ['id' => ['in', $goods_sku_ids]])->column( 'id' );

			//返回出现在第一个数组中但其他数组中没有的值 [将要删除的sku]
			$difference_goods_sku_del_ids = array_diff( $goods_sku_ids, $online_goods_sku_ids );

			if( $difference_goods_sku_del_ids ){
				//删除活动下失效商品sku
				$group_goods_result = $this->delGroupGoods( ['group_id' => $group_id, 'goods_sku_id' => ['in', $difference_goods_sku_del_ids]] );
				if( !$group_goods_result ){
					return '删除活动下失效商品sku失败';
				}
			}
		}
		return true;
	}


}
