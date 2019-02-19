<?php
echo microtime()."\n";
$t1 = microtime(true);
$data = [
	'config'=>[
		'x'=>1,
		'xx'=>2,
		'xxx'=>3,
		'xxxx'=>4
	]
];
$class = [];
for($i=0;$i<500;$i++){
	$class[] = new SettingAliPayConfig();
}

$t2 = microtime(true);
echo '耗时'.round($t2-$t1,3)."秒，".($t2-$t1)."\n";
echo 'Now memory_get_usage: ' . memory_usage() . "\n";



Class SettingConfig{
	function __construct()
	{
	}
}

function memory_usage() {
	$memory     = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
	return $memory;
}



class SettingAliPayConfig
{
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