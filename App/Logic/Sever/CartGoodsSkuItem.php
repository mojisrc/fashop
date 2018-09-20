<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/16
 * Time: 下午3:51
 *
 */

namespace App\Logic\Sever;

class CartGoodsSkuItem
{
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var string
	 */
	private $title;
	/**
	 * @var float
	 */
	private $price;
	/**
	 * @var int
	 */
	private $num;
	/**
	 * @var string
	 */
	private $img;
	/**
	 * @var int
	 */
	private $goodsId;
	/**
	 * @var array
	 */
	private $spec;
	/**
	 * @var int
	 */
	private $freightId;
	/**
	 * @var array
	 */
	private $freightArea;
	/**
	 * @var float
	 */
	private $weight;
	/**
	 * @var int
	 */
	private $payType;

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
	 * @return string
	 */
	public function getTitle() : string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle( string $title ) : void
	{
		$this->title = $title;
	}

	/**
	 * @return float
	 */
	public function getPrice() : float
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 */
	public function setPrice( float $price ) : void
	{
		$this->price = $price;
	}

	/**
	 * @return int
	 */
	public function getNum() : int
	{
		return $this->num;
	}

	/**
	 * @param int $num
	 */
	public function setNum( int $num ) : void
	{
		$this->num = $num;
	}

	/**
	 * @return string
	 */
	public function getImg() : string
	{
		return $this->img;
	}

	/**
	 * @param string $img
	 */
	public function setImg( string $img ) : void
	{
		$this->img = $img;
	}

	/**
	 * @return int
	 */
	public function getGoodsId() : int
	{
		return $this->goodsId;
	}

	/**
	 * @param int $id
	 */
	public function setGoodsId( int $goodId ) : void
	{
		$this->goodsId = $goodId;
	}

	/**
	 * @return array
	 */
	public function getSpec() : array
	{
		return $this->spec;
	}

	/**
	 * @param array $spec
	 */
	public function setSpec( array $spec ) : void
	{
		$this->spec = $spec;
	}

	/**
	 * @return int
	 */
	public function getFreightId() : int
	{
		return $this->freightId;
	}

	/**
	 * @param int $freightId
	 */
	public function setFreightId( int $freightId ) : void
	{
		$this->freightId = $freightId;
	}

	/**
	 * @return array
	 */
	public function getFreightArea() : array
	{
		return $this->freightArea;
	}

	/**
	 * @param array $freightArea
	 */
	public function setFreight( array $freightArea ) : void
	{
		$this->freightArea = $freightArea;
	}

	/**
	 * @return float
	 */
	public function getWeight() : float
	{
		return $this->weight;
	}

	/**
	 * @param float $weight
	 */
	public function setWeight( float $weight ) : void
	{
		$this->weight = $weight;
	}

	/**
	 * @return int
	 */
	public function getPayType() : int
	{
		return $this->payType;
	}

	/**
	 * @param int $payType
	 */
	public function setPayType( int $payType ) : void
	{
		$this->payType = $payType;
	}

	public function __construct( array $data )
	{
		$this->setId( $data['id'] );
		$this->setTitle( $data['title'] );
		$this->setPrice( $data['price'] );
		$this->setImg( $data['img'] );
		$this->setId( $data['sku_id'] );
		$this->setSpec( $data['spec'] );
		$this->setFreightId( $data['freight_id'] );
		$this->setNum( $data['num'] );
		$this->setWeight( $data['weight'] );
		$this->setFreightArea( $data['freight_area'] );
		$this->setPayType( $data['pay_type'] );
	}
}