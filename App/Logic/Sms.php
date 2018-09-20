<?php
/**
 * 短信逻辑层
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

class Sms extends Model {
	/**
	 * 验证短信验证码是否过期
	 * @param $phone 手机号
	 * @param $code 邀请码
	 * @param $model 模块名
	 */
	function isExpired($phone, $code, $model) {
		$code_find = model('Sms')->getSmsInfo([
			'phone'       => $phone,
			'code'        => $code,
			'create_time' => [['gt', time() - 60 * 10], ['lt', time()]],
			'model'       => $model,
		]);
		if ($code_find) {
			return false;
		} else {
			return true;
		}
	}
}
