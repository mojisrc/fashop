<?php
/**
 * 系统配置业务逻辑
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;
use ezswoole\Model;
use EasySwoole\Core\Component\Di;

class Setting extends Model {

	/**
	 * 获取数据库中的配置列表
	 * @return array 配置数组
	 */
	public static function lists() {
		$map    = array('status' => 1);
		$data   = model('Setting')->getSettingList($map, 'type,name,value', '', '1,200000');
		$config = array();
		if ($data && is_array($data)) {
			foreach ($data as $value) {
				$config[$value['name']] = self::parse($value['type'], $value['value']);
			}
		}
		return $config;
	}

	/**
	 * 根据配置类型解析配置
	 * @param  integer $type  配置类型
	 * @param  string  $value 配置值
	 */
	private static function parse($type, $value) {
		switch ($type) {
		case 3: //解析数组
			$array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
			if (strpos($value, ':')) {
				$value = array();
				foreach ($array as $val) {
					list($k, $v) = explode(':', $val);
					$value[$k]   = $v;
				}
			} else {
				$value = $array;
			}
			break;
		}
		return $value;
	}
}
