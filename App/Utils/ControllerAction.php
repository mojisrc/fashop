<?php
/**
 * 生成文档类
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @author     韩文博
 * @since      File available since Release v1.1
 */

namespace App\Utils;

class ControllerAction
{
	private $module;
	private $controller;
	private $namespace;
	private $inherents_functions;

	private $path;

	/**
	 * 构造函数
	 */
	public function __construct( $module )
	{
		$this->inherents_functions = [
			'index',
			'_before_index',
			'_after_index',
			'_initialize',
			'__construct',
			'getActionName',
			'isAjax',
			'display',
			'show',
			'fetch',
			'buildHtml',
			'assign',
			'__set',
			'get',
			'__get',
			'__isset',
			'__call',
			'error',
			'success',
			'ajaxReturn',
			'redirect',
			'__destruct',
			'_empty',
			'apiReturn',
			'lists',
			'tpl',
			'checkLogin',
			'checkStoreLogin',
			'getRequestUser',
			'onRequest',
			'getRequestAccessToken',
			'getRequestAccessTokenData',
			'verifyResourceRequest',
			'getAccessTokenLogic',
			'actionNotFound',
			'afterAction',
			'router',
			'send',
			'getPageLimit',

		];
		$this->module              = $module;
		$this->controller          = '';
		$this->namespace           = "\\App\\HttpController\\{$this->module}";
		$this->path                = APP_PATH."HttpController/{$this->module}/";
	}

	/**
	 * 获得模块下的控制器列表，去除module自身
	 * @method GET
	 * @author 韩文博
	 */
	public function getControllerNameList()
	{
		$list = $this->getAllFiles( $this->path );
		foreach( $list as $key => $file ){
			$list[$key] = basename( $file, '.php' );
			if( $list[$key] == '.' || $list[$key] == '..' || $list[$key] == $this->module ){
				unset( $list[$key] );
			}
		}
		return array_values( $list );
	}

	/**
	 * 获取指定目录文件夹下所有的文件
	 */
	private function getAllFiles( $dir )
	{
		// 取出文件或者文件夹
		$list      = scandir( $dir );
		$files_arr = [];
		foreach( $list as $key => $file ){
			$location_dir = $dir.$file;
			$files_arr[]  = $location_dir;
			// 判断是否是文件夹 是就调用自身函数再去进行处理
			if( is_dir( $location_dir.'/' ) && '.' != $file && '..' != $file ){
				$files_arr = array_merge_recursive( $files_arr, $this->getAllFiles( $location_dir.'/' ) );
			}
		}
		return $files_arr;
	}


	/**
	 * 获得实例化里的所有方法列表
	 * @author   韩文博
	 * @return   array
	 */
	private function getFunctionList( $controllerName )
	{
		try{

			$class_path            = $this->namespace."\\".$controllerName;
			$reflection_controller = new \ReflectionClass( $class_path );

			$controllerComment = $reflection_controller->getDocComment();

			$title_pattern = "/\*\*\s*(?:\*\s*)+([^\n\*]+)/";

			preg_match_all( $title_pattern, $controllerComment, $title_matches, PREG_PATTERN_ORDER );

			if( isset( $title_matches[1][0] ) ){
				$title = str_replace( "\r", '', $title_matches[1][0] );
			} else{
				$title = '';
			}

			$info = [
				'name'      => $controllerName,
				'title'     => $title,
				'namespace' => $reflection_controller->getName(),
				'comment'   => $controllerComment,
				'actions'   => [],
			];


			$_methods_list          = $reflection_controller->getMethods( \ReflectionMethod::IS_PUBLIC );
			foreach($_methods_list as $method){
				$methods_list[] = $method->name;
			}
			foreach( $methods_list as $key => $function ){
				if( !in_array( $function, $this->inherents_functions ) ){
					$info['actions'][] = $this->getActionData( $reflection_controller, $function );
				}
			}
			return $info;
		} catch( \Exception $e ){
			throw new $e;
		}

	}

	public function getActionData( \ReflectionClass $ReflectionClass, string $actionName ) : array
	{

		$comment = $ReflectionClass->getMethod( $actionName )->getDocComment();


		$title_pattern = "/\*\*\s*(?:\*\s*)+([^\s\*]+)/";
		$pattern       = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";

		preg_match_all( $title_pattern, $comment, $title_matches, PREG_PATTERN_ORDER );
		preg_match_all( $pattern, $comment, $matches, PREG_PATTERN_ORDER );
		if( $matches[0] ){
			foreach( $matches[0] as $k => $v ){
				$matches[0][$k] = trim( $v );
			}
		} else{
			$matches[0] = [];
		}
		if( isset( $title_matches[1][0] ) ){
			$title = $title_matches[1][0];
		} else{
			$title = '';
		}
		$comment_items = $matches[0];

		// 获得http method
		if( isset( $comment_items[0] ) && strstr( $comment_items[0], 'GET' ) ){
			$http_method = 'GET';
		} else{
			$http_method = 'POST';
		}
		return [
			'name'          => $actionName,
			'title'         => $title,
			'comment'       => $comment,
			'comment_items' => $comment_items,
			'http_method'   => $http_method,
		];
	}

	/**
	 * 获取所有方法名称
	 */
	public function getAction( $module, $controller )
	{
		if( empty( $controller ) ){
			return null;
		}

		$content = file_get_contents( APP_PATH.'HttpController/'.$module.'/'.$controller.'.php' );

		preg_match_all( "/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches );
		$functions = $matches[1];

		//排除部分方法
		$inherents_functions = [
			'_before_index',
			'_after_index',
			'_initialize',
			'__construct',
			'getActionName',
			'isAjax',
			'display',
			'show',
			'fetch',
			'buildHtml',
			'assign',
			'__set',
			'get',
			'__get',
			'__isset',
			'__call',
			'error',
			'success',
			'ajaxReturn',
			'redirect',
			'__destruct',
			'_empty',
		];
		foreach( $functions as $func ){
			$func = trim( $func );
			if( !in_array( $func, $inherents_functions ) ){
				if( strlen( $func ) > 0 ){
					$customer_functions[] = $func;
				}

			}
		}
		return $customer_functions;
	}

	public function getAllFunctionList()
	{
		try{
			$all_controller = $this->getControllerNameList();
			foreach( $all_controller as $class_name ){
				$all_action[] = $this->getFunctionList( $class_name ); //获取所有方法名称
			}
			return $all_action;
		} catch( \Exception $e ){
			throw new $e;
		}
	}

	/**
	 * 获取函数的注释
	 * @return [type] string 注释 [description]
	 */
	public function getDesc( $module, $controller, $action )
	{
		$desc = "\App\HttpController\{$module}\{$controller}";
		$func = new \ReflectionMethod( new $desc(), $action );
		$tmp  = $func->getDocComment();
		$flag = preg_match_all( '/\*\*\s*(?:\*\s*)+([^\s\*]+)/', $tmp, $tmp ); // 注释的固定格式，待商榷。
		$tmp  = trim( $tmp[1][0] ); // 注释的固定格式，待商榷。
		$tmp  = $tmp != '' ? $tmp : '无';
		return $tmp;
	}

	/**
	 * @method     GET
	 * @datetime 2017-06-29T12:19:13+0800
	 * @author   韩文博
	 * @param    string $module
	 * @param    string $controller
	 * @param    string $action
	 */
	public function getParam( $module, $controller, $action )
	{

	}
}
