<?php

namespace EasySwoole;

use EasySwoole\Core\AbstractInterface\Singleton;
use EasySwoole\Core\Component\Spl\SplArray;
use EasySwoole\Core\Utility\File;

class Config
{
	private $conf;

	use Singleton;

	final public function __construct()
	{
		$conf       = $this->sysConf() + $this->userConf();
		$this->conf = new SplArray( $conf );
	}

	public function getConf( $keyPath )
	{
		return $this->conf->get( $keyPath );
	}

	/*
	  * 在server启动以后，无法动态的去添加，修改配置信息（进程数据独立）
	*/
	public function setConf( $keyPath, $data ) : void
	{
		$this->conf->set( $keyPath, $data );
	}

	private function sysConf()
	{
		return [
			"MAIN_SERVER" => [
				"HOST"        => "0.0.0.0",
				"PORT"        => 9510,
				"SERVER_TYPE" => \EasySwoole\Core\Swoole\ServerManager::TYPE_WEB_SOCKET_SERVER,
				'SOCK_TYPE'   => SWOOLE_TCP,//该配置项当为SERVER_TYPE值为TYPE_SERVER时有效
				'RUN_MODEL'   => SWOOLE_PROCESS,
				"SETTING"     => [
					'task_worker_num'       => 8, //异步任务进程
					"task_max_request"      => 10,
					'max_request'           => 5000,//强烈建议设置此配置项
					'worker_num'            => 8,
					'log_file'              => EASYSWOOLE_ROOT."/Runtime/swoole.log",
					'pid_file'              => EASYSWOOLE_ROOT."/pid.pid",
					'package_max_length'    => 1024 * 1024 * 80,
					'document_root'         => EASYSWOOLE_ROOT.'/Public',  // 静态资源目录
					'enable_static_handler' => true,
				],
			],
			"DEBUG"       => true,
			"TEMP_DIR"    => EASYSWOOLE_ROOT."/Runtime/Temp",
			"LOG_DIR"     => EASYSWOOLE_ROOT."/Runtime/Log",
		];
	}

	private function userConf()
	{
		$config = [
			'app_host'            => '',
			// 应用调试模式
			'app_debug'           => true,
			// 入口自动绑定模块
			'auto_bind_module'    => false,
			// 默认时区
			"default_timezone"    => 'PRC',
			// 扩展文件
			"extra_file_list"     => [
				EASYSWOOLE_ROOT."/App/Utils/function.php",
			],
			// 默认返回数据格式
			'default_return_type' => 'json',
			'response'            => [
				'access_control_allow_origin'  => '*',
				'access_control_allow_headers' => 'X-Requested-With,Content-Type,Access-Token,User-Id,Request-Url,Source,Longitude,Latitude,Wechat-Openid,Authorization',
				'access_control_allow_methods' => 'GET,POST,PUT,DELETE,OPTIONS',
			],
			/* 加密 配置 */
			'data_auth_key'       => 'lkjhgfashopfdsa',
			"upload"              => [

			],
			'log'                 => [
				// 日志记录方式，内置 file socket 支持扩展
				'type'                => 'Socket',
				// 日志保存目录
				'path'                => EASYSWOOLE_ROOT."/Runtime/Log/",
				// 日志记录级别
				'level'               => ['log', 'error', 'info', 'sql', 'notice', 'alert', 'debug', 'trace'],
				// 显示加载的文件
				'show_included_files' => false,
				// 显示http message
				'show_http_message'   => ['post', 'get', 'header', 'cookie', 'session'],
				// socket 推送类型
				'send_type'           => ['log', 'error', 'debug'],

			],
		];
		$files  = File::scanDir( __DIR__.'/config' );
		foreach( $files as $file ){
			if( strpos( $file, ".php" ) !== false ){
				$name          = basename( $file, '.php' );
				$config[$name] = include $file;
			}
		}
		return $config;
	}

	public function toArray() : array
	{
		return $this->conf->getArrayCopy();
	}

	public function load( array $conf ) : void
	{
		$this->conf = new SplArray( $conf );
	}
}