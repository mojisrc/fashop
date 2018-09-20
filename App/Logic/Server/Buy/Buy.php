<?php
/**
 * 购买模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic\Server\Buy;

use App\Logic\Server\Cart\Address;
use App\Logic\Server\Cart\Item;

class Buy
{
	/**
	 * @var array
	 */
	private $data;
	/**
	 * @var array
	 */
	private $cartIds;
	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var int
	 */
	private $addressId;
	/**
	 * 付款方式:在线支付/货到付款(online/offline)
	 * @var string
	 */
	private $payName = 'online';
	/**
	 * @var string
	 */
	private $errMsg;

	/**
	 * @var int
	 */
	private $invoiceId;
	/**
	 * @var int
	 */
	private $couponId;
	/**
	 * @var string
	 */
	private $message;
	/**
	 * 是否来自购物车
	 * 1购物车 0直接购买
	 * @var int
	 */
	private $orderFrom = 1;
	/**
	 * 订单类型，0表示普通订单，还有其他类型类似赠品、酒店、拼团等类型
	 * @var int
	 */
	private $orderType = 0;
	/**
	 * @var array
	 */
	private $cartItems;


	private $cartModel;
	/**
	 * @var Address
	 */
	private $addressInfo;

	/**
	 * @return array
	 */
	public function getCartIds() : array
	{
		return $this->cartIds;
	}

	/**
	 * @param array $cartIds
	 */
	public function setCartIds( array $cartIds ) : void
	{
		$this->cartIds = $cartIds;
	}

	/**
	 * @return int
	 */
	public function getUserId() : int
	{
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId( int $userId ) : void
	{
		$this->userId = $userId;
	}

	/**
	 * @return int
	 */
	public function getAddressId() : int
	{
		return $this->addressId;
	}

	/**
	 * @param int $addressId
	 */
	public function setAddressId( int $addressId ) : void
	{
		$this->addressId = $addressId;
	}

	/**
	 * @return string
	 */
	public function getPayName() : string
	{
		return $this->payName;
	}

	/**
	 * @param string $payName
	 */
	public function setPayName( string $payName ) : void
	{
		$this->payName = $payName;
	}

	/**
	 * @return string
	 */
	public function getErrMsg() : string
	{
		return $this->errMsg;
	}

	/**
	 * @param string $errMsg
	 */
	public function setErrMsg( string $errMsg ) : void
	{
		$this->errMsg = $errMsg;
	}

	/**
	 * @return int
	 */
	public function getInvoiceId() : int
	{
		return $this->invoiceId;
	}

	/**
	 * @param int $invoiceId
	 */
	public function setInvoiceId( int $invoiceId ) : void
	{
		$this->invoiceId = $invoiceId;
	}

	/**
	 * @return int
	 */
	public function getCouponId() : int
	{
		return $this->couponId;
	}

	/**
	 * @param int $couponId
	 */
	public function setCouponId( int $couponId ) : void
	{
		$this->couponId = $couponId;
	}

	/**
	 * @return string
	 */
	public function getMessage() : string
	{
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage( string $message ) : void
	{
		$this->message = $message;
	}

	/**
	 * @return int
	 */
	public function getOrderFrom() : int
	{
		return $this->orderFrom;
	}

	/**
	 * @param int $orderFrom
	 */
	public function setOrderFrom( int $orderFrom ) : void
	{
		$this->orderFrom = $orderFrom;
	}

	/**
	 * @return int
	 */
	public function getOrderType() : int
	{
		return $this->orderType;
	}

	/**
	 * @param int $orderType
	 */
	public function setOrderType( int $orderType ) : void
	{
		$this->orderType = $orderType;
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function getCartItems() : array
	{
		if( empty( $this->cartItems ) ){
			$cart_logic = new \App\Logic\Server\Cart\Cart( ['user_id' => $this->getUserId()] );
			$condition  = ['cart.id' => ['in', array_unique( $this->data['cart_ids'] )]];
			$list       = $cart_logic->list( $condition );

			foreach( $list as $item ){
				if( $item['goods_num'] > $item['goods_stock'] ){
					throw new \Exception( "SKU ID {$item['goods_sku_id']} {$item['goods_title']} 库存不足，现有库存{$item['goods_stock']}，实际购买{$item['goods_num']}" );
				} else{
					$this->cartItems[] = new Item( $item );
				}
			}
		}
		return $this->cartItems;
	}

	/**
	 * @param array $cartItems
	 */
	public function setGoodsSkuItems( array $cartItems ) : void
	{
		$this->cartItems = $cartItems;
	}


	/**
	 * @return object
	 */
	public function getCartModel() : object
	{
		return $this->cartModel;
	}

	/**
	 * @param object $cartModel
	 */
	public function setCartModel( object $cartModel ) : void
	{
		$this->cartModel = $cartModel;
	}

	/**
	 * @return array
	 */
	public function getAddressInfo() : Address
	{
		return $this->addressInfo;
	}

	/**
	 * @param array $addressInfo
	 */
	public function setAddressInfo( Address $addressInfo ) : void
	{
		$this->addressInfo = $addressInfo;
	}

	/**
	 * @var string
	 */
	private $wechatOpenid;

	/**
	 * @return string
	 */
	public function getWechatOpenid() : string
	{
		return $this->wechatOpenid;
	}

	/**
	 * @param string $wechatOpenid
	 */
	public function setWechatOpenid( string $wechatOpenid ) : void
	{
		$this->wechatOpenid = $wechatOpenid;
	}

	/**
	 * @var int
	 */
	private $orderId;

	/**
	 * @return int
	 */
	public function getOrderId() : int
	{
		return $this->orderId;
	}

	/**
	 * @param int $orderId
	 */
	public function setOrderId( int $orderId ) : void
	{
		$this->orderId = $orderId;
	}

	/**
	 * @var array
	 */
	private $userInfo;

	/**
	 * @return array
	 * todo 包含的内容说明
	 */
	public function getUserInfo() : array
	{
		return $this->userInfo;
	}

	/**
	 * @param array $userInfo
	 */
	public function setUserInfo( array $userInfo ) : void
	{
		$this->userInfo = $userInfo;
	}
	/**
	 * @param array $data
	 * @throws \Exception
	 */
	public function __construct( array $data )
	{
		if( isset( $data['pay_name'] ) ){
			if( !in_array( $this->getPayName(), ['online', 'offline'] ) ){
				throw new \Exception( "付款方式错误，请重新选择" );
			} else{
				$this->setPayName( $data['pay_name'] );
			}
		}
		if( isset( $data['message'] ) ){
			$this->setMessage( $data['message'] );
		}
		$this->data = $data;
		$this->setCartIds( $data['cart_ids'] );
		$this->setUserId( $data['user_id'] );
		$this->setAddressId( $data['address_id'] );

		$this->setUserInfo( $data['user_info'] );

		$address_info = model( 'Address' )->getAddressInfo( [
			'id'      => $this->getAddressId(),
			'user_id' => $this->getUserId(),
		] );
		$cart_address = new Address( $address_info );
		$this->setAddressInfo( $cart_address );
		if( $address_info['user_id'] != $data['user_id'] ){
			throw new \Exception( '收货地址错误' );
		}
		$this->setCartModel( model( 'Cart' ) );

	}

	/**
	 * 计算
	 * @throws \Exception
	 * @return \App\Logic\Server\Buy\CalculateResult
	 * @author 韩文博
	 */
	public function calculate() : \App\Logic\Server\Buy\CalculateResult
	{
		$goods_list = $this->getCartItems();
		$address    = $this->getAddressInfo();
		// 根据运费计算规则一
		$freight_unified_fee  = 0;
		$freight_template_fee = 0;
		$goods_amount         = 0;
		/**
		 * @var $goods \App\Logic\Server\Cart\Item
		 */
		foreach( $goods_list as $goods ){
			$row             = [
				'goods_sku_id' => $goods->getGoodsSkuId(),
				'freight_fee'  => $goods->freightFeeByAddress( $address ),
				'freight_way'  => $goods->getGoodsFreightWay(),
			];
			$goods_freight[] = $row;
			if( $goods->getGoodsFreightWay() === 'freight_unified_fee' ){
				if( $row['freight_fee'] > $freight_unified_fee ){
					$freight_unified_fee = $row['freight_fee'];
				}
			} else{
				$freight_template_fee += $row['freight_fee'];
			}
			$goods_amount += $goods->getGoodsPrice() * $goods->getGoodsNum();
		}
		$pay_freight_fee = $freight_unified_fee + $freight_template_fee;
		return new CalculateResult( [
			'goods_amount'         => $goods_amount,
			'pay_amount'           => $goods_amount + $pay_freight_fee,
			'goods_freight_list'   => $goods_freight,
			'freight_unified_fee'  => $freight_unified_fee,
			'freight_template_fee' => $freight_template_fee,
			'pay_freight_fee'      => $pay_freight_fee,
		] );
	}

	/**
	 * 创建订单
	 * @author   韩文博
	 * @throws \Exception
	 */
	public function createOrder() : CreateOrderResult
	{
		$cart_model = $this->getCartModel();
		$cart_model->startTrans();

		try{
			$order_model  = model( 'Order' );
			$user         = $this->getUserInfo();
			$pay_sn       = $this->makePaySn( $this->getUserId() );
			$order_pay_id = $order_model->addOrderPay( [
				'pay_sn'    => $pay_sn,
				'user_id'   => $this->getUserId(),
				'pay_state' => 0

			] );
			if( !$order_pay_id ){
				$cart_model->rollback();
				throw new \Exception( '订单支付记录保存失败' );
			}
			$address         = $this->getAddressInfo();

			$calculateResult = $this->calculate();
			$goods_num       = 0;
			$cart_items      = $this->getCartItems();
			/**
			 * @var \App\Logic\Server\Cart\Item $cartItem ;
			 */
			foreach( $cart_items as $i => $cartItem ){
				$goods_num += $cartItem->getGoodsNum();
			}

			// 主表订单创建
			$order_id = $order_model->addOrder( [
				'sn'                   => $this->makeOrderSn( $order_pay_id ),
                'pay_sn'               => $pay_sn,
                'user_id'              => $user['id'],
                'user_name'            => $user['username'],
                'user_phone'           => $address->getMobilePhone(),
                'state'                => \App\Logic\Order::state_new,
                'amount'               => $calculateResult->getPayAmount(),
                'freight_fee'          => $calculateResult->getPayFreightFee(),
                'freight_unified_fee'  => $calculateResult->getFreightUnifiedFee(),
                'freight_template_fee' => $calculateResult->getFreightTemplateFee(),
                'goods_amount'         => $calculateResult->getGoodsAmount(),
                'goods_num'            => $goods_num,
                'pay_name'             => $this->getPayName(),
                'create_time'          => time(),
                'payable_time'         => time() + 86400

              ] );
			if( !$order_id ){
				$cart_model->rollback();
				throw new \Exception( '订单保存失败' );
			} else{
				$this->setOrderId( $order_id );
			}
			// 拓展订单表创建
			$state = model('OrderExtend')->insertOrderExtend( [
				'id'                  => $order_id,
				'reciver_info'        => [
                    'name'           => $address->getTruename(),
                    'combine_detail' => $address->getCombineDetail(),
                    'phone'          => $address->getMobilePhone(),
                    'type'           => $address->getType(),
                    'address'        => $address->getAddress(),
                ],
				'reciver_name'        => $address->getTruename(),
				'receiver_phone'      => $address->getMobilePhone(),
				'reciver_province_id' => $address->getProvinceId(),
				'reciver_city_id'     => $address->getCityId(),
				'reciver_area_id'     => $address->getAreaId(),
			] );
			if( !$state ){
				$cart_model->rollback();
				throw new \Exception( '订单拓展保存失败' );
			}
			$cart_ids = [];
			/**
			 * @var \App\Logic\Server\Cart\Item $cartItem ;
			 */
			foreach( $cart_items as $i => $cartItem ){
				$cart_ids[]    = $cartItem->getId();
				$order_goods[] = [
					'order_id'          => $order_id,
					'goods_id'          => $cartItem->getGoodsId(),
					'goods_sku_id'      => $cartItem->getGoodsSkuId(),
					'goods_title'       => $cartItem->getGoodsTitle(),
                    'goods_spec'        => $cartItem->getGoodsSpec(),
					'goods_price'       => $cartItem->getGoodsPrice(),
					'goods_pay_price'   => $cartItem->getGoodsPrice(), //暂时先用商品金额 这需要考虑优惠券 满减等 如果运费是单独goods_freight_fee字段 则不需要考虑运费
					'goods_num'         => $cartItem->getGoodsNum(),
					'goods_img'         => $cartItem->getGoodsImg(),
					'goods_freight_fee' => $cartItem->getGoodsFreightFee(),
					'goods_freight_way' => $cartItem->getGoodsFreightWay(),
					'user_id'           => $this->getUserId(),
					'create_time'       => time(),
					'goods_type'        => 1,
				];
			}
			// 订单商品创建
			$order_goods_insert = model( 'OrderGoods' )->addOrderGoodsAll( $order_goods );
			if( !$order_goods_insert ){
				$cart_model->rollback();
				throw new \Exception( '订单商品保存失败' );
			}
			// 订单日志记录
			model( 'OrderLog' )->addOrderLog( [
				'order_id'    => $this->getOrderId(),
				'msg'         => '买家下单',
				'role'        => 'buyer',
				'order_state' => \App\Logic\Order::state_pay,
			] );
			// 更新商品库存
			$this->updateGoodsStorageNum();
			$cart_model->commit();
			$cart_model->delCart( [
				'user_id' => $this->getUserId(),
				'id'      => ['in', $cart_ids],
			] );
			return new CreateOrderResult( ['order_id' => $order_id, 'pay_sn' => $pay_sn] );
		} catch( \Exception $e ){
			$cart_model->rollback();
			\ezswoole\Log::write( $this->errMsg );
		}
	}

	/**
	 * 更新商品主表销量和库存
	 * @throws \Exception
	 */
	private function updateGoodsStorageNum() : void
	{

		$cart_items            = $this->getCartItems();
		$goods_sku_update_data = [];
		$goods_data            = [];
		/**
		 * @var \App\Logic\Server\Cart\Item $sku_item ;
		 */
		foreach( $cart_items as $key => $sku_item ){
			// 同一款产品的sku数据相加更新到主表
			$goods_id = $sku_item->getGoodsId();
			if( isset( $goods_data[$goods_id] ) ){
				$goods_data[$goods_id] = [
					'sale_num' => $goods_data[$goods_id]['sale_num'] + $sku_item->getGoodsNum(),
				];
			} else{
				$goods_data[$goods_id] = [
					'id'       => $goods_id,
					'sale_num' => $sku_item->getGoodsNum(),
				];
			}
			// 每个sku数据
			$goods_sku_update_data[] = [
				'id'       => $sku_item->getGoodsSkuId(),
				'stock'    => ['exp', 'stock-'.$sku_item->getGoodsNum()],
				'sale_num' => ['exp', 'sale_num+'.$sku_item->getGoodsNum()],
			];
		}
		$state = model( 'GoodsSku' )->updateAllGoodsSku( $goods_sku_update_data );

		if( !$state ){
			throw new \Exception( '更新库存GoodsSku失败' );
		} else{
			$goods_data        = array_values( $goods_data );
			$goods_update_data = [];
			foreach( $goods_data as $goods_item ){
				$goods_update_data[] = [
					'id'       => $goods_item['id'],
					'stock'    => ['exp', 'stock-'.$goods_item['sale_num']],
					'sale_num' => ['exp', 'sale_num+'.$goods_item['sale_num']],
				];
			}
			$state = model( 'Goods' )->updateAllGoods( $goods_update_data );
			if( !$state){
				throw new \Exception( '更新Goods库存失败' );
			}
		}
	}

	/**
	 * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
	 * 长度 =2位 + 10位 + 3位 + 3位  = 18位
	 * 1000个会员同一微秒提订单，重复机率为1/100
	 * @return string
	 */
	public function makePaySn( int $user_id )
	{
		return mt_rand( 10, 99 ).sprintf( '%010d', time() - 946656000 ).sprintf( '%03d', (float)microtime() * 1000 ).sprintf( '%03d', (int)$user_id % 1000 );
	}

	/**
	 * 订单编号生成规则，n(n>=1)个订单表对应一个支付表，
	 * 生成订单编号(年取1位 + $pay_id取13位 + 第N个子订单取2位)
	 * 1000个会员同一微秒提订单，重复机率为1/100
	 * @param string $pay_id 支付表自增ID
	 * @return string
	 */
	public function makeOrderSn( $pay_id )
	{
		// 记录生成子订单的个数，如果生成多个子订单，该值会累加
		static $num;
		if( empty( $num ) ){
			$num = 1;
		} else{
			$num ++;
		}
		return (date( 'y', time() ) % 9 + 1).sprintf( '%013d', $pay_id ).sprintf( '%02d', $num );
	}


}
