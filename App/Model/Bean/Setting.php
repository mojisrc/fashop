<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019-02-18
 * Time: 23:35
 *
 */

namespace App\Model\Bean;


class Setting
{
	// 基础的数据库字段
}


class SettingAliPayConfig{
	/**
	 * @var string
	 */
	protected $app_id;
	/**
	 * @var string
	 */
	protected $callback_domain;
	/**
	 * @var string
	 */
	protected $alipay_public_key;
	/**
	 * @var string
	 */
	protected $merchant_private_key;

	/**
	 * @return string
	 */
	public function getAppId() : string
	{
		return $this->app_id;
	}

	/**
	 * @param string $app_id
	 */
	public function setAppId( string $app_id ) : void
	{
		$this->app_id = $app_id;
	}

	/**
	 * @return string
	 */
	public function getCallbackDomain() : string
	{
		return $this->callback_domain;
	}

	/**
	 * @param string $callback_domain
	 */
	public function setCallbackDomain( string $callback_domain ) : void
	{
		$this->callback_domain = $callback_domain;
	}

	/**
	 * @return string
	 */
	public function getAlipayPublicKey() : string
	{
		return $this->alipay_public_key;
	}

	/**
	 * @param string $alipay_public_key
	 */
	public function setAlipayPublicKey( string $alipay_public_key ) : void
	{
		$this->alipay_public_key = $alipay_public_key;
	}

	/**
	 * @return string
	 */
	public function getMerchantPrivateKey() : string
	{
		return $this->merchant_private_key;
	}

	/**
	 * @param string $merchant_private_key
	 */
	public function setMerchantPrivateKey( string $merchant_private_key ) : void
	{
		$this->merchant_private_key = $merchant_private_key;
	}

}