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

namespace App\Logic\Sever;


class CartItem
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

	public function __construct( array $options )
	{
		$this->setGoodsSkuId( $options['goods_sku_id'] );
		$this->setGoodsTitle( $options['goods_title'] );
		$this->setGoodsPrice( $options['goods_price'] );
		$this->setGoodsNum( $options['goods_num'] );
		$this->setGoodsPrice( $options['goods_price'] );
		$this->setGoodsId( $options['goods_id'] );
		$this->setGoodsSpec( $options['goods_spec'] );
	}
}