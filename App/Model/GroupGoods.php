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

use ezswoole\Model;


class GroupGoods extends Model
{
	protected $softDelete = true;
	protected $jsonFields = ['spec'];

	/**
	 * 列表
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGroupGoodsList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
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
	public function getGroupGoodsCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 列表更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGroupGoodsMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

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
	public function getGroupGoodsMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 查询普通的数据和软删除的数据
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getWithTrashedGroupGoodsList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getWithTrashedGroupGoodsCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->withTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->withTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 查询普通的数据和软删除的数据更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getWithTrashedGroupGoodsMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getWithTrashedGroupGoodsMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 只查询软删除的数据
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getOnlyTrashedGroupGoodsList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data;
	}

	/**
	 * 只查询软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getOnlyTrashedGroupGoodsCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->onlyTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->onlyTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 只查询软删除的数据更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getOnlyTrashedGroupGoodsMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data;
	}

	/**
	 * 只查询软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getOnlyTrashedGroupGoodsMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getGroupGoodsInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 获得排除字段的信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getGroupGoodsExcludeInfo( $condition = [], $condition_str = '', $exclude = '' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 获得信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getGroupGoodsMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 获得排除字段的信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getGroupGoodsExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getWithTrashedGroupGoodsInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getWithTrashedGroupGoodsMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的排除字段数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getWithTrashedGroupGoodsExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}


	/**
	 * 查询普通的数据和软删除的排除字段数据信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getWithTrashedGroupGoodsExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 只查询软删除的数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getOnlyTrashedGroupGoodsInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 只查询软删除的数据信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getOnlyTrashedGroupGoodsMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 只查询软删除的排除字段数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getOnlyTrashedGroupGoodsExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}


	/**
	 * 只查询软删除的排除字段数据信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getOnlyTrashedGroupGoodsExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getGroupGoodsId( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getGroupGoodsValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getGroupGoodsColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}

	/**
	 * 获取某个字段列[指定索引]
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getGroupGoodsIndexesColumn( $condition = [], $condition_str = '', $field = 'id', $indexes = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field, $indexes );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setIncGroupGoods( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setDecGroupGoods( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertGroupGoods( $insert = [] )
	{
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllGroupGoods( $insert = [] )
	{
		return $this->saveAll( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function updateGroupGoods( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function updateAllGroupGoods( $update = [] )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 * @param   $condition_str
	 */
	public function delGroupGoods( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->del();
	}



	/**
	 * 获得商品sku数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getGoodsSkuMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'group_goods' )->join( '__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'group_goods' )->join( '__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 获得商品sku列表
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGoodsSkuMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'group_goods' )->join( '__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'group_goods' )->join( '__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 列表更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGroupGoodsSkuMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->join( '__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->join( '__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

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
	public function getGroupGoodsSkuMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->join( '__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'group_goods' )->join( '__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT' )->join( '__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 检查拼团商品
	 * @param   $group_id [拼团活动id]
	 * @return
	 */
	public function checkGoods( $group_id = 0, $condition = [] )
	{
		$goods_model = model( 'Goods' );
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
		$goods_sku_model = model( 'GoodsSku' );
		$goods_sku_ids   = $this->getGroupGoodsColumn( $condition, '', 'goods_sku_id' );

		if( $goods_sku_ids ){
			$online_goods_sku_ids = $goods_sku_model->getGoodsSkuColumn( ['id' => ['in', $goods_sku_ids]], 'id' );

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
