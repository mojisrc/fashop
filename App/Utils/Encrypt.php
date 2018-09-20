<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/20
 * Time: 上午12:33
 *
 */

namespace App\Utils;
class Encrypt
{
	/**
	 * 系统加密方法
	 * @param string $data   要加密的字符串
	 * @param string $key    加密密钥
	 * @param int    $expire 过期时间 单位 秒
	 * @return string
	 */
	static function encrypt( $data, $key = '', $expire = 0 )
	{
		$key  = md5( empty( $key ) ? 'www.fashop.cn' : $key );
		$data = base64_encode( $data );
		$x    = 0;
		$len  = strlen( $data );
		$l    = strlen( $key );
		$char = '';
		for( $i = 0 ; $i < $len ; $i ++ ){
			if( $x == $l ){
				$x = 0;
			}

			$char .= substr( $key, $x, 1 );
			$x ++;
		}
		$str = sprintf( '%010d', $expire ? $expire + time() : 0 );
		for( $i = 0 ; $i < $len ; $i ++ ){
			$str .= chr( ord( substr( $data, $i, 1 ) ) + (ord( substr( $char, $i, 1 ) )) % 256 );
		}
		return str_replace( '=', '', base64_encode( $str ) );
	}

	/**
	 * 系统解密方法
	 * @param  string $data 要解密的字符串 （必须是fa_encrypt方法加密的字符串）
	 * @param  string $key  加密密钥
	 * @return string
	 */
	static function decrypt( $data, $key = '' )
	{
		$key    = md5( empty( $key ) ? 'www.fashop.cn' : $key );
		$x      = 0;
		$data   = base64_decode( $data );
		$expire = substr( $data, 0, 10 );
		$data   = substr( $data, 10 );
		if( $expire > 0 && $expire < time() ){
			return '';
		}
		$len  = strlen( $data );
		$l    = strlen( $key );
		$char = $str = '';
		for( $i = 0 ; $i < $len ; $i ++ ){
			if( $x == $l ){
				$x = 0;
			}

			$char .= substr( $key, $x, 1 );
			$x ++;
		}
		for( $i = 0 ; $i < $len ; $i ++ ){
			if( ord( substr( $data, $i, 1 ) ) < ord( substr( $char, $i, 1 ) ) ){
				$str .= chr( (ord( substr( $data, $i, 1 ) ) + 256) - ord( substr( $char, $i, 1 ) ) );
			} else{
				$str .= chr( ord( substr( $data, $i, 1 ) ) - ord( substr( $char, $i, 1 ) ) );
			}
		}
		return base64_decode( $str );
	}

}