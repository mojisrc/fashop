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

namespace App\Broadcast;

use EasySwoole\Core\Swoole\Task\TaskManager;
use EasySwoole\Core\Component\Logger;

class Dispatch
{
	/**
	 * @payload string $content
	 */
	static function call( string $raw ) : void
	{
		// 非阻塞，并且为了外部调用不崩溃
		TaskManager::async( function() use ( $raw ){
			// 记录消息，以免执行失败无法追踪
			$db      = db( 'Queue' );
			$queueId = $db->insert( [
				'name'        => 'broadcast dispatch call',
				'raw'         => $raw,
				'create_time' => time(),
			], false, true );

			// 解析raw为数组，raw约束为json格式
			$jsonArr = \App\Broadcast\Dispatch::isJson( $raw );
			if( $jsonArr ){
				if( isset( $jsonArr['action'] ) ){
					$_action = $jsonArr['action'];
				} else{
					throw new \Exception( 'Broadcast action error' );
				}
				$payload = isset( $jsonArr['payload'] ) ? $jsonArr['payload'] : [];
				$confirm = isset( $jsonArr['confirm'] ) && is_bool( $jsonArr['confirm'] ) ? $jsonArr['confirm'] : false;
				list( $module, $controller, $action ) = explode( '.', $_action );
				$module     = ucfirst( $module );
				$controller = ucfirst( $controller );
				$className  = "\App\Broadcast\\$module\\$controller";
				$controller = new $className();

				if( $controller instanceof BroadcastController ){
					// 设置控制器请求参数
					$controller->setArg( 'action', $_action );
					$controller->setArg( 'payload', $payload );
					// 如果是确认消息模式，需要确定后删除记录
					if( $confirm === true ){
						$actionResult = $controller->$action();
						if( $actionResult === true ){
							// 确认后删除消息
							$db->delete( ['id' => $queueId] );
						}
					} else{
						$controller->$action();
					}
				} else{
					$date = date( 'Y-m-d H:i:s' );
					Logger::getInstance()->log( "Class must be extends BroadcastController \n Time:{$date} \n Raw:{$raw}" );
				}
			} else{
				$date = date( 'Y-m-d H:i:s' );
				Logger::getInstance()->log( "Broadcast Dispatch's Raw is not json \n Time:{$date} \n Raw:{$raw}" );
			}
		} );
	}

	static function isJson( string $raw )
	{
		$jsonArr = json_decode( $raw, 1 );
		if( $jsonArr && (is_object( $jsonArr )) || (is_array( $jsonArr ) && !empty( current( $jsonArr ) )) ){
			return $jsonArr;
		} else{
			return false;
		}
	}
}