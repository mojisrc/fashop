<?php
/**
 * 下单业务模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic\Server\Cart;

class Cart
{
	/**
	 * @var int
	 */
	private $userIds;
	/**
	 * @var array
	 */
	private $ids;
	/**
	 * @var int float
	 */
	private $allPrice = 0;

	/**
	 * @var int
	 */
	private $goodsNum = 0;

	/**
	 * @var \App\Model\Cart;
	 */
	private $model;

	/**
	 * @return array
	 */
	public function getIds() : array
	{
		return $this->ids;
	}

	/**
	 * @param array $ids
	 */
	public function setIds( array $ids ) : void
	{
		$this->ids = $ids;
	}

	/**
	 * @return int
	 */
	public function getUserId() : int
	{
		return $this->userIds;
	}

	/**
	 * @param int $userIds
	 */
	public function setUserId( int $userIds ) : void
	{
		$this->userIds = $userIds;
	}

	/**
	 * @return int
	 */
	public function getAllPrice() : int
	{
		return $this->allPrice;
	}

	/**
	 * @param int $allPrice
	 */
	public function setAllPrice( int $allPrice ) : void
	{
		$this->allPrice = $allPrice;
	}

	/**
	 * @return int
	 */
	public function getGoodsNum() : int
	{
		return $this->goodsNum;
	}

	/**
	 * @param int $goodsNum
	 */
	public function setGoodsNum( int $goodsNum ) : void
	{
		$this->goodsNum = $goodsNum;
	}

	/**
	 * @return \App\Model\Cart
	 */
	public function getModel() : \App\Model\Cart
	{
		return $this->model;
	}

	/**
	 * @param \App\Model\Cart $model
	 */
	public function setModel( \App\Model\Cart $model ) : void
	{
		$this->model = $model;
	}

	public function __construct( array $options = [] )
	{
		if( isset( $options['user_id'] ) ){
			$this->setUserId( $options['user_id'] );
		}
		if( isset( $options['ids'] ) ){
			$this->setIds( $options['ids'] );
		}
		$this->model = model( 'Cart' );
	}

	/**
	 * 取属性值
	 * @param string $name
	 */
	public function __get( $name )
	{
		return $this->$name;
	}

	/**
	 * 将商品添加到购物车中
	 * @param array $goods_info 商品数据信息
	 * @param int   $quantity   购物数量
	 * @author 韩文博
	 */
	public function add( $goods_info = [], $quantity = null )
	{
		$condition                 = [];
		$condition['goods_sku_id'] = $goods_info['id'];
		$condition['user_id']      = $goods_info['user_id'];
		$find                      = $this->model->getCartInfo( $condition );
		if( !empty( $find ) ){
			$this->getCartNum( ['user_id' => $condition['user_id']] );
			return false;
		} else{
			$cart_goods['user_id']      = $goods_info['user_id'];
			$cart_goods['goods_sku_id'] = $goods_info['id'];
			$cart_goods['goods_id']     = $goods_info['goods_id'];
			$cart_goods['goods_title']  = $goods_info['title'];
			$cart_goods['goods_price']  = $goods_info['price'];
			$cart_goods['goods_num']    = $quantity;
			$cart_goods['goods_img']    = $goods_info['img'];
			if( $goods_info['spec'] && $goods_info['spec'] != 'N;' ){
				$cart_goods['goods_spec'] = json_encode( array_values( unserialize( $goods_info['spec'] ) ) );
			} else{
				$cart_goods['goods_spec'] = null;
			}
			$this->getCartNum( ['user_id' => $cart_goods['user_id']] );
			return $this->model->addCart( $cart_goods );
		}
	}

	/**
	 * 更新购物车
	 * @param array $condition
	 * @param array $data
	 * @author 韩文博
	 */
	public function edit( $condition, $data )
	{
		$result = $this->model->editCart( $condition, $data );
		return $result;
	}

	/**
	 * 购物车列表
	 * @param int   $user_id 用户id
	 * @param array $condition
	 * @author 韩文博
	 */
	public function getCartList( $user_id, $condition = [] )
	{
		$condition['user_id'] = $user_id;
		$cart_list            = $this->model->getCartList( $condition, '*', 'id desc', '1,1000' );
		$this->goodsNum       = count( $cart_list );
		$cart_all_price       = 0;
		if( is_array( $cart_list ) ){
			foreach( $cart_list as $val ){
				$cart_all_price += $val['goods_price'] * $val['goods_num'];
			}
		}
		$this->allPrice = \App\Utils\Price::format( $cart_all_price );
		return (array)$cart_list;
	}

	/**
	 * @throws \ezswoole\db\exception\DataNotFoundException
	 * @throws \ezswoole\db\exception\ModelNotFoundException
	 * @throws \ezswoole\exception\DbException
	 * @author 韩文博
	 */
	public function list( array $condition = [] )
	{
		$model     = $this->getModel();
		$condition = array_merge( $condition, ['cart.user_id' => ['eq', $this->getUserId()]] );
		if( $this->ids ){
			$condition['cart.id'] = ['in', $this->getIds()];
		}
		$field_array = [
			'cart.id',
			'cart.create_time',
			'cart.goods_sku_id',
			'cart.goods_num',
			'cart.is_check',
			'goods.id as goods_id',
			'goods.title as goods_title',
			'goods.is_on_sale as goods_is_on_sale',
			'goods.freight_fee as goods_freight_fee',
			'goods.freight_id as goods_freight_id',
			'goods.pay_type as goods_pay_type',
			'goods_sku.price as goods_price',
			'goods_sku.spec as goods_spec',
			'goods_sku.weight as goods_weight',
			'goods_sku.stock as goods_stock',
			'goods_sku.img as goods_sku_img',
			'freight.areas as goods_freight_areas',
		];
		$field       = implode( ",", $field_array );
		$list        = $model->alias( 'cart' )->join( 'goods_sku', 'goods_sku.id = cart.goods_sku_id', "LEFT" )->join( 'goods', 'goods_sku.goods_id = goods.id', "LEFT" )->join( 'freight', 'goods.freight_id = freight.id', "LEFT" )->field( $field )->where( $condition )->group( 'goods_sku_id' )->select();

		if( $list ){
			$list = $list->toArray();
		} else{
			$list = [];
		}
		return $list;
	}

	/**
	 * @throws \ezswoole\db\exception\DataNotFoundException
	 * @throws \ezswoole\db\exception\ModelNotFoundException
	 * @throws \ezswoole\exception\DbException
	 * @author 韩文博
	 */
	public function info( array $condition = [] )
	{
		$model       = $this->getModel();
		$condition   = array_merge( $condition, ['cart.user_id' => ['eq', $this->getUserId()]] );
		$field_array = [
			'cart.id',
			'cart.create_time',
			'cart.goods_sku_id',
			'cart.goods_num',
			'goods.id as goods_id',
			'goods.title as goods_title',
			'goods.is_on_sale as goods_is_on_sale',
			'goods.freight_fee as goods_freight_fee',
			'goods.freight_id as goods_freight_id',
			'goods.pay_type as goods_pay_type',
			'goods_sku.price as goods_price',
			'goods_sku.spec as goods_spec',
			'goods_sku.weight as goods_weight',
			'goods_sku.stock as goods_stock',
			'goods_sku.img as goods_sku_img',
			'freight.areas as goods_freight_areas',
		];
		$field       = implode( ",", $field_array );
		$info        = $model->alias( 'cart' )->join( 'goods_sku', 'goods_sku.id = cart.goods_sku_id', "LEFT" )->join( 'goods', 'goods_sku.goods_id = goods.id', "LEFT" )->join( 'freight', 'goods.freight_id = freight.id', "LEFT" )->field( $field )->where( $condition )->find();

		if( $info ){
			$info = $info->toArray();
		} else{
			$list = [];
		}
		return $info;
	}

	/**
	 * 删除购物车商品
	 * @param array $condition
	 * @author 韩文博
	 */
	public function delCart( $condition = [] )
	{
		$result = $this->where( $condition )->delete();
		//重新计算购物车商品数和总金额
		if( $result ){
			$this->getCartNum( ['user_id' => $condition['user_id']] );
		}
		return $result;
	}

	/**
	 * 清空购物车
	 * @param array $condition
	 * @author 韩文博
	 */
	public function clearCart( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算购物车总商品数和总金额
	 * @param array $condition 只有登录后操作购物车表时才会用到该参数
	 * @author 韩文博
	 */
	public function getCartNum( $condition = [] )
	{
		$cart_all_price       = 0;
		$cart_goods           = $this->getUserCartList( $condition['user_id'], $condition );
		$this->cart_goods_num = count( $cart_goods );
		if( !empty( $cart_goods ) && is_array( $cart_goods ) ){
			foreach( $cart_goods as $val ){
				$cart_all_price += $val['goods_price'] * $val['goods_num'];
			}
		}
		$this->allPrice = \App\Utils\Price::format( $cart_all_price );
		return $this->goodsNum;
	}

	/**
	 * 直接购买时返回最新的在售商品信息（需要在售）
	 *
	 * @param int $goods_sku_id 所购商品ID
	 * @param int $quantity     购买数量
	 * @return array
	 * @author 韩文博
	 */
	public function getGoodsOnlineInfo( $goods_sku_id, $quantity )
	{
		//取目前在售商品
		$goods_info = model( 'Goods' )->getGoodsOnlineInfo( ['id' => $goods_sku_id] );

		if( empty( $goods_info ) ){
			return null;
		}
		$new_array                  = [];
		$new_array['goods_num']     = $quantity;
		$new_array['goods_sku_id']  = $goods_sku_id;
		$new_array['goods_id']      = $goods_info['goods_id'];
		$new_array['category_id']   = $goods_info['category_id'];
		$new_array['id']            = $goods_info['id'];
		$new_array['goods_title']   = $goods_info['title'];
		$new_array['goods_spec']    = $goods_info['spec_name'];
		$new_array['goods_price']   = $goods_info['price'];
		$new_array['title']         = $goods_info['title'];
		$new_array['goods_img']     = $goods_info['img'];
		$new_array['transport_id']  = $goods_info['transport_id'];
		$new_array['goods_freight'] = $goods_info['freight'];
		$new_array['goods_vat']     = $goods_info['vat'];
		$new_array['goods_stock']   = $goods_info['stock'];
		$new_array['state']         = true;
		$new_array['stock_state']   = intval( $goods_info['stock'] ) < intval( $quantity ) ? false : true;

		$new_array['is_expert']      = $goods_info['is_expert'];
		$new_array['expert_user_id'] = $goods_info['expert_user_id'];

		//填充必要下标，方便后面统一使用购物车方法与模板
		//cart_id=goods_sku_id,优惠套装目前只能进购物车,不能立即购买
		$new_array['cart_id'] = $goods_sku_id;
		// if ($goods_info['spec'] && $goods_info['spec'] != 'N;') {
		// 	$new_array['goods_spec'] = json_encode(array_values(unserialize($goods_info['spec'])));
		// } else {
		// 	$new_array['goods_spec'] = null;
		// }

		return $new_array;
	}

	/**
	 * 获得用户购物车在线的商品列表
	 * @datetime 2017-05-26T17:00:17+0800
	 * @param int   $user_id  用户id
	 * @param array $cart_ids 购物车id集合（用户要购买的购物车id集合）
	 * @author   韩文博
	 * @return   array
	 */
	public function getCartOnlineGoodsList( int $user_id, array $cart_ids = [] )
	{
		$condition = [];
		if( !empty( $cart_ids ) ){
			$condition['cart_id'] = ['in', implode( ',', $cart_ids )];
		}
		$cart_list = $this->getCartList( $user_id, $condition );

		if( empty( $cart_list ) ){
			return $cart_list;
		}
		$goods_sku_id_array = [];
		foreach( $cart_list as $key => $cart_info ){
			$goods_sku_id_array[] = $cart_info['goods_sku_id'];
		}
		$goods_model        = model( 'Goods' );
		$goods_online_list  = $goods_model->getGoodsOnlineList( ['id' => ['in', $goods_sku_id_array]] );
		$goods_online_array = [];
		foreach( $goods_online_list as $goods ){
			$goods_online_array[$goods['id']] = $goods;
		}
		foreach( (array)$cart_list as $key => $cart_info ){

			$cart_list[$key]['state']       = true;
			$cart_list[$key]['stock_state'] = true;
			if( in_array( $cart_info['goods_sku_id'], array_keys( $goods_online_array ) ) ){
				$goods_online_info                = $goods_online_array[$cart_info['goods_sku_id']];
				$cart_list[$key]['goods_title']   = $goods_online_info['title'];
				$cart_list[$key]['goods_spec']    = $goods_online_info['spec_name'];
				$cart_list[$key]['category_id']   = $goods_online_info['category_id'];
				$cart_list[$key]['goods_id']      = $goods_online_info['goods_id'];
				$cart_list[$key]['goods_img']     = $goods_online_info['img'];
				$cart_list[$key]['goods_price']   = $goods_online_info['price'];
				$cart_list[$key]['transport_id']  = $goods_online_info['transport_id'];
				$cart_list[$key]['goods_freight'] = $goods_online_info['freight'];
				$cart_list[$key]['goods_vat']     = $goods_online_info['vat'];
				$cart_list[$key]['goods_stock']   = $goods_online_info['stock'];
				if( $cart_info['goods_num'] > $goods_online_info['stock'] ){
					$cart_list[$key]['stock_state'] = false;
				}
			} else{
				//如果商品下架
				$cart_list[$key]['state']       = false;
				$cart_list[$key]['stock_state'] = false;
			}
		}
		return $cart_list;
	}


	/**
	 * 从购物车数组中得到商品列表
	 * @param $cart_list
	 * @author 韩文博
	 */
	public function getGoodsListByCartGoodsList( $cart_list )
	{
		if( empty( $cart_list ) || !is_array( $cart_list ) ){
			return $cart_list;
		}

		$goods_list = [];
		$i          = 0;
		foreach( $cart_list as $key => $cart ){
			if( !$cart['state'] || !$cart['stock_state'] ){
				continue;
			}

			//购买数量
			$quantity = $cart['goods_num'];
			if( !intval( $cart['bl_id'] ) ){
				//如果是普通商品
				$goods_list[$i]['goods_num']     = $quantity;
				$goods_list[$i]['goods_sku_id']  = $cart['goods_sku_id'];
				$goods_list[$i]['id']            = $cart['cart_id'];
				$goods_list[$i]['category_id']   = $cart['category_id'];
				$goods_list[$i]['goods_title']   = $cart['goods_title'];
				$goods_list[$i]['goods_price']   = $cart['goods_price'];
				$goods_list[$i]['title']         = $cart['goods_title'];
				$goods_list[$i]['goods_img']     = $cart['goods_img'];
				$goods_list[$i]['transport_id']  = $cart['transport_id'];
				$goods_list[$i]['goods_freight'] = $cart['goods_freight'];
				$goods_list[$i]['goods_vat']     = $cart['goods_vat'];
				$goods_list[$i]['bl_id']         = 0;
				$i ++;
			} else{
				//如果是优惠套装商品
				foreach( $cart['bl_goods_list'] as $bl_goods ){
					$goods_list[$i]['goods_num']     = $quantity;
					$goods_list[$i]['goods_sku_id']  = $bl_goods['goods_sku_id'];
					$goods_list[$i]['id']            = $cart['id'];
					$goods_list[$i]['category_id']   = $bl_goods['category_id'];
					$goods_list[$i]['goods_title']   = $bl_goods['goods_title'];
					$goods_list[$i]['goods_price']   = $bl_goods['goods_price'];
					$goods_list[$i]['title']         = $bl_goods['title'];
					$goods_list[$i]['goods_img']     = $bl_goods['goods_img'];
					$goods_list[$i]['transport_id']  = $bl_goods['transport_id'];
					$goods_list[$i]['goods_freight'] = $bl_goods['goods_freight'];
					$goods_list[$i]['goods_vat']     = $bl_goods['goods_vat'];
					$goods_list[$i]['bl_id']         = $cart['bl_id'];
					$i ++;
				}
			}
		}
		return $goods_list;
	}

	/**
	 * 商品金额计算(分别对每个商品/优惠套装小计、每个小计)
	 * @param array $cart_list 以ID分组的购物车商品信息
	 * @return array
	 * @author 韩文博
	 */
	public function calculateCartList( $cart_list )
	{

		if( empty( $cart_list ) || !is_array( $cart_list ) ){
			return [$cart_list, [], 0];
		}
		//存放商品总金额
		$goods_total = [];
		foreach( $cart_list as $id => $cart ){
			$tmp_amount          = 0;
			$cart['goods_total'] = \App\Utils\Price::format( $cart['goods_price'] * $cart['goods_num'] );
			$tmp_amount          += $cart['goods_total'];

			$cart_list[$id] = $cart;

			$goods_total[$cart['goods_sku_id']] = \App\Utils\Price::format( $tmp_amount ); //运费这块暂时不清楚怎么设计
		}
		return [$cart_list, $goods_total];
	}

	/**
	 * 计算商品总金额
	 * @param $cart_list
	 * @return float
	 * @author 韩文博
	 */
	public function calculateCartListGoodsTotal( $cart_list ) : float
	{
		if( empty( $cart_list ) || !is_array( $cart_list ) ){
			return 0;
		}
		//存放商品总金额
		$goods_total = 0;
		foreach( $cart_list as $cart_goods ){
			$goods_total += \App\Utils\Price::format( $cart_goods['goods_price'] * $cart_goods['goods_num'] );
		}
		return $goods_total;
	}

	/**
	 * 重新计算最终商品总金额(最初计算金额减去各种优惠/加运费)
	 * @param array       $goods_total 商品总金额
	 * @param array | int $event_info  优惠活动内容
	 * @param string      $event_type  优惠类型
	 * @return array 返回扣除优惠后的商品总金额
	 * @author 韩文博
	 */
	public function calculateGoodsTotalByEvent( $goods_total, $event_info, $event_type )
	{

		$deny = empty( $goods_total ) || empty( $event_info );
		if( $deny ){
			return $goods_total;
		}

		switch( $event_type ){

		case 'coupon':
			$goods_total -= $event_info['price'];
		break;

		case 'freight':
			$freight_total = $event_info;
			$goods_total   += $freight_total;
		break;
		}
		return $goods_total;
	}
}
