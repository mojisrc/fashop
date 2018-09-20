<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/1
 * Time: 下午4:44
 *
 */

namespace App\Logic\Wechat\AbstractInterface;

/**
 * Class BaseAbstract
 * @package App\Logic\Wechat\AbstractInterface
 * @property  \EasyWeChat\OfficialAccount\Application $app
 */
abstract class BaseAbstract
{
	protected $app;

	final function __construct()
	{

	}

	final function setApp( $app ) : void
	{
		$this->app = $app;
	}

	final function getApp()
	{
		$this->app;
	}
}