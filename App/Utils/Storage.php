<?php
// +----------------------------------------------------------------------
// | TOPThink [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace App\Utils;

// 分布式文件存储类
class Storage {

	/**
	 * @author 邓凯
	 * @dateTime 2017-12-19
	 * 检查安装情况
	 */
	static public function __callstatic($method, $args) {
		// // STORAGE_TYPE文件类型
		$class   = 'App\\Utils\\Storage\\Driver\\' . STORAGE_TYPE;
		$handler = new $class();

		$type        = end($args);
		$method_type = $method . ucfirst($type);
		if (method_exists($handler, $method_type)) {
			return call_user_func_array(array($handler, $method_type), $args);
		}
		//调用缓存类型自己的方法
		if (method_exists($handler, $method)) {
			return call_user_func_array(array($handler, $method), $args);
		}
	}

}
