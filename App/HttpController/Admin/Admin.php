<?php
/**
 * 后台总控制器
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @author     $this->author
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use ezswoole\Request;
use App\Utils\Code;
use App\Logic\Admin\Auth as AuthLogic;
use App\HttpController\AccessTokenAbstract;

abstract class Admin extends AccessTokenAbstract
{
	/**
	 * 当访问
	 * @param $actionName
	 */
	protected function onRequest( $actionName ) : ?bool
	{
		parent::onRequest($actionName);
		$this->request = Request::getInstance();
		if( $this->request->method() === 'OPTIONS' ){
			$this->send( Code::success );
			$this->response()->end();
			return false;
		}else{
			parent::onRequest( $actionName );
			$this->_initialize();

			// 不需要验证的模块
			$authLogic = new AuthLogic();
			$rulePath = strtolower( "{$this->request->controller()}/$actionName" );
			if( !in_array( $rulePath, $authLogic::$notAuthAction ) ){
				if( $this->verifyResourceRequest() ){
					$user = $this->getRequestUser();
					$authLogic->setUserId( $user['id'] );
					if( $authLogic->checkUserNodeAuth( $rulePath ) !== true ){
						$this->send( Code::admin_user_no_auth );
						$this->response()->end();
						return false;
					}
				}else{
					$this->send( Code::user_access_token_error );
					$this->response()->end();
					return false;
				}
			}
			return true;
		}

	}

	/**
	 * @param \Throwable $throwable
	 * @param            $actionName
	 * @throws \Throwable
	 * @author 韩文博
	 */
	protected function onException(\Throwable $throwable,$actionName):void
	{
		$this->send(Code::server_error,[],$throwable->getFile()." - ".$throwable->getLine(). " - ". $throwable->getMessage());
		$this->response()->end();
	}

	protected function _initialize(){

	}
}
