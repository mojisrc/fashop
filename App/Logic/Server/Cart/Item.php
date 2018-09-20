<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/16
 * Time: 下午3:38
 *
 */

namespace App\Logic\Server\Cart;

class Item
{
	/**
	 * @var int
	 */
	private $goodsSkuId;
	/**
	 * @var string
	 */
	private $goodsTitle;
	/**
	 * @var float
	 */
	private $goodsPrice;
	/**
	 * @var int
	 */
	private $goodsNum;
	/**
	 * @var string
	 */
	private $goodsImg;
	/**
	 * @var int
	 */
	private $goodsId;
	/**
	 * @var array
	 */
	private $goodsSpec;

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

	/**
	 * @return float
	 */
	public function getGoodsPrice() : float
	{
		return $this->goodsPrice;
	}

	/**
	 * @param float $goodsPrice
	 */
	public function setGoodsPrice( float $goodsPrice ) : void
	{
		$this->goodsPrice = $goodsPrice;
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
	 * @return string
	 */
	public function getGoodsImg() : string
	{
		return $this->goodsImg;
	}

	/**
	 * @param string $goodsImg
	 */
	public function setGoodsImg( string $goodsImg ) : void
	{
		$this->goodsImg = $goodsImg;
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
	 * @return array
	 */
	public function getGoodsSpec() : array
	{
		return $this->goodsSpec;
	}

	/**
	 * @param array $goodsSpec
	 */
	public function setGoodsSpec( array $goodsSpec ) : void
	{
		$this->goodsSpec = $goodsSpec;
	}

	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var int
	 */
	private $goodsFreightId;
	/**
	 * @var float
	 */
	private $goodsWeight;
	/**
	 * todo 写个Item模板出来
	 * @var array
	 */
	private $goodsFreightArea;
	/**
	 * @var float
	 */
	private $goodsFreightFee;
	/**
	 * @var int
	 */
	private $goodsPayType;
	/**
	 * @var string
	 */
	private $goodsFreightWay;

	/**
	 * @return int
	 */
	public function getId() : int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId( int $id ) : void
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getGoodsFreightId() : int
	{
		return $this->goodsFreightId;
	}

	/**
	 * @param int $goodsFreightId
	 */
	public function setGoodsFreightId( int $goodsFreightId ) : void
	{
		$this->goodsFreightId = $goodsFreightId;
	}

	/**
	 * @return float
	 */
	public function getGoodsWeight() : float
	{
		return $this->goodsWeight;
	}

	/**
	 * @param float $goodsWeight
	 */
	public function setGoodsWeight( float $goodsWeight ) : void
	{
		$this->goodsWeight = $goodsWeight;
	}

	/**
	 * @return array
	 */
	public function getGoodsFreightArea() : array
	{
		return $this->goodsFreightArea;
	}

	/**
	 * @param array $goodsFreightArea
	 */
	public function setGoodsFreightArea( array $goodsFreightArea ) : void
	{
		$this->goodsFreightArea = $goodsFreightArea;
	}

	/**
	 * @return float
	 */
	public function getGoodsFreightFee() : float
	{
		return $this->goodsFreightFee;
	}

	/**
	 * @param float $goodsFreightFee
	 */
	public function setGoodsFreightFee( float $goodsFreightFee ) : void
	{
		$this->goodsFreightFee = $goodsFreightFee;
	}

	/**
	 * @return int
	 */
	public function getGoodsPayType() : int
	{
		return $this->goodsPayType;
	}

	/**
	 * @param int $goodsPayType
	 */
	public function setGoodsPayType( int $goodsPayType ) : void
	{
		$this->goodsPayType = $goodsPayType;
	}

	/**
	 * @return string
	 */
	public function getGoodsFreightWay() : string
	{
		return $this->goodsFreightWay;
	}

	/**
	 * @param string $goodsFreightWay
	 */
	public function setGoodsFreightWay( string $goodsFreightWay ) : void
	{
		$this->goodsFreightWay = $goodsFreightWay;
	}

	public function __construct( array $options )
	{
		$this->setId( $options['id'] );
		$this->setGoodsSkuId( $options['goods_sku_id'] );
		$this->setGoodsTitle( $options['goods_title'] );
		$this->setGoodsPrice( $options['goods_price'] );
		$this->setGoodsNum( $options['goods_num'] );
		$this->setGoodsPrice( $options['goods_price'] );
		$this->setGoodsId( $options['goods_id'] );
		$this->setGoodsSpec( $options['goods_spec'] );
		$this->setGoodsImg( $options['goods_sku_img'] );

		// 运费模板
		$this->setGoodsFreightId( $options['goods_freight_id'] );
		$this->setGoodsWeight( $options['goods_weight'] );

		if(isset($options['goods_freight_areas'])){
			$goods_freight_areas = json_decode($options['goods_freight_areas'], true);

		}else{
			$goods_freight_areas = array();

		}

		$this->setGoodsFreightArea( $goods_freight_areas );

		$this->setGoodsPayType( intval($options['goods_pay_type']) );

		// 统一运费
		$this->setGoodsFreightFee( $options['goods_freight_fee'] );

		// 运费计算方式
		if( $options['goods_freight_id'] > 0 ){
			$this->setGoodsFreightWay( 'goods_freight_template' );
		} else{
			$this->setGoodsFreightWay( 'goods_freight_unified' );
		}
	}

	/**
	 * 根据地址计算运费
	 * @param Address $addressItem
	 * @return float
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function freightFeeByAddress( Address $addressItem ) : float
	{
		if( $this->getGoodsFreightWay() === 'freight_template' ){
			$freight_areas = $this->getGoodsFreightArea();
			foreach( $freight_areas as $area ){
				if( in_array( $addressItem['area_id'], $area['area_ids'] ) ){
					$algorithm = $area;
					break;
				}
			}
			if( empty( $algorithm ) ){
				foreach( $freight_areas as $area ){
					if( in_array( $addressItem['city_id'], $area['area_ids'] ) ){
						$algorithm = $area;
						break;
					}
				}
			}
			if( empty( $algorithm ) ){
				foreach( $freight_areas as $area ){
					if( in_array( $addressItem['province_id'], $area['area_ids'] ) ){
						$algorithm = $area;
					} else{
						throw new \Exception( "【{$this->getId()}】{$this->getGoodsTitle()} 的运费模板不存在" );
					}
				}
			}
			$first_amount      = $algorithm['first_amount'];
			$first_fee         = $algorithm['first_fee'];
			$additional_amount = $algorithm['additional_amount'];
			$additional_fee    = $algorithm['additional_fee'];

			if( $this->getGoodsPayType() == 2 ){
				$weight = $this->getGoodsWeight() * $this->getGoodsNum();
				if( intval( $weight ) <= 0 ){
					throw new \Exception( "重量不可能为0" );
				} else{
					return $first_fee + ceil( ($weight - $first_amount) / $additional_amount ) * $additional_fee;
				}
			} else{
				if( intval( $this->getGoodsNum() ) <= 0 ){
					throw new \Exception( "个数不可能为0" );
				} else{
					return $first_fee + ceil( ($this->getGoodsNum() - $first_amount) / $additional_amount ) * $additional_fee;
				}
			}
		} elseif( $this->getGoodsFreightWay() === 'freight_unified' ){
			return $this->getGoodsFreightFee();
		} else{
			return 0.00;
		}
	}
}