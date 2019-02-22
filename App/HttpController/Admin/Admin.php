<?php
/**
 * 后台总控制器
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @author     $this->author
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use App\Biz\Admin\Auth;
use App\HttpController\AccessTokenAbstract;

abstract class Admin extends AccessTokenAbstract
{
	/**
	 * 当访问
	 * @param $actionName
	 */
	protected function onRequest( $actionName ) : ?bool
	{
		parent::onRequest( $actionName );
		if( $this->request->method() === 'OPTIONS' ){
			$this->send( Code::success );
			$this->response()->end();
			return false;
		} else{
			$this->_initialize();
			// 不需要验证的模块
			$auth = new Auth();
			$rulePath  = strtolower( "{$this->request->controller()}/$actionName" );
			if( !in_array( $rulePath, $auth::$notAuthAction ) ){
				// 令牌通过
				if( $this->verifyResourceRequest() ){
					// 验证该用户的权限
					$user = $this->getRequestUser();
					// 如果是超级管理员 不需要
					if($user['id'] !== 1){
						$auth->setUserId( $user['id'] );
						$auth->setActionName($rulePath);

						// 没有权限
						if( $auth->verify() !== true ){
							$this->send( Code::admin_user_no_auth );
							$this->response()->end();
							return false;
						}else{
							return true;
						}
					}else{
						return true;
					}
				} else{
					// 令牌错误
					$this->send( Code::user_access_token_error );
					$this->response()->end();
					return false;
				}
			}else{
				return true;
			}
		}

	}

	protected function onException( \Throwable $throwable ) : void
	{
		var_dump($throwable->getTraceAsString());
		var_dump( "文件：".$throwable->getFile()."第：".$throwable->getLine()."行" );
		var_dump( "错误原因".$throwable->getMessage() );
		$this->send( Code::server_error, [], $throwable->getTraceAsString() );
		$this->response()->end();
	}

	protected function _initialize()
	{

	}
}
