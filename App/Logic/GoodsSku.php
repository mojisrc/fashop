<?php
/**
 * 商品业务逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

class GoodsSku
{

	/**
	 * @var \App\Model\GoodsSku
	 */
	private $model;

	/**
	 * @return \App\Model\GoodsSku
	 */
	public function getModel() : \App\Model\GoodsSku
	{
		if( !$this->model instanceof \App\Model\GoodsSku ){
			$this->model = model( 'GoodsSku' );
		}
		return $this->model;
	}

	/**
	 * @var array
	 */
	private $skus;
	/**
	 * @var int
	 */
	private $goodsId;
	/**
	 * @var string
	 */
	private $goodsTitle;

	/**
	 * @return string
	 */
	public function getGoodsTitle() : string
	{
		return $this->goodsTitle;
	}

	/**
	 * @param string $goodsTitle
	 */
	public function setGoodsTitle( string $goodsTitle ) : void
	{
		$this->goodsTitle = $goodsTitle;
	}

	public function __construct( array $options )
	{
		if( isset( $options['goods_id'] ) ){
			$this->goodsId = $options['goods_id'];
		}
		if( isset( $options['goods_title'] ) ){
			$this->goodsTitle = $options['goods_title'];
		}
		if( isset( $options['skus'] ) ){
			$this->skus = $options['skus'];
		}
	}

	/** todo spec id 验证int
	 * @return bool
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function add() : bool
	{
		$now_time = time();
		foreach( $this->skus as $key => $sku ){
			// 生成以id升序的spec_sign
			$spec_ids = array_column( $sku['spec'], 'id' );
			asort( $spec_ids );
			// 生成以id升序的spec_sign
			$spec_values_ids = array_column( $sku['spec'], 'value_id' );
			asort( $spec_values_ids );

			// 名字可能有个需求 就是规格名的前后顺序
			$addData[$key] = [
				'title'           => $this->goodsTitle." ".implode( " ", array_column( $sku['spec'], 'value_name' ) ),
				'goods_id'        => $this->goodsId,
				'spec'            => json_encode( $sku['spec'] ),
				'spec_sign'       => json_encode( array_values( $spec_ids ) ),
				'spec_value_sign' => json_encode( array_values( $spec_values_ids ) ),
				'price'           => $sku['price'],
				'stock'           => $sku['stock'],
				'create_time'     => $now_time,
			];
			if( isset( $sku['weight'] ) ){
				$addData[$key]['weight'] = $sku['weight'];
			}
			if( isset( $sku['code'] ) ){
				$addData[$key]['code'] = $sku['code'];
			}
			if( isset( $sku['img'] ) ){
				$addData[$key]['img'] = $sku['img'];
			}
		}
		$count = $this->getModel()->addGoodsSkuAll( $addData );
		if( $count > 0 ){
			return true;
		} else{
			throw new \Exception( "goods sku add fail {$this->getModel()->getError()}" );
		}
	}

	/**
	 * todo spec id 验证int
	 * @return bool
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function edit() : bool
	{
		$now_time    = time();
		$update_ids  = [];
		$update_skus = [];
		$add_skus    = [];
		$exist_skus  = $this->getModel()->getGoodsSkuList( ['goods_id' => $this->goodsId], '*', 'id desc', '1,1000' );
		if( $exist_skus ){
			$exist_skus = array_column( $exist_skus, null, 'spec_value_sign' );
		}
		$exist_spec_value_signs = array_column( $exist_skus, 'spec_value_sign' );
		$exist_ids              = array_column( $exist_skus, 'id' );
		// 对比 spec_value_signs 来判断是否存在
		foreach( $this->skus as $sku ){
			// 生成以id升序的spec_sign
			$spec_ids = array_column( $sku['spec'], 'id' );
			asort( $spec_ids );
			// 生成以id升序的spec_sign
			$spec_values_ids = array_column( $sku['spec'], 'value_id' );
			asort( $spec_values_ids );
			$sku['spec_sign']       = json_encode( array_values( $spec_ids ) );
			$sku['spec_value_sign'] = json_encode( array_values( $spec_values_ids ) );
			if( in_array( $sku['spec_value_sign'], $exist_spec_value_signs ) ){
				$sku['id']     = $exist_skus[$sku['spec_value_sign']]['id'];
				$update_ids[]  = $sku['id'];
				$update_skus[] = $sku;
			} else{
				$add_skus[] = $sku;
			}
		}
		// 删除不存在
		$del_ids = array_diff( $exist_ids, $update_ids );
		if( !empty( $del_ids ) ){
			// 删除不存在的商品
			foreach( $del_ids as $del_id ){
				$state = $this->getModel()->softDelGoodsSku( ['id' => $del_id] );
				if( $state === false ){
					throw new \Exception( "goods sku del fail" );
				}
			}
		}
		// 添加新的
		if( !empty( $add_skus ) ){
			foreach( $add_skus as $key => $sku ){
				$addData[$key] = [
					'title'           => $this->goodsTitle." ".implode( " ", array_column( $sku['spec'], 'value_name' ) ),
					'goods_id'        => $this->goodsId,
					'spec'            => json_encode( $sku['spec'] ),
					'spec_sign'       => $sku['spec_sign'],
					'spec_value_sign' => $sku['spec_value_sign'],
					'price'           => $sku['price'],
					'stock'           => $sku['stock'],
					'create_time'     => $now_time,
				];
				if( isset( $sku['weight'] ) ){
					$addData[$key]['weight'] = $sku['weight'];
				}
				if( isset( $sku['code'] ) ){
					$addData[$key]['code'] = $sku['code'];
				}
				if( isset( $sku['img'] ) ){
					$addData[$key]['img'] = $sku['img'];
				}
			}
			$count = $this->getModel()->addGoodsSkuAll( $addData );
			if( !$count ){
				throw new \Exception( "goods sku add all fail" );
			}
		}
		// 修改老的 老的修改需要
		if( !empty( $update_skus ) ){
			foreach( $update_skus as $key => $sku ){

				$update_skus[$key] = [
					'id'        => $sku['id'],
					'price'     => $sku['price'],
					'stock'     => $sku['stock'],
				];
				if( isset( $sku['weight'] ) ){
					$update_skus[$key]['weight'] = $sku['weight'];
				}
				if( isset( $sku['code'] ) ){
					$update_skus[$key]['code'] = $sku['code'];
				}
				if( isset( $sku['img'] ) ){
					$update_skus[$key]['img'] = $sku['img'];
				}
			}
			// 不可以通过model 进行转换json等type约定
			$state = $this->getModel()->updateAll( $update_skus );
			if( $state === false ){
				throw new \Exception( "goods sku update all fail" );
			}
		}
		return true;
	}

	/**
	 * @param array $ids
	 * @return bool
	 * @throws \Exception
	 */
	public function del( array $ids )
	{
		$state = $this->getModel()->softDelGoodsSku( ['id' => $ids] );
		if( $state !== true ){
			throw new \Exception( "goods sku del fail" );
		} else{
			return true;
		}
	}

	public static function make( array $options = [] ) : GoodsSku
	{
		return new static( $options );
	}



	/**
	 * 获取商品收藏排行
	 * TODO
	 * @author 韩文博
	 * @param int $limit 数量
	 * @return array    商品信息
	 */
	//	public function getHotCollectList( $limit = 5 )
	//	{
	//		$prefix           = 'collect_sales_list_'.$limit;
	//		$hot_collect_list = S( $prefix );
	//		if( empty( $hot_collect_list ) ){
	//			$goods_model      = model( 'Goods' );
	//			$hot_collect_list = $goods_model->getGoodsOnlineList( [], '*', 0, 'collect desc', $limit );
	//			S( $prefix, $hot_collect_list );
	//		}
	//		return $hot_collect_list;
	//	}

	/**
	 * 计算商品库存
	 * TODO
	 * @author 韩文博
	 * @param array $goods_list
	 * @return array|boolean
	 */
	//	public function calculateStorage( $goods_list, $stock_alarm = 0 )
	//	{
	//		// 计算库存
	//		if( !empty( $goods_list ) ){
	//			$goodsid_array = [];
	//			foreach( $goods_list as $value ){
	//				$goodscommonid_array[] = $value['id'];
	//			}
	//			$stock       = $this->getGoodsList( [
	//				'id' => [
	//					'in',
	//					$goodscommonid_array,
	//				],
	//			], 'stock,id,id', '', '', 10000 );
	//			$stock_array = [];
	//			foreach( $stock as $val ){
	//				if( !isset( $stock_array[$val['id']] ) ){
	//					$stock_array[$val['id']] = [];
	//				}
	//				if( $stock_alarm != 0 && $val['stock'] <= $stock_alarm ){
	//					$stock_array[$val['id']]['alarm'] = true;
	//				}
	//				if( !isset( $stock_array[$val['id']]['sum'] ) ){
	//					$stock_array[$val['id']]['sum'] = $val['stock'];
	//				} else{
	//					$stock_array[$val['id']]['sum'] += $val['stock'];
	//				}
	//				if( !isset( $stock_array[$val['id']]['id'] ) ){
	//					$stock_array[$val['id']]['id'] = $val['id'];
	//				} else{
	//					$stock_array[$val['id']]['id'] = $val['id'];
	//				}
	//
	//			}
	//			return $stock_array;
	//		} else{
	//			return false;
	//		}
	//	}

	/**
	 * 获取商品列表
	 * @method GET
	 * @date        2017-05-09
	 * @Author      沈旭
	 * @param       array $get
	 * @param       array $condition
	 * @return      array
	 */
	public function getGoodsList( $get, $condition = [] )
	{
		$goods_common_model   = model( 'GoodsCommon' );
		if( isset( $get['id'] ) && $get['id'] ){
			$condition['id'] = $get['id'];
		}
		if( isset( $get['title'] ) && $get['title'] ){
			$condition['title'] = ['like', '%'.$get['title'].'%'];
		}
		if( isset( $get['brand_title'] ) && $get['brand_title'] ){
			$condition['brand_title'] = ['like', '%'.$get['brand_title'].'%'];
		}

		if( isset( $get['category_id'] ) && $get['category_id'] > 0 ){
			$childs_ids = model( 'GoodsCategory', 'logic' )->getSelfAndChildId( $get['category_id'] );
			if( $childs_ids ){
				$condition['category_id'] = ['in', implode( ',', $childs_ids )];
			} else{
				$condition['category_id'] = - 1;
			}
		}
		if( isset( $get['state'] ) && $get['state'] ){
			$condition['state'] = $get['state'];
		}

		if( isset( $get['off_shelf_state'] ) && $get['off_shelf_state'] ){
			$condition['state'] = 10;
		}

		$count     = $goods_common_model->getGoodsCommonCount( $condition );
		$Page      = new Page( $count, isset( $get['rows'] ) ? $get['rows'] : 10 );
		$page      = $Page->currentPage.','.$Page->listRows;
		$page_show = $Page->show();
		// 审核中
		$list = $goods_common_model->getGoodsCommonList( $condition, '*', 'id desc', $page );

		// 计算库存
		$stock_array = $goods_common_model->calculateStorage( $list );
		$data        = ['list' => $list, 'page' => $page_show, 'stock_array' => $stock_array];
		return $data;
	}

	/**
	 * 同步商品信息到主表
	 * 说明：总销量，总点击率，总评分，库存
	 * stock,visit_count,share_count,sale_num,evaluate_good_star,evaluate_count
	 * @datetime 2017-05-28T21:04:17+0800
	 * @param int $id 商品主表id
	 * @author   韩文博
	 * @return   boolean
	 */
	public function syncGoodsCommonByGoods( $id )
	{
		$list = model( 'Goods' )->where( ['id' => $id] )->field( 'stock,visit_count,share_count,sale_num,evaluate_good_star,evaluate_count' )->select();
		$list = $list ? $list->toArray() : [];
		$data = [
			'stock'              => 0,
			'sale_num'           => 0,
			'evaluate_good_star' => 0,
			'evaluate_count'     => 0,
			'visit_count'        => 0,
			'share_count'        => 0,
		];
		if( $list ){
			foreach( $list as $key => $value ){
				$data['stock']              += $value['stock'];
				$data['sale_num']           += $value['sale_num'];
				$data['evaluate_good_star'] += $value['evaluate_good_star'];
				$data['evaluate_count']     += $value['evaluate_count'];
				$data['visit_count']        += $value['visit_count'];
				$data['share_count']        += $value['share_count'];
			}
			return model( 'GoodsCommon' )->editGoodsCommon( ['id' => $id], $data );
		} else{
			return false;
		}
	}

}
