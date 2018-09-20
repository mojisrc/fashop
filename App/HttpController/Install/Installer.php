<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/7
 * Time: 下午4:30
 *
 */

namespace App\HttpController\Install;

use ezswoole\Controller;
use Install\Install;
use ezswoole\Request;
use App\Utils\Code;

class Installer extends Controller
{
	/**
	 * 当访问
	 * @param $actionName
	 */
	protected function onRequest( $actionName ) : ?bool
	{
		parent::onRequest( $actionName );
		$this->request = Request::getInstance();
		if( $this->request->method() === 'OPTIONS' ){
			$this->send( Code::success );
			$this->response()->end();
			return false;
		} else{
			return true;
		}
	}


	public function index()
	{
		$isSsl = request()->isSsl();
		$host  = request()->host();
		$port  = \Easyswoole\Config::getInstance()->getConf( "MAIN_SERVER.PORT" );
		if(filter_var($host, FILTER_VALIDATE_IP)){
			$url = "{$host}:{$port}";
		}else{
			$url = $host;
		}
		$apiHost = $isSsl? 'https://'.$url : 'http://'.$url;
		$time = time();
		$html = <<<EOT
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="renderer" content="webkit"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>FaShop 商城系统 - Power By FaShop ( www.fashop.cn )</title>
    <meta name="keywords" content="FaShop,开源商城系统,开源商城小程序,开源商城APP">
    <meta name="description" content="FaShop是魔际（天津）科技有限公司(www.fashop.cn)开发。">
    <link rel="manifest" href="http://statics.fashop.cn/fashop-install/manifest.json?t={$time}">
    <link rel="shortcut icon" href="http://statics.fashop.cn/fashop-install/favicon.ico?t={$time}">
    <link href="http://statics.fashop.cn/fashop-install/static/css/vendor.css?t={$time}" rel="stylesheet">
</head>
<body>
<script>window.fashop = {apiHost: '{$apiHost}' ,historyPrefix:'/a'}</script>
<div id="root"></div>
<script type="text/javascript" src="http://statics.fashop.cn/fashop-install/static/js/vendor.js?t={$time}"></script>
<script type="text/javascript" src="http://statics.fashop.cn/fashop-install/static/js/main.js?t={$time}"></script>
</body>
</html>
EOT;
		$this->response()->write( $html );
	}

	/**
	 * 环境信息列表
	 * @method GET
	 * @author 韩文博
	 */
	public function envStatus()
	{
		try{

			$install  = new Install();
			$status   = $install->getEnvironmentStatus();
			$env_list = [
				[
					'name'    => "PHP版本",
					'require' => ">=7.2.0",
					'status'  => $status['php_version'],
					'url'     => "https://www.fashop.cn/guide/",
				],
				//				[
				//					'name'    => "MySQL版本",
				//					'require' => ">=5.7.18",
				//					'status'  => $status['mysql_version'],
				//					'url'     => "https://www.fashop.cn/guide/",
				//				],
				[
					'name'    => "PDO",
					'require' => "开启",
					'status'  => $status['pdo'],
					'url'     => "https://www.fashop.cn/guide/",
				],
				[
					'name'    => "fsockopen",
					'require' => "开启",
					'status'  => $status['allow_url_fopen'],
					'url'     => "https://www.fashop.cn/guide/",
				],
				[
					'name'    => "CURL",
					'require' => "开启",
					'status'  => $status['curl'],
					'url'     => "https://www.fashop.cn/guide/",
				],
				[
					'name'    => "GD2",
					'require' => "开启",
					'status'  => $status['gd2'],
					'url'     => "https://www.fashop.cn/guide/",
				],
				[
					'name'    => "DOM",
					'require' => "开启",
					'status'  => $status['dom'],
					'url'     => "https://www.fashop.cn/guide/",
				],
				[
					'name'    => "openssl",
					'require' => "开启",
					'status'  => $status['openssl'],
					'url'     => "https://www.fashop.cn/guide/",
				],
				[
					'name'    => "Swoole",
					'require' => ">=1.10.0",
					'status'  => $status['swoole'],
					'url'     => "https://www.fashop.cn/guide/",
				],
				[
					'name'    => "imagick",
					'require' => "开启",
					'status'  => $status['imagick'],
					'url'     => "https://www.fashop.cn/guide/",
				],
			];
			$env      = [
				"title" => "系统环境监测",
				"desc"  => "系统环境要求必须满足一下所有条件，否则系统或系统部分功能将无法正常使用",
				"data"  => $env_list,
			];

			$dir_status = $install->getDirectoryStatus();
			$dir_list   = [
				[
					'name'    => "/",
					'require' => "可读写",
					'status'  => $dir_status['/'],
					'help'    => "项目根目录无法写入，系统将无法正常运行",
				],
				[
					'name'    => "/Upload",
					'require' => "可读写",
					'status'  => $dir_status['/Upload'],
					'help'    => "Upload目录无法写入，影响文件上传",
				],
				[
					'name'    => "/Runtime",
					'require' => "可读写",
					'status'  => $dir_status['/Runtime'],
					'help'    => "Runtime目录无法写入，影响缓存机制",
				],
				[
					'name'    => "/App",
					'require' => "可读写",
					'status'  => $dir_status['/App'],
					'help'    => "App目录无法写入，将无法使用自动更新功能，系统将无法正常运行",
				],
				[
					'name'    => "/Conf",
					'require' => "可读写",
					'status'  => $dir_status['/Conf'],
					'help'    => "Conf目录无法写入，影响配置升级",
				],
				[
					'name'    => "/vendor",
					'require' => "可读写",
					'status'  => $dir_status['/vendor'],
					'help'    => "vendor目录无法写入，影响系统升级",
				],
//				[
//					'name'    => "/Backup",
//					'require' => "可读写",
//					'status'  => $dir_status['/Backup'],
//					'help'    => "Backup目录无法写入，影响备份",
//				],
			];

			$dir = [
				"title" => "目录权限检测",
				"desc"  => "系统要求FaShop开源商城安装目录下的Runtime和Upload必须可写，才能使用FaShop开源商城所有功能",
				"data"  => $dir_list,
			];
			$this->send( 0, ['env' => $env, 'dir' => $dir] );
		} catch( \Exception $e ){
			$this->send( Code::server_error, [], $e->getMessage() );
		}
	}

	/**
	 * 检查数据库配置
	 * @method POST
	 * @param string host
	 * @param string dbname
	 * @param string username
	 * @param string password
	 * @param string port
	 * @param string prefix
	 * @author 韩文博
	 */
	public function checkDb()
	{
		if( !isset( $this->post['host'] ) || !isset( $this->post['dbname'] ) || !isset( $this->post['username'] ) || !isset( $this->post['password'] ) || !isset( $this->post['port'] ) || !isset( $this->post['prefix'] ) ){
			$this->send( - 1, [], "配置信息不完整" );
		} else{
			$install = new Install();
			$result  = $install->checkDatabase( $this->post['username'], $this->post['password'], $this->post['host'], $this->post['port'], $this->post['prefix'], $this->post['dbname'] );
			if( $result !== true ){
				$this->send( - 1, [], $result );
			} else{
				$this->send( 0 );
			}
		}
	}

	/**
	 * 检查管理员账号配置
	 * @param string $username
	 * @param string $password
	 * @param string $repassword
	 * @author 韩文博
	 */
	public function checkAdminAccount()
	{
		if( !isset( $this->post['username'] ) || !isset( $this->post['password'] ) || !isset( $this->post['repassword'] ) ){
			$this->send( - 1, [], "管理员信息不完整" );
		} else{
			$install = new Install();
			$result  = $install->checkAdminAccount( $this->post['username'], $this->post['password'], $this->post['repassword'] );
			if( $result !== true ){
				$this->send( - 1, [], $result );
			} else{
				$this->send( 0 );
			}
		}
	}

	/**
	 * 安装
	 * @method POST
	 * @param string db_host
	 * @param string db_name
	 * @param string db_username
	 * @param string db_password
	 * @param string db_port
	 * @param string db_prefix
	 * @param string admin_username
	 * @param string admin_password
	 * @param string admin_repassword
	 * @author 韩文博
	 */
	public function run()
	{
		if( !isset( $this->post['db_host'] ) || !isset( $this->post['db_name'] ) || !isset( $this->post['db_port'] ) || !isset( $this->post['db_prefix'] ) || !isset( $this->post['db_username'] ) || !isset( $this->post['db_password'] ) ){
			$this->send( Code::param_error, [], "数据库配置信息不完整" );
		} elseif( !isset( $this->post['admin_username'] ) || !isset( $this->post['admin_password'] ) || !isset( $this->post['admin_repassword'] ) ){
			$this->send( Code::param_error, [], "管理员信息不完整" );
		} else{
			$install = new Install( [
				'admin_username'   => $this->post['admin_username'],
				'admin_password'   => $this->post['admin_password'],
				'admin_repassword' => $this->post['admin_repassword'],
				'db_host'          => $this->post['db_host'],
				'db_name'          => $this->post['db_name'],
				'db_username'      => $this->post['db_username'],
				'db_password'      => $this->post['db_password'],
				'db_port'          => $this->post['db_port'],
				'db_prefix'        => $this->post['db_prefix'],
			] );
			try{
				$result = $install->run();
				if( $result === true ){
					$this->send( 0, [], '安装成功' );
				} else{
					$this->send( - 1, [], $result );
				}
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 安装
	 * @method POST
	 * @param string db_host
	 * @param string db_name
	 * @param string db_username
	 * @param string db_password
	 * @param string db_port
	 * @param string db_prefix
	 * @param string admin_username
	 * @param string admin_password
	 * @param string admin_repassword
	 * @author 韩文博
	 */
	public function runtest()
	{
		if( !isset( $this->post['db_host'] ) || !isset( $this->post['db_name'] ) || !isset( $this->post['db_username'] ) || !isset( $this->post['db_password'] ) || !isset( $this->post['db_port'] ) || !isset( $this->post['db_prefix'] ) ){
			$this->send( - 1, [], "配置信息不完整" );
		} elseif( !isset( $this->post['admin_username'] ) || !isset( $this->post['admin_password'] ) || !isset( $this->post['admin_repassword'] ) ){
			$this->send( - 1, [], "管理员信息不完整" );
		} else{
			$install = new Install( [
				'admin_username'   => $this->post['admin_username'],
				'admin_password'   => $this->post['admin_password'],
				'admin_repassword' => $this->post['admin_repassword'],
				'db_host'          => $this->post['db_host'],
				'db_name'          => $this->post['db_name'],
				'db_username'      => $this->post['db_username'],
				'db_password'      => $this->post['db_password'],
				'db_port'          => $this->post['db_port'],
				'db_prefix'        => $this->post['db_prefix'],
			] );
			try{
				$result = $install->run();
				if( $result === true ){
					$this->send( 0, [], '安装成功' );
				} else{
					$this->send( - 1, [], $result );
				}
			} catch( \Exception $e ){
				$this->send( - 1, [], $e->getMessage() );
			}
		}
	}
}