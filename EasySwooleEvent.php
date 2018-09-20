<?php

namespace EasySwoole;

use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\SysConst;
use EasySwoole\Core\Http\Request;
use EasySwoole\Core\Http\Response;
use EasySwoole\Core\Swoole\EventRegister;
use EasySwoole\Core\Swoole\ServerManager;
use EasySwoole\Core\AbstractInterface\EventInterface;
use \ezswoole\App;

class EasySwooleEvent implements EventInterface
{
	public static function frameInitialize() : void
	{
		define( 'FASHOP_VERSION', '1.0.0' );
		define( 'APP_PATH', __DIR__.'/App/' );
		define( 'ROOT_PATH', dirname( realpath( APP_PATH ) ).'/' );
		Di::getInstance()->set( SysConst::ERROR_HANDLER, \ezswoole\ErrorHandler::class );
		Di::getInstance()->set( SysConst::HTTP_EXCEPTION_HANDLER, \ezswoole\ExceptionHandler::class );
		Di::getInstance()->set( SysConst::SHUTDOWN_FUNCTION, \ezswoole\ShutdownHandler::class );
	}

	public static function mainServerCreate( ServerManager $server, EventRegister $register ) : void
	{
		\ezswoole\Init::register();

		$register->add( 'workerStart', function( \swoole_websocket_server $server, $worker_id ){
			if( PHP_OS === 'Linux' ){
				swoole_set_process_name( 'fashop' );
			}
			if( $worker_id === 0 ){
				\ezswoole\Cron::getInstance()->run();
			}
		} );

		$register->add( "message", function( \swoole_websocket_server $server, \swoole_websocket_frame $frame ){
			if( $frame->data == 'pong' ){
				$server->push( $frame->fd, json_encode( ['type' => 'pong', 'code' => 0, 'msg' => '服务器端保持心跳'] ) );
			}
		} );

		$register->add( 'open', function( \swoole_websocket_server $server, \swoole_http_request $request ){
			$server->push( $request->fd, json_encode( ['type' => 'open', 'code' => 0, 'msg' => '服务器请求连接'] ) );
		} );

		$register->add( 'close', function( \swoole_server $server, int $fd, int $reactorId ){
			$info = $server->connection_info( $fd );
			if( isset( $info['websocket_status'] ) && $info['websocket_status'] === 3 ){
				$server->push( $fd, json_encode( ['type' => 'close', 'code' => 0, 'msg' => '服务器链接关闭'] ) );
			}
		} );

	}

	public static function onRequest( Request $request, Response $response ) : void
	{
		App::onRequest( $request, $response );
		$fashopRequest = \ezswoole\Request::getInstance();

		// 推送调试信息
		if( config( 'app_debug' ) === true ){
			$host = $fashopRequest->host();
			if( isset( $host ) ){
				$current_uri = $fashopRequest->scheme()."://".$host.$fashopRequest->url();
			} else{
				$current_uri = "cmd:".implode( ' ', $_SERVER['argv'] );
			}
			$method = isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : 'CLI';
			$uri    = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
			if( strstr( $uri, 'favicon.ico' ) === false ){
				$result                = [];
				$result['current_uri'] = $current_uri.$uri;
				$result['method']      = $method;
				$result['header']      = $request->getSwooleRequest()->header;
				$result['get']         = $request->getSwooleRequest()->get;
				$post                  = $fashopRequest->post();
				if( strlen( json_encode( $post ) ) > 20000 ){
					$post = "长度大于20000太长，有可能是图片或附件或长文本，不记录";
				}
				$result['post'] = $post;
				$result['raw']  = $request->getSwooleRequest()->rawContent();
				$result['ip']   = $_SERVER['REMOTE_ADDR'];
				wsdebug()->send( $result );
			}
		}
	}

	public static function afterAction( Request $request, Response $response ) : void
	{
		App::afterAction( $request, $response );
	}
}

