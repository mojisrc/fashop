<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/7
 * Time: 下午2:08
 *
 */

namespace Install;

use ezswoole\Validate;
use EasySwoole\Core\Utility\File;
use ezswoole\utils\RandomKey;
use ezswoole\Log;

class Install
{
	/**
	 * @var string
	 */
	private $adminUsername = 'admin';
	/**
	 * @var string
	 */
	private $adminPassword;
	/**
	 * @var string
	 */
	private $adminRepassword;
	/**
	 * @var string
	 */
	private $dbUsername = 'fashop';
	/**
	 * @var string
	 */
	private $dbPassword;
	/**
	 * @var string
	 */
	private $dbHost = '127.0.0.1';
	/**
	 * @var int
	 */
	private $dbPort = 3306;
	/**
	 * @var string
	 */
	private $dbPrefix = 'fa_';
	/**
	 * @var string
	 */
	private $dbName = 'fashop';

	public function __construct( array $options = [] )
	{
		if( isset( $options['admin_username'] ) ){
			$this->adminUsername = $options['admin_username'];
		}
		if( isset( $options['admin_password'] ) ){
			$this->adminPassword = $options['admin_password'];
		}
		if( isset( $options['admin_repassword'] ) ){
			$this->adminRepassword = $options['admin_repassword'];
		}
		if( isset( $options['admin_username'] ) ){
			$this->adminUsername = $options['admin_username'];
		}
		if( isset( $options['db_username'] ) ){
			$this->dbUsername = $options['db_username'];
		}
		if( isset( $options['db_password'] ) ){
			$this->dbPassword = $options['db_password'];
		}
		if( isset( $options['db_host'] ) ){
			$this->dbHost = $options['db_host'];
		}
		if( isset( $options['db_port'] ) ){
			$this->dbPort = $options['db_port'];
		}
		if( isset( $options['db_prefix'] ) ){
			$this->dbPrefix = $options['db_prefix'];
		}
		if( isset( $options['db_name'] ) ){
			$this->dbName = $options['db_name'];
		}
	}

	/**
	 * 开始安装
	 */
	public function run()
	{
		// todo 判断是否已经安装
		$getEnvironmentStatus = $this->getEnvironmentStatus();
		foreach( $getEnvironmentStatus as $key => $env ){
			if( $env !== true ){
				return "{$key} fail";
			}
		}

		$getDirectoryStatus = $this->getDirectoryStatus();
		foreach( $getDirectoryStatus as $key => $env ){
			if( $env !== true ){
				return "{$key} fail";
			}
		}
		$checkAdminAccount = $this->checkAdminAccount( $this->adminUsername, $this->adminPassword, $this->adminPassword );
		if( $checkAdminAccount !== true ){
			return '管理员账号信息不正确';
		}

		$checkDatabase = $this->checkDatabase( $this->dbUsername, $this->dbPassword, $this->dbHost, $this->dbPort, $this->dbPrefix, $this->dbName );
		if( $checkDatabase !== true ){
			return $checkDatabase;
		}

		try{
			$this->initDirectory();
			$this->initDb();
			$this->insertInitDatabase();
			$this->initAdmin();
			return true;
		} catch( \Exception $e ){
			return $e->getMessage();
		}
	}


	private function initAdmin()
	{
		$model = model( 'User' );
		$model->addUser( [
			'username' => $this->adminUsername,
			'password' => \App\Logic\User::encryptPassword( $this->adminPassword ),
		] );
	}

	private function initDirectory() : void
	{
		$file = new File();
		$file::createDir( RUNTIME_PATH."Temp" );
		$file::createDir( RUNTIME_PATH."Cache" );
		$file::createDir( RUNTIME_PATH."Log" );
		$file::createDir( ROOT_PATH."Upload" );
		$file::createDir( ROOT_PATH."Backup" );
	}

	private function initDb()
	{
		$target             = ROOT_PATH."Conf/config/database.php";
		$config             = require $target;
		$config['hostname'] = $this->dbHost;
		$config['database'] = $this->dbName;
		$config['username'] = $this->dbUsername;
		$config['password'] = $this->dbPassword;
		$config['hostport'] = $this->dbPort;
		$config['prefix']   = $this->dbPrefix;
		$content            = "<?php\n";
		$content            .= "return ".var_export( $config,true ).";";
		file_put_contents( $target, $content );
	}

	private function insertInitDatabase()
	{
		$sql = file_get_contents( ROOT_PATH."Install/fashop.sql" );
		$sql = str_replace( "ez_", $this->dbPrefix, $sql );
		$db  = new \PDO( "mysql:host={$this->dbHost};port={$this->dbPort};dbname={$this->dbName};", $this->dbUsername, $this->dbPassword );
		try{
			$db->query( $sql );
		} catch( \Exception $e ){
			Log::write( $e->getMessage() );
		}
	}

	private function initJwt()
	{
		$target        = ROOT_PATH."Conf/config/jwt.php";
		$config        = require $target;
		$config['key'] = RandomKey::string( 13 );
		$content       = "<?php \n";
		$content       .= "return ".var_export( $config, true ).";";
		file_put_contents( $target, $content );
	}

	/**
	 * 检查是否已安装
	 * @author 韩文博
	 */
	public function checkStatus()
	{
		// todo 判断配置文件、数据库是否都已经存在
		// todo 生成nginx 不是在这里面
	}

	/**
	 * 检查开发环境是否符合
	 * @method GET
	 * @return array
	 * @author 韩文博
	 */
	public function getEnvironmentStatus() : array
	{
		$env        = new \App\Utils\Environment();
		$extensions = get_loaded_extensions();
		return [
			'php_version'     => version_compare( $env->getPhpVersion(), '7.2.0', '>=' ) ? true : false,
			'pdo'             => extension_loaded( 'pdo' ) ? true : false,
			'allow_url_fopen' => function_exists( 'fsockopen' ) ? true : false,
			'curl'            => function_exists( 'curl_init' ) ? true : false,
			'gd2'             => function_exists( 'imagecreatefromgd2' ) ? true : false,
			'dom'             => in_array( "dom", $extensions ) ? true : false,
			'openssl'         => in_array( "openssl", $extensions ) ? true : false,
			'swoole'          => version_compare( $env->getSwooleVersion(), '1.9.0', '>' ) && version_compare( $env->getSwooleVersion(), '1.11', '<' ) ? true : false,
			'imagick'         => in_array( "imagick", $extensions ) ? true : false,
		];
	}

	/**
	 * 检查目录是否可写
	 * @method GET
	 * @return array
	 * @author 韩文博
	 */
	public function getDirectoryStatus() : array
	{
		return [
			'/'        => is_writable( ROOT_PATH ) ? true : false,
			'/Upload'  => is_writable( ROOT_PATH."Upload" ) ? true : false,
			'/Runtime' => is_writable( ROOT_PATH."Runtime" ) ? true : false,
			'/App'     => is_writable( ROOT_PATH."App" ) ? true : false,
			'/Conf'    => is_writable( ROOT_PATH."Conf" ) ? true : false,
			'/vendor'  => is_writable( ROOT_PATH."vendor" ) ? true : false,
			//			'/Backup'  => is_writable( ROOT_PATH."Backup" ) ? true : false,
		];
	}

	/**
	 * 检测数据库信息是否可用
	 * @param string $host
	 * @param int    $port
	 * @param string $prefix
	 * @param string $username
	 * @param string $password
	 * @param string $dbname
	 * @return bool | string
	 * @author 韩文博
	 */
	public function checkDatabase( string $username, string $password, string $host = '127.0.0.1', int $port = 3306, string $prefix = 'fa_', string $dbname = 'fashop' )
	{
		try{
			$db     = new \PDO( "mysql:host={$host};port={$port};", $username, $password );
			$sql    = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8";
			$result = $db->query( $sql );
			if( $result ){
				return true;
			} else{
				return '数据库创建失败';
			}
		} catch( \Exception $e ){
			return $e->getMessage();
		}
	}

	/**
	 * 检查管理员账号配置
	 * @param string $username
	 * @param string $password
	 * @param string $repassword
	 * @return bool
	 * @author 韩文博
	 */
	public function checkAdminAccount( string $username, string $password, string $repassword ) : bool
	{
		$validate = new Validate();
		if( $validate->is( $username, 'alphaDash' ) !== true ){
			return '账号只能是字母、数字和下划线_及破折号-';
		}
		if( $validate->is( $username, 'min', 5 ) !== true ){
			return '账号最少5位';
		}
		if( $validate->is( $username, 'max', 16 ) !== true ){
			return '账号最多16位';
		}
		if( $validate->is( $password, 'min', 6 ) !== true ){
			return '密码最少6位';
		}
		if( $validate->is( $password, 'max', 32 ) !== true ){
			return '账号最多32位';
		}
		if( $password !== $repassword ){
			return '确认密码不正确';
		}
		return true;
	}
}