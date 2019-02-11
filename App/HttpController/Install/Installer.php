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

	/**
	 * 环境信息列表
	 * @method GET
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
				[
					'name'    => "MySQL版本",
					'require' => ">=5.7.18",
					'status'  => $status['mysql_version'],
					'url'     => "https://www.fashop.cn/guide/",
				],
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
					'require' => ">=1.9.23 && <= 2.2.0",
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
	 */
	public function checkDb()
	{
		try{
			$env = new \App\Utils\Environment();
			if( !version_compare( $env->getMysqlVersion(), '5.7.18', '>=' ) ){
				return $this->send( - 1, [], "数据库版本错误" );
			}
			if( !extension_loaded( 'pdo' ) ){
				return $this->send( - 1, [], "数据库连接失败" );
			}
			return $this->send( 0 );
		} catch( \Exception $e ){
			return $this->send( - 1, [], $e->getMessage() );
		}
	}

	/**
	 * 检查管理员账号配置
	 * @param string $username
	 * @param string $password
	 * @param string $repassword
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
	 * @param int    agree
	 * @param string username
	 * @param string password
	 * @param string repassword
	 */
	public function run()
	{
		try{
			//验证协议
			if( intval( $this->post['agree'] ) != 1 ){
				return $this->send( - 1, [], "请同意并阅读协议" );
			}
			//验证数据库
			$env = new \App\Utils\Environment();
			if( !version_compare( $env->getMysqlVersion(), '5.7.18', '>=' ) ){
				return $this->send( - 1, [], "数据库版本错误" );
			}
			if( !extension_loaded( 'pdo' ) ){
				return $this->send( - 1, [], "数据库连接失败" );
			}

			//验证账号密码
			if( !isset( $this->post['username'] ) || !isset( $this->post['password'] ) || !isset( $this->post['repassword'] ) ){
				return $this->send( - 1, [], "管理员信息不完整" );
			} else{
				$install = new Install();
				$result  = $install->checkAdminAccount( $this->post['username'], $this->post['password'], $this->post['repassword'] );
				if( $result !== true ){
					return $this->send( - 1, [], $result );
				}
			}

			$database = require ROOT_PATH."Conf/config/database.php";

			//执行安装
			$install = new Install( [
				'admin_username'   => $this->post['username'],
				'admin_password'   => $this->post['password'],
				'admin_repassword' => $this->post['repassword'],
				'db_host'          => $database['hostname'],
				'db_name'          => $database['database'],
				'db_username'      => $database['username'],
				'db_password'      => $database['password'],
				'db_port'          => $database['hostport'],
				'db_prefix'        => $database['prefix'],
			] );

			$result = $install->run();
			if( $result === true ){
				$this->send( 0, [], '安装成功' );
			} else{
				$this->send( - 1, [], $result );
			}

		} catch( \Exception $e ){
			return $this->send( - 1, [], $e->getMessage() );
		}
	}
}