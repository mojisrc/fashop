<?php
/**
 * 下单业务
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use App\Utils\Code;

class Cart extends Server
{
	/**
	 * 购物车列表
	 * @method     GET | POST
	 * @param array $ids 获得某几条
	 * @author   韩文博
	 */
	public function list()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user    = $this->getRequestUser();
			$params  = $this->post ? $this->post : $this->get;
			$options = ['user_id' => $user['id']];
			if( isset( $params['ids'] ) ){
				$options['ids'] = $params['ids'];
			}
			$cart = new \App\Logic\Server\Cart\Cart( $options );
			try{
				$this->send( Code::success, ['list' => $cart->list()] );
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 加入购物车
	 * @method POST
	 * @param int $goods_sku_id 商品id
	 * @param int $quantity     数量
	 * @author   韩文博
	 */
	public function add()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user = $this->getRequestUser();
			if( $this->validate( $this->post, 'Server/Cart.add' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				$cart_model = model( 'Cart' );
				$quantity   = $this->post['quantity'];

				$find = $cart_model->getCartInfo( [
					'goods_sku_id' => $this->post['goods_sku_id'],
					'user_id'      => ['eq',$user['id']],
				] );
				if( !empty( $find ) ){
					return $this->send( Code::param_error, [], '购物车已存在，不可重复添加' );
				}

				$goods_sku_model = model( 'GoodsSku' );
				$goods_sku_info  = $goods_sku_model->getGoodsSkuOnlineInfo( ['goods_sku.id' => $this->post['goods_sku_id']], 'goods_sku.*,goods.img as img,goods.title as title' );
				if( empty( $goods_sku_info ) ){
					return $this->send( Code::param_error, [], '产品不存在' );
				}
				// 购物车里原基础增加数量
				if( $find['cart_id'] > 0 ){
					$quantity += $find['goods_num'];
				}
				if( intval( $goods_sku_info['stock'] ) < 1 ){
					return $this->send( Code::error, [], '商品库存不足' );
				}
				if( intval( $goods_sku_info['stock'] ) < $quantity ){
					return $this->send( Code::error, [], '库存不足' );
				}
//				$goods_sku_info['user_id'] = $user['id'];
				$cart_model->addCart( [
					'user_id'      => $user['id'],
					'goods_sku_id' => $goods_sku_info['id'],
					'goods_num'    => $quantity,
					'is_check'     => 1,
				] );
				$this->send( Code::success );
			}

		}
	}

	/**
	 * 购物车更新商品数量
	 * @method POST
	 * @param int $goods_sku_id 商品id
	 * @param int $quantity     数量
	 * @author   韩文博
	 */
	public function edit()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validate( $this->post, 'Server/Cart.edit' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				$user            = $this->getRequestUser();
				$goods_sku_id    = $this->post['goods_sku_id'];
				$quantity        = $this->post['quantity'];
				$cart_model      = model( 'Cart' );
				$goods_sku_model = model( 'GoodsSku' );
				$cart_info       = $cart_model->getCartInfo( [
					'goods_sku_id' => $goods_sku_id,
					'user_id'      => ['eq', $user['id']],
				] );
				if( empty( $cart_info ) ){
					return $this->send( Code::cart_goods_not_exist );
				}

				$goods_sku_info = $goods_sku_model->getGoodsSkuOnlineInfo( ['goods_sku.id' => $goods_sku_id], 'goods_sku.*,goods.img as img,goods.title as title' );
				if( empty( $goods_sku_info ) ){
					return $this->send( Code::goods_offline );
				}
				$condition = [
					'id'      => $cart_info['id'],
					'user_id' => ['eq', $user['id']],
				];
				if( $goods_sku_info['stock'] < $quantity ){
					if( $goods_sku_info['stock'] > 0 ){
						// 更新下购物车数量
						$cart_model->editCart( $condition, ['goods_num' => $goods_sku_info['stock']] );
					}
					$this->send( Code::goods_stockout );
				} else{
					$cart_model->editCart( $condition, [
						'goods_sku_id' => $goods_sku_info['id'],
						'goods_num'    => $quantity,
					] );
					$this->send( Code::success );
				}
			}
		}
	}

	/**
	 * 删除购物车某条记录
	 * @method POST
	 * @param array $goods_sku_ids 商品id
	 * @author   韩文博
	 */
	public function del()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user                  = $this->getRequestUser();
			$this->post['user_id'] = $user['id'];
			if( $this->validate( $this->post, 'Server/Cart.del' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				$cart_model = model( 'Cart' );
				$cart_model->delCart( [
					'goods_sku_id' => ['in', $this->post['goods_sku_ids']],
					'user_id'      => ['eq', $user['id']],
				] );
				return $this->send( Code::success );
			}
		}
	}

	/**
	 * 购物车单条
	 * @method     GET
	 * @param int $goods_sku_id
	 * @author   韩文博
	 */
	public function info()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user = $this->getRequestUser();
			$cart = new \App\Logic\Server\Cart\Cart( ['user_id' => $user['id']] );
			try{
				$info = $cart->info( [
					'cart.goods_sku_id' => $this->get['goods_sku_id'],
				] );
				if( $info ){
					$this->send( Code::success, ['info' => $info] );
				} else{
					$this->send( Code::error );
				}
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 是否存在某商品
	 * @method GET
	 * @param int $goods_sku_id 商品id
	 * @author   韩文博
	 */
	public function exist()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validate( $this->get, 'Server/Cart.exist' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				$user      = $this->getRequestUser();
				$cart_info = model( 'Cart' )->getCartInfo( [
					'goods_sku_id' => $this->get['goods_sku_id'],
					'user_id'      => ['eq', $user['id']],
				], 'id' );
				return $this->send( Code::success, [
					'state' => $cart_info ? true : false,
				] );
			}
		}
	}

	/**
	 * 清空购物车
	 * @method POST
	 * @author   韩文博
	 */
	public function clear()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user       = $this->getRequestUser();
			$cart_model = model( 'Cart' );
			$cart_model->delCart( ['user_id' => ['eq', $user['id']]] );
			$this->send( Code::success );
		}
	}

	/**
	 * 获得购物车个数
	 * @method     GET
	 * @author   韩文博
	 */
	public function totalNum()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user       = $this->getRequestUser();
			$cart_model = model( 'Cart' );
			$total      = $cart_model->where( ['user_id' => ['eq', $user['id']]] )->sum( 'goods_num' );
			$this->send( Code::success, ['total_num' => $total] );
		}
	}

	/**
	 * 修改购物车商品选中状态
	 * @method     POST
	 * @param int $goods_sku_ids 商品ids
	 * @param int $is_check      选中状态 默认1选中 0未选中
	 * @author   韩文博
	 */
	public function check()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user                  = $this->getRequestUser();
			$this->post['user_id'] = $user['id'];
			if( $this->validate( $this->post, 'Server/Cart.check' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{

				$cart_model                = model( 'Cart' );
				$condition                 = [];
				$condition['user_id']      = ['eq', $user['id']];
				$condition['goods_sku_id'] = ['in', $this->post['goods_sku_ids']];

				$result = $cart_model->updateCart( $condition, ['is_check' => $this->post['is_check']] );
				if( !$result ){
					return $this->send( Code::error, [], '编辑失败' );
				}

				$this->send( Code::success );
			}
		}
	}

}
