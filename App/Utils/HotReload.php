<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/14
 * Time: 下午2:41
 *
 */

namespace App\Utils;
use EasySwoole\Core\Swoole\Server;

final class HotReload
{
	public final static function register()
	{
		// 递归获取所有目录和文件
		$a      = function( $dir ) use ( &$a ){
			$data = [];
			if( is_dir( $dir ) ){
				//是目录的话，先增当前目录进去
				$data[] = $dir;
				$files  = array_diff( scandir( $dir ), ['.', '..'] );
				foreach( $files as $file ){
					$data = array_merge( $data, $a( $dir."/".$file ) );
				}
			} else{
				$data[] = $dir;
			}
			return $data;
		};
		$list   = $a( EASYSWOOLE_ROOT."/App" );
		$notify = inotify_init();
		// 为所有目录和文件添加inotify监视
		foreach( $list as $item ){
			inotify_add_watch( $notify, $item, IN_CREATE | IN_DELETE | IN_MODIFY );
		}
		// 加入EventLoop
		swoole_event_add( $notify, function() use ( $notify ){
			$events = inotify_read( $notify );
			if( !empty( $events ) ){
				//注意更新多个文件的间隔时间处理,防止一次更新了10个文件，重启了10次，懒得做了，反正原理在这里
				Server::getInstance()->getServer()->reload();
			}
		} );
	}

}