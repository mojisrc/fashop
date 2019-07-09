<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-01
 * Time: 20:06
 */

return [
	'SERVER_NAME'   => "EasySwoole",
	'MAIN_SERVER'   => [
		'LISTEN_ADDRESS' => '0.0.0.0',
		'PORT'           => 9510,
		'SERVER_TYPE'    => EASYSWOOLE_WEB_SOCKET_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER
		'SOCK_TYPE'      => SWOOLE_TCP,
		'RUN_MODEL'      => SWOOLE_PROCESS,
		'SETTING'        => [
			'worker_num'            => 8,
			'max_request'           => 5000,
			'task_worker_num'       => 8,
			'task_max_request'      => 1000,
			'task_enable_coroutine' => true,
		],
	],
	'TEMP_DIR'      => null,
	'LOG_DIR'       => null,
	'CONSOLE'       => [
		'ENABLE'         => true,
		'LISTEN_ADDRESS' => '127.0.0.1',
		'HOST'           => '127.0.0.1',
		'PORT'           => 9500,
		'EXPIRE'         => '120',
		'PUSH_LOG'       => true,
		'AUTH'           => [
			[
				'USER'     => 'root',
				'PASSWORD' => '123456',
				'MODULES'  => [
					'auth',
					'server',
					'help',
				],
				'PUSH_LOG' => true,
			],
		],
	],
	'FAST_CACHE'    => [
		'PROCESS_NUM' => 0,
		'BACKLOG'     => 256,
	],
	'DISPLAY_ERROR' => true,
	'MYSQL'         => [
		'prefix'        => 'fa_',
		'host'          => '127.0.0.1',
		'port'          => '3306',
		'user'          => 'fashop',
		'timeout'       => '5',
		'charset'       => 'utf8mb4',
		'password'      => '',
		'database'      => 'fashop',
		'POOL_MAX_NUM'  => '20',
		'POOL_TIME_OUT' => '0.1',
	],
	// 加密方式
	'ENCRYPT'       => [
		'data_auth_key' => 'KBGHGY&*IPJKLASKJD',
	],
	// 定时任务
	'CRON'          => [
		// 开启定时任务
		'status' => true,
	],
];
