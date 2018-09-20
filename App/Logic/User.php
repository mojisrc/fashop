<?php
/**
 * 用户逻辑层
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

use App\Utils\Encrypt;

class User
{

	/**
	 * 系统加密方法
	 * @param string $string 要加密的字符串
	 * @return string
	 */
	static function encryptPassword( string $string ) : string
	{
		return Encrypt::encrypt( $string, \EasySwoole\Config::getInstance()->getConf( 'data_auth_key' ), 0 );
	}

	/**
	 * 系统解密方法
	 * @param  string $data 要解密的字符串 （必须是fa_encrypt方法加密的字符串）
	 * @param  string $key  加密密钥
	 * @return string
	 */
	static function decryptPassword( string $string ) : string
	{
		return Encrypt::decrypt( $string, \EasySwoole\Config::getInstance()->getConf( 'data_auth_key' ) );
	}

}
