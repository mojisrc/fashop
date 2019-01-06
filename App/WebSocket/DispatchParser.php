<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/4
 * Time: 5:08 PM
 *
 */

namespace App\WebSocket;

use EasySwoole\Core\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Core\Socket\Common\CommandBean;

class DispatchParser implements ParserInterface
{
	public static function decode( $raw, $client )
	{
		try{
			$info    = self::rawFormat( $raw );
			$command = new CommandBean();
			$command->setControllerClass( $info['controller'] );
			$command->setAction( $info['controller_action'] );

			$command->setArg( 'action', $info['action'] );
			$command->setArg( 'sign', $info['sign'] );
			$command->setArg( 'param', $info['param'] );
			return $command;
		} catch( \Exception $e ){
			$command->setControllerClass( \App\WebSocket\Error::class );
			$command->setAction( 'handel' );

			$command->setArg( 'raw', $raw );
			$command->setArg( 'exception', $e );
			return $command;
		}

	}

	public static function encode( string $raw, $client ) : ?string
	{
		return $raw;
	}

	/**
	 * @param string $raw
	 * @return array
	 * @throws \Exception
	 * @author hanwenbo
	 */
	private static function rawFormat( string $raw ) : array
	{
		$jsonArr = json_decode( $raw, 1 );
		if( $jsonArr && (is_object( $jsonArr )) || (is_array( $jsonArr ) && !empty( current( $jsonArr ) )) ){
			if( isset( $jsonArr['action'] ) && isset( $jsonArr['sign'] ) ){
				$action = $jsonArr['action'];
				$sign   = $jsonArr['sign'];
			} else{
				throw new \Exception( 'WebSocket action | sign error' );
			}
			$param = isset( $jsonArr['param'] ) ? $jsonArr['param'] : [];
			list( $module, $controller, $controller_action ) = explode( '.', $action );
			$module     = ucfirst( $module );
			$controller = ucfirst( $controller );
			return [
				'action'            => $action,
				'controller'        => "\App\WebSocket\\$module\\$controller",
				'controller_action' => $controller_action,
				'param'             => $param,
				'sign'              => $sign,
			];
		} else{
			throw new \Exception( 'JSON格式错误' );
		}
	}
}