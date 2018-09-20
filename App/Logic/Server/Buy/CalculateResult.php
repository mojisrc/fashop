<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/6
 * Time: 下午8:06
 *
 */

namespace App\Logic\Server\Buy;


class CalculateResult
{
	/**
	 * @var float
	 */
	private $goodsAmount;
	/**
	 * @var float
	 */
	private $payAmount;
	/**
	 * @var array
	 */
	private $goodsFreightList;
	/**
	 * @var float
	 */
	private $freightUnifiedFee;
	/**
	 * @var float
	 */
	private $freightTemplateFee;
	/**
	 * @var float
	 */
	private $payFreightFee;

	/**
	 * @return float
	 */
	public function getGoodsAmount() : float
	{
		return $this->goodsAmount;
	}

	/**
	 * @param float $goodsAmount
	 */
	public function setGoodsAmount( float $goodsAmount ) : void
	{
		$this->goodsAmount = $goodsAmount;
	}

	/**
	 * @return float
	 */
	public function getPayAmount() : float
	{
		return $this->payAmount;
	}

	/**
	 * @param float $payAmount
	 */
	public function setPayAmount( float $payAmount ) : void
	{
		$this->payAmount = $payAmount;
	}

	/**
	 * @return array
	 */
	public function getGoodsFreightList() : array
	{
		return $this->goodsFreightList;
	}

	/**
	 * @param array $goodsFreightList
	 */
	public function setGoodsFreightList( array $goodsFreightList ) : void
	{
		$this->goodsFreightList = $goodsFreightList;
	}

	/**
	 * @return float
	 */
	public function getFreightUnifiedFee() : float
	{
		return $this->freightUnifiedFee;
	}

	/**
	 * @param float $freightUnifiedFee
	 */
	public function setFreightUnifiedFee( float $freightUnifiedFee ) : void
	{
		$this->freightUnifiedFee = $freightUnifiedFee;
	}

	/**
	 * @return float
	 */
	public function getFreightTemplateFee() : float
	{
		return $this->freightTemplateFee;
	}

	/**
	 * @param float $freightTemplateFee
	 */
	public function setFreightTemplateFee( float $freightTemplateFee ) : void
	{
		$this->freightTemplateFee = $freightTemplateFee;
	}

	/**
	 * @return float
	 */
	public function getPayFreightFee() : float
	{
		return $this->payFreightFee;
	}

	/**
	 * @param float $payFreightFee
	 */
	public function setPayFreightFee( float $payFreightFee ) : void
	{
		$this->payFreightFee = $payFreightFee;
	}

	public function __construct( array $data )
	{
		$this->setGoodsAmount( $data['goods_amount'] );
		$this->setPayAmount( $data['pay_amount'] );
		$this->setGoodsFreightList( $data['goods_freight_list'] );
		$this->setFreightUnifiedFee( $data['freight_unified_fee'] );
		$this->setFreightTemplateFee( $data['freight_template_fee'] );
		$this->setPayFreightFee( $data['pay_freight_fee'] );
	}
}