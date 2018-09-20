<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/6
 * Time: 下午10:36
 *
 */

namespace App\Logic\Server\Buy;


class CreateOrderResult
{
	/**
	 * @var string
	 */
	private $orderId;
	/**
	 * @var string
	 */
	private $paySn;

	/**
	 * @return string
	 */
	public function getOrderId() : string
	{
		return $this->orderId;
	}

	/**
	 * @param string $orderId
	 */
	public function setOrderId( string $orderId ) : void
	{
		$this->orderId = $orderId;
	}

	/**
	 * @return string
	 */
	public function getPaySn() : string
	{
		return $this->paySn;
	}

	/**
	 * @param string $paySn
	 */
	public function setPaySn( string $paySn ) : void
	{
		$this->paySn = $paySn;
	}

	public function __construct($data)
	{
		$this->setPaySn($data['pay_sn']);
		$this->setOrderId($data['order_id']);
	}
}