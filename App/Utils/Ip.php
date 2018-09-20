<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/9/2
 * Time: 下午4:09
 *
 */

namespace App\Utils;
class Ip
{
	static function getClientIp( $type = 0 )
	{
		$type = $type ? 1 : 0;
		static $ip = null;
		if( $ip !== null )
			return $ip[$type];
		if( $_SERVER['HTTP_X_REAL_IP'] ){//nginx 代理模式下，获取客户端真实IP
			$ip = $_SERVER['HTTP_X_REAL_IP'];
		} elseif( isset( $_SERVER['HTTP_CLIENT_IP'] ) ){//客户端的ip
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){//浏览当前页面的用户计算机的网关
			$arr = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
			$pos = array_search( 'unknown', $arr );
			if( false !== $pos )
				unset( $arr[$pos] );
			$ip = trim( $arr[0] );
		} elseif( isset( $_SERVER['REMOTE_ADDR'] ) ){
			$ip = $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
		} else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		// IP地址合法验证
		$long = sprintf( "%u", ip2long( $ip ) );
		$ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];
		return $ip[$type];
	}
}