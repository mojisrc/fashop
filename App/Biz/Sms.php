<?php
/**
 * 短信逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Biz;

use ezswoole\Model;


class Sms extends Model
{
	/**
	 * 验证短信验证码是否过期
	 * @param string $phone 手机号
	 * @param string $code  邀请码
	 * @param string $model 模块名
	 */
	function isExpired( $phone, $code, $model )
	{
		$code_find = \App\Model\Sms::getSmsInfo( [
			'phone'       => $phone,
			'code'        => $code,
			'create_time' => [['>', time() - 60 * 10], ['<', time()]],
			'model'       => $model,
		] );
		if( $code_find ){
			return false;
		} else{
			return true;
		}
	}
}
