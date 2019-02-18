<?php
/**
 * 拼团购买模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic\Server\Group;

use App\Logic\Server\Cart\Address;
use App\Logic\Server\Cart\Item;

class Buy
{
	/**
	 * @var array
	 */
	private $data;
	/**
	 * @var int
	 */
	private $goodsSkuId;
	/**
	 * @var int
	 */
	private $goodsId;
	/**
	 * @var int
	 */
	private $groupId;
	/**
	 * @var int
	 */
	private $goodsNumber;
	/**
	 * 购买方式 single_buy[单独购买] open_group[自己开团] join_group[参与他人团]
	 * @var string
	 */
	private $buyWay;
	/**
	 * @var int
	 */
	private $orderId;
	/**
	 * @var int
	 */
	private $addressId;
	/**
	 * @var int
	 */
	private $userId;

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
	 * @var Address
	 */
	private $addressInfo;

	/**
	 * @return int
	 */
	public function getGoodsSkuId() : int
	{
		return $this->goodsSkuId;
	}

	/**
	 * @param int $goodsSkuId
	 */
	public function setGoodsSkuId( int $goodsSkuId ) : void
	{
		$this->goodsSkuId = $goodsSkuId;
	}

	/**
	 * @return int
	 */
	public function getGoodsId() : int
	{
		return $this->goodsId;
	}

	/**
	 * @param int $goodsId
	 */
	public function setGoodsId( int $goodsId ) : void
	{
		$this->goodsId = $goodsId;
	}

	/**
	 * @return int
	 */
	public function getGroupId() : int
	{
		return $this->groupId;
	}

	/**
	 * @param int $groupId
	 */
	public function setGroupId( int $groupId ) : void
	{
		$this->groupId = $groupId;
	}

	/**
	 * @return int
	 */
	public function getGoodsNumber() : int
	{
		return $this->goodsNumber;
	}

	/**
	 * @param int $goodsNumber
	 */
	public function setGoodsNumber( int $goodsNumber ) : void
	{
		$this->goodsNumber = $goodsNumber;
	}

	/**
	 * @return int
	 */
	public function getBuyWay() : string
	{
		return $this->buyWay;
	}

	/**
	 * @param int $buyWay
	 */
	public function setBuyWay( string $buyWay ) : void
	{
		$this->buyWay = $buyWay;
	}

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
	 * @return array
	 */
	public function getGroup() : array
	{
		return $this->group;
	}

	/**
	 * @param array $group
	 */
	public function setGroup( array $group ) : void
	{
		$this->group = $group;
	}

	/**
	 * @return array
	 */
	public function getGroupGoods() : array
	{
		return $this->groupGoods;
	}

	/**
	 * @param array $groupGoods
	 */
	public function setGroupGoods( array $groupGoods ) : void
	{
		$this->groupGoods = $groupGoods;
	}

	/**
	 * @return array
	 */
	public function getCaptainGroupOrder() : array
	{
		return $this->captainGroupOrder;
	}

	/**
	 * @param array $captainGroupOrder
	 */
	public function setCaptainGroupOrder( array $captainGroupOrder ) : void
	{
		$this->captainGroupOrder = $captainGroupOrder;
	}

	/**
	 * @return float
	 */
	public function getGoodsGroupPrice() : float
	{
		return $this->goodsGroupPrice;
	}

	/**
	 * @param float $goodsGroupPrice
	 */
	public function setGoodsGroupPrice( float $goodsGroupPrice ) : void
	{
		$this->goodsGroupPrice = floatval( sprintf( "%.2f", $goodsGroupPrice ) );
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
		$this->setGoodsSkuId( $data['goods_sku_id'] );
		$this->setGoodsId( $data['goods_id'] );
		$this->setGroupId( $data['group_id'] );
		$this->setGoodsNumber( $data['goods_number'] );
		$this->setBuyWay( $data['buy_way'] );
		$this->setOrderId( $data['order_id'] );
		$this->setAddressId( $data['address_id'] );
		$this->setUserId( $data['user_id'] );
		$this->setUserInfo( $data['user_info'] );
		$address_info = model( 'Address' )->getAddressInfo( [
			'id'      => $this->getAddressId(),
			'user_id' => $this->getUserId(),
		] );
		$cart_address = new Address( $address_info );//用的商城的购物车地址类
		$this->setAddressInfo( $cart_address );
		if( $address_info['user_id'] != $data['user_id'] ){
			throw new \Exception( '收货地址错误' );
		}

		//拼团活动
		$group = \App\Model\Group::getGroupInfo( ['id' => $this->getGroupId(), 'is_show' => 1, 'start_time' => ['<=', time()]] );
		if( !$group ){
			throw new \Exception( '拼团活动错误' );
		}
		if( $group['limit_goods_num'] > 0 && $this->getGoodsNumber() > $group['limit_goods_num'] ){
			throw new \Exception( '单次拼团最多可拼'.$group['limit_goods_num'].'件' );
		}
		$this->setGroup( $group );

		//拼团商品
		$group_goods = \App\Model\GroupGoods::getGroupGoodsInfo( ['group_id' => $this->getGroupId(), 'goods_id' => $this->getGoodsId(), 'goods_sku_id' => $this->getGoodsSkuId()], '', '*' );
		if( !$group_goods ){
			throw new \Exception( '拼团商品错误' );
		}
		$this->setGroupGoods( $group_goods );

		//拼团订单
		$group_order_num = \App\Model\Order::init()->getOrderInfo( ['user_id' => $this->getUserId(), 'group_id' => $this->getGroupId(), 'group_state' => ['in', '0,1,2']], 'COUNT(id) AS group_num', [] );
		if( $group['limit_group_num'] > 0 && $group_order_num > $group['limit_group_num'] ){
			throw new \Exception( '此活动每位用户最多拼团'.$group['limit_group_num'].'次' );
		}

		if( $this->getBuyWay() == 'join_group' ){
			$captain_group_order = \App\Model\Order::init()->getOrderInfo( ['id' => $this->getOrderId(), 'group_id' => $this->getGroupId(), 'group_state' => 1], '*', [] );
			if( !$captain_group_order ){
				throw new \Exception( '团长订单信息错误' );
			}
			if( $captain_group_order['group_men_num'] >= $captain_group_order['group_people_num'] ){
				throw new \Exception( '团已满' );
			}
			if( intval( $captain_group_order['user_id'] ) == $this->getUserId() ){
				throw new \Exception( '不可加入自己的团' );
			}
			$this->setCaptainGroupOrder( $captain_group_order );

			$goods_group_price = $group_goods['group_price'];
		} else{
			if( $group['end_time'] < time() ){
				throw new \Exception( '拼团活动过期，不可开团' );
			}
			$goods_group_price = $group_goods['captain_price'];
		}
		$this->setGoodsGroupPrice( $goods_group_price );
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function getItems()
	{
		$info = $this->goodsInfo();
		if( $this->getGoodsNumber() > $info['goods_stock'] ){
			throw new \Exception( "SKU ID {$info['goods_sku_id']} {$info['goods_title']} 库存不足，现有库存{$info['goods_stock']}，实际购买".$this->getGoodsNumber() );
		} else{
			$info['goods_num'] = $this->getGoodsNumber();
			$goods             = new Item( $info );
		}
		return $goods;
	}

	/**
	 * 计算
	 * @throws \Exception
	 * @return \App\Logic\Server\Buy\CalculateResult
	 * @author 孙泉
	 */
	public function calculate() : \App\Logic\Server\Buy\CalculateResult
	{
		$goods       = $this->getItems();
		$address     = $this->getAddressInfo();
		// 根据运费计算规则一
		$freight_unified_fee  = 0;
		$freight_template_fee = 0;
		$goods_amount         = 0;
		$goods_group_amount   = 0;

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
		$goods_amount       += $goods->getGoodsPrice() * $goods->getGoodsNum();
		$goods_group_amount += $this->getGoodsGroupPrice() * $goods->getGoodsNum();

		$pay_freight_fee = $freight_unified_fee + $freight_template_fee;

		return new \App\Logic\Server\Buy\CalculateResult( [
			'goods_amount'         => $goods_amount,
			'goods_group_amount'   => $goods_group_amount,
			'pay_amount'           => $goods_group_amount + $pay_freight_fee,
			'goods_freight_list'   => $goods_freight,
			'freight_unified_fee'  => $freight_unified_fee,
			'freight_template_fee' => $freight_template_fee,
			'pay_freight_fee'      => $pay_freight_fee,
		] );
	}

	/**
	 * 创建订单
	 * @author   孙泉
	 * @throws \Exception
	 */
	public function createOrder() : \App\Logic\Server\Buy\CreateOrderResult
	{
		\App\Model\Order::startTransaction();

		try{
			$group       = $this->getGroup();
			$group_goods = $this->getGroupGoods();

			switch( $this->getBuyWay() ){
			case 'open_group':
				$group_identity   = 1; //1 团长 2 团员
				$group_sign       = 0; //一个团拥有相同的值（团购编号）
				$group_people_num = $group['limit_buy_num']; //团共需人数 几人团
				$group_men_num    = 1; //团现有人数
				$group_state      = 0; //团购状态 0待付款 1正在进行中(待开团) 2拼团成功 3拼团失败
				$group_start_time = time(); //团购开始时间
				$group_end_time   = time() + $group['time_over_day'] * 86400 + $group['time_over_hour'] * 3600 + $group['time_over_minute'] * 60; //团购结束时间

			break;
			case 'join_group':
				$captain_group_order = $this->getCaptainGroupOrder(); //团长订单
				$group_identity      = 2; //1 团长 2 团员
				$group_sign          = $this->getOrderId(); //一个团拥有相同的值（团购编号）
				$group_people_num    = $captain_group_order['group_people_num']; //团共需人数 几人团
				$group_men_num       = $captain_group_order['group_men_num'] + 1; //团现有人数
				$group_state         = 0; //团购状态 0待付款 1正在进行中(待开团) 2拼团成功 3拼团失败
				$group_start_time    = $captain_group_order['group_start_time']; //团购开始时间
				$group_end_time      = $captain_group_order['group_end_time']; //团购结束时间
			break;
			}

			$user         = $this->getUserInfo();
			$pay_sn       = $this->makePaySn( $this->getUserId() );
			$order_pay_id = \App\Model\OrderPay::init()->addOrderPay( [
				'pay_sn'    => $pay_sn,
				'user_id'   => $this->getUserId(),
				'pay_state' => 0,

			] );
			if( !$order_pay_id ){
				\App\Model\Order::rollback();
				throw new \Exception( '订单支付记录保存失败' );
			}
			$address = $this->getAddressInfo();

			$calculateResult = $this->calculate();
			$goods           = $this->getItems();
			$goods_num       = $goods->getGoodsNum();

			// 主表订单创建
			$order    = [
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
				'payable_time'         => time() + 86400,
				'goods_type'           => 2,
				'group_id'             => $this->getGroupId(),
				'group_identity'       => $group_identity,
				'group_sign'           => $group_sign,
				'group_people_num'     => $group_people_num,
				'group_men_num'        => $group_men_num,
				'group_state'          => $group_state,
				'group_start_time'     => $group_start_time,
				'group_end_time'       => $group_end_time,
				'goods_group_amount'   => $calculateResult->getGoodsGroupAmount(),
			];
			$order_id = \App\Model\Order::init()->addOrder( $order );
			if( !$order_id ){
				\App\Model\Order::rollback();
				throw new \Exception( '订单保存失败' );
			} else{
				$this->setOrderId( $order_id );
			}

			//订单回写
			switch( $this->getBuyWay() ){
			case 'open_group':
				$order_update_condition['id']    = $order_id;
				$order_update_data['group_sign'] = $order_id;
			break;
			case 'join_group':
				$order_update_condition['group_sign'] = $group_sign;
				$order_update_condition['id']         = ['!=', $order_id];
				$order_update_data['group_men_num']   = $order['group_men_num'];
			break;
			}
			$order_update_result = \App\Model\Order::init()->editOrder( $order_update_condition, $order_update_data );
			if( !$order_update_result ){
				\App\Model\Order::rollback();
				throw new \Exception( '订单拓展保存失败' );
			}

			// 拓展订单表创建
			$order_extend = [
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
			];
			$state        = \App\Model\OrderExtend::init()->addOrderExtend( $order_extend );
			if( !$state ){
				\App\Model\Order::rollback();
				throw new \Exception( '订单拓展保存失败' );
			}
			$order_goods[] = [
				'order_id'          => $order_id,
				'goods_id'          => $goods->getGoodsId(),
				'goods_sku_id'      => $goods->getGoodsSkuId(),
				'goods_title'       => $goods->getGoodsTitle(),
				'goods_spec'        => $goods->getGoodsSpec(),
				'goods_price'       => $goods->getGoodsPrice(),
				'goods_pay_price'   => $this->getGoodsGroupPrice() * $goods->getGoodsNum(),
				'goods_num'         => $goods->getGoodsNum(),
				'goods_img'         => $goods->getGoodsImg(),
				'goods_freight_fee' => $goods->getGoodsFreightFee(),
				'goods_freight_way' => $goods->getGoodsFreightWay(),
				'user_id'           => $this->getUserId(),
				'create_time'       => time(),
				'goods_type'        => 2,
				'group_price'       => $group_goods['group_price'],
				'captain_price'     => $group_goods['captain_price'],

			];

			// 订单商品创建
			$order_goods_insert = model( 'OrderGoods' )->addOrderGoods( $order_goods );
			if( !$order_goods_insert ){
				\App\Model\Order::rollback();
				throw new \Exception( '订单商品保存失败' );
			}
			// 订单日志记录
			\App\Model\OrderLog::init()->addOrderLog( [
				'order_id'    => $this->getOrderId(),
				'msg'         => '买家下单',
				'role'        => 'buyer',
				'order_state' => \App\Logic\Order::state_pay,
			] );
			// 更新商品库存
			$this->updateGoodsStorageNum();
			\App\Model\Order::commit();
			return new \App\Logic\Server\Buy\CreateOrderResult( ['order_id' => $order_id, 'pay_sn' => $pay_sn] );
		} catch( \Exception $e ){
			\App\Model\Order::rollback();
			\EasySwoole\EasySwoole\Logger::getInstance()->log( $this->errMsg );
		}
	}

	/**
	 * 更新商品主表销量和库存
	 * @throws \Exception
	 */
	private function updateGoodsStorageNum() : void
	{
		$goods        = $this->getItems();
		$goods_id     = $goods->getGoodsId();
		$goods_sku_id = $goods->getGoodsSkuId();
		$goods_num    = $goods->getGoodsNum();

		// sku数据
		$goods_sku_condition['id'] = $goods_sku_id;
		$goods_sku_update_data     = [
			'stock'    => ['exp', 'stock-'.$goods_num],
			'sale_num' => ['exp', 'sale_num+'.$goods_num],
		];
		$goods_result              = \App\Model\GoodsSku::init()->editGoodsSku( $goods_sku_condition, $goods_sku_update_data );
		if( !$goods_result ){
			throw new \Exception( '更新库存GoodsSku失败' );
		} else{
			$goods_condition['id'] = $goods_id;
			$goods_update_data     = [
				'stock'    => ['exp', 'stock-'.$goods_num],
				'sale_num' => ['exp', 'sale_num+'.$goods_num],
			];
			$goods_sku_result      = \App\Model\Goods::init()->editGoods( $goods_condition, $goods_update_data );
			if( !$goods_sku_result ){
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

	/**
	 * @throws \ezswoole\db\exception\DataNotFoundException
	 * @throws \ezswoole\db\exception\ModelNotFoundException
	 * @throws \ezswoole\exception\DbException
	 * @author 孙泉
	 */
	public function goodsInfo( array $condition = [] )
	{
		$condition['goods_sku.id'] = $this->getGoodsSkuId();
		$field_array               = [
			'goods_sku.id',
			'goods_sku.id as goods_sku_id',
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
		$field                     = implode( ",", $field_array );
		$info                      = \App\Model\GoodsSku::alias( 'goods_sku' )->join( 'goods', 'goods_sku.goods_id = goods.id', "LEFT" )->join( 'freight', 'goods.freight_id = freight.id', "LEFT" )->field( $field )->where( $condition )->group( 'goods_sku_id' )->find();
		return $info;
	}

}
