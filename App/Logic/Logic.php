<?php

namespace App\Logic;

// todo 继承接口
abstract class Logic
{
	protected static $instance;

	static function getInstance(){
		return  new static();

//		if(!isset(self::$instance)){
//			self::$instance = new static();
//		}
//		return self::$instance;
	}
	public $error = 0;

	public $errorMsg = '';

	public function getError()
	{
		return $this->send;
	}

	public function getErrorMsg()
	{
		return $this->sendMsg;
	}

}