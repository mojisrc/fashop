<?php
/**
 * 商品模块
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use App\Utils\Code;

class Goods extends Server
{

	/**
	 * 商品列表
	 * @method GET | POST
	 * @param string title 商品名称
	 * @param array  category_ids 分类id 数组格式
	 * @param int    order_type 1商品价格低到高 2商品价格高到低 3销量多到少 4销量少到多 5库存多到少 6库存少到多 7创建时间早到晚 8创建时间晚到早
	 * @param array  price
	 */
	public function list()
	{
		if( $this->post ){
			$param = $this->post;
		} else{
			$param = $this->get;
		}
		$param['page']       = $this->getPageLimit();
		$param['sale_time']  = ['<', time()];
		$param['is_on_sale'] = 1;

		$goodsLogic = new \App\Logic\GoodsSearch( $param );

		$this->send( Code::success, [
			'total_number' => $goodsLogic->count(),
			'list'         => $goodsLogic->list(),
		] );


	}

	/**
	 * 单条商品信息
	 * @method GET
	 * @param int $id           商品id 必填。二选一
	 * @param int $goods_sku_id 商品sku id 必填。二选一
	 */
	public function info()
	{
		if( isset( $this->get['id'] ) ){
			if( $this->validator( $this->get, 'Goods.info' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidator()->getError() );
			} else{
				$goods_info         = \App\Model\Goods::getGoodsInfo( ['id' => $this->get['id']] );
				$goods_info['skus'] = \App\Model\GoodsSku::getGoodsSkuList( ['goods_id' => $this->get['id']], '*', 'id desc', [1,10000] );
				$this->send( Code::success, ['info' => $goods_info] );
			}
		} else{
			$this->bySku();
		}
	}

	private function bySku()
	{
		// 根据sku查商品
		if( $this->validator( $this->get, 'Goods.sku' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$goods_info = \App\Model\Goods::join( 'goods_sku', 'goods.id = goods_sku.goods_id', 'LEFT' )->where( [
				'goods_sku.id' => $this->get['goods_sku_id'],
			] )->field( 'goods.*,goods_sku.id as goods_sku_id' )->find();

			$goods_info['skus'] = \App\Model\GoodsSku::getGoodsSkuList( ['goods_id' => $goods_info['id']], '*', 'id desc', [1,10000] );
			$this->send( Code::success, ['info' => $goods_info] );
		}
	}

	/**
	 * todo 不一定放这
	 * 浏览过的商品记录
	 * @method GET
	 * @param int page 页数
	 * @param int rows 条数
	 * */
	public function visitedRecord()
	{
		$fields = "id,goods_common_id,title,category_id,price,market_price,stock,img,freight,sale_num,color_id,evaluate_good_star,evaluate_count";
		$order  = 'id desc';

		$condition = [];

		$goods_ids = [];

		$user = $this->getRequestUser();

		// 获得浏览商品的id数组
		if( $user['id'] ){
			$goods_ids = \App\Model\Visit::where( [
				'user_id' => $user['id'],
				'model'   => 'goods',
			] )->value( 'model_relation_id' );
		}

		$count      = 0;
		$goods_list = [];

		if( isset( $goods_ids ) ){
			$condition['id'] = ['in', $goods_ids];
			$count           = \App\Model\Goods::getGoodsOnlineCount( $condition );

			$goods_list = \App\Model\Goods::getGoodsOnlineList( $condition, $fields, $order, $this->getPageLimit() );

		}

		$result                 = [];
		$result['total_number'] = $count;
		$result['list']         = (array)$goods_list;
		$this->send( Code::success, $result );

	}


	/**
	 * 获得某条商品的评价信息
	 * @method GET
	 * @param int   $type      默认为全部评价，好评positive 、中评 moderate、差评negative
	 * @param int   $has_image 1有图
	 * @param int   $goods_id  商品id  goods_id
	 * @param array $ids       id数组
	 * @param int page 页数
	 * @param int rows 条数
	 */
	public function evaluateList()
	{
		$param = [];

		if( isset( $this->post ) ){
			$param = $this->post;
		}

		if( isset( $this->get ) ){
			$param = $this->get;
		}

		if( intval( $param['goods_id'] <= 0 ) ){
			$this->send( Code::param_error, [], '参数错误' );
		} else{
			$condition['goods_evaluate.goods_id'] = $param['goods_id'];

			if( isset( $param['type'] ) ){
				switch( $param['type'] ){
				case 'positive':
					$condition['goods_evaluate.score'] = 5;
				break;
				case 'moderate':
					$condition['goods_evaluate.score'] = ['in', '3,4'];
				break;

				case 'negative':
					$condition['goods_evaluate.score'] = ['in', '1,2'];
				break;
				}
			}
			if( isset( $param['has_image'] ) ){
				$condition['goods_evaluate.images'] = ['neq', 'null'];
			}

			if( isset( $this->get['ids'] ) && is_array( $this->get['ids'] ) ){
				$condition['goods_evaluate.id'] = ['in', $this->get['ids']];
			}

			$count = \App\Model\GoodsEvaluate::join( 'order order', 'goods_evaluate.order_id = order.id', 'LEFT' )->group( 'goods_evaluate.id' )->where( $condition )->count();
			$list  = \App\Model\GoodsEvaluate::join( 'order order', 'goods_evaluate.order_id = order.id', 'LEFT' )->join( 'order_goods goods', 'goods_evaluate.order_goods_id = goods.id' )->join( 'user user', 'goods_evaluate.user_id = user.id', 'LEFT' )->join( 'user_profile user_profile', 'user.id = user_profile.user_id', 'LEFT' )->where( $condition )->field( 'goods_evaluate.id,score,goods_evaluate.goods_img,goods_evaluate.content,goods_evaluate.create_time,goods_evaluate.images,additional_content,additional_images,additional_time,reply_content,reply_content2,display,top,goods.goods_spec,user.phone,user_profile.nickname,user_profile.avatar' )->order( 'goods_evaluate.id desc' )->page( $this->getPageLimit() )->group( 'goods_evaluate.id' )->select();
			$this->send( Code::success, [
				'total_number' => $count,
				'list'         => $list,
			] );
		}

	}

}
