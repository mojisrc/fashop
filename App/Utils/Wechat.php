<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/26
 * Time: 下午9:06
 *
 */

namespace App\Utils;
use EasyWeChat\Factory;

class Wechat
{
	protected static $instance;
	protected $application;
	static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance = new static();
		}
		return self::$instance;
	}

	public function __construct($config = null)
	{
		if(empty($config)){
			$config = \EasySwoole\Config::getInstance()->getConf('wechat');
		}

		$application = Factory::officialAccount($config);
		$application->request->setFactory(\App\Utils\Request::createFromGlobals());
		$this->application = $application;
	}
	public function getApplication(){
		return $this->application;
	}
}