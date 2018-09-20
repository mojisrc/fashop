<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/7
 * Time: 上午11:20
 *
 */

namespace App\Utils;

use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\SysConst;
use EasySwoole\Config;

class Environment
{
	/**
	 * 服务器操作系统
	 * @var string
	 */
	private $os;
	/**
	 * 文件上传限制
	 * @var
	 */
	private $uploadMaxFilesize;
	// 最大post
	/**
	 * 最大post
	 * @var
	 */
	private $postMaxSize;
	/**
	 * 以秒为单位对通过POST/GET/PUT方式接受数据时间进行限制
	 * @var
	 */
	private $maxInputTime;
	/**
	 * PHP允许定义内存使用限额
	 * @var
	 */
	private $memoryLimit;
	// 服务器域名／IP
	private $domain;
	private $ip;
	/**
	 * PHP版本
	 * @var string
	 */
	private $phpVersion;
	/**
	 * ZEND 版本
	 * @var string
	 */
	private $zendVersion;
	/**
	 * Mysql版本
	 * @var string
	 */
	private $mysqlVersion;
	/**
	 * 获得服务器系统时间
	 * @var int
	 */
	private $datetime;
	/**
	 * swoole 版本
	 * @var string
	 */
	private $swooleVersion;
	/**
	 * easyswoole 版本
	 * @var string
	 */
	private $easyswooleVersion;
	/**
	 * 当前端口
	 * @var int
	 */
	private $port;
	/**
	 * FaShop版本
	 * @var string
	 */
	private $fashopVersion;

	public function __construct()
	{
		$this->os                 = PHP_OS;
		$this->uploadMaxFilesize  = ini_get( 'upload_max_filesize' );
		$this->postMaxSize        = ini_get( 'post_max_size' );
		$this->maxInputTime       = ini_get( 'max_input_time' );
		$this->memoryLimit        = ini_get( 'memory_limit' );
		$this->phpVersion         = PHP_VERSION;
		$this->zendVersion        = zend_version();
		$this->datetime           = date( 'Y-m-d H:i:s' );
		$this->swooleVersion      = SWOOLE_VERSION;
		$this->easyswoole_version = Di::getInstance()->get( SysConst::VERSION );
		$this->port               = Config::getInstance()->getConf( 'MAIN_SERVER.PORT' );
		$this->fashop_version     = FASHOP_VERSION;
	}

	/**
	 * @return string
	 */
	public function getOs() : string
	{
		return $this->os;
	}

	/**
	 * @param string $os
	 */
	public function setOs( string $os ) : void
	{
		$this->os = $os;
	}

	/**
	 * @return mixed
	 */
	public function getUploadMaxFilesize()
	{
		return $this->uploadMaxFilesize;
	}

	/**
	 * @param mixed $uploadMaxFilesize
	 */
	public function setUploadMaxFilesize( $uploadMaxFilesize ) : void
	{
		$this->uploadMaxFilesize = $uploadMaxFilesize;
	}

	/**
	 * @return mixed
	 */
	public function getPostMaxSize()
	{
		return $this->postMaxSize;
	}

	/**
	 * @param mixed $postMaxSize
	 */
	public function setPostMaxSize( $postMaxSize ) : void
	{
		$this->postMaxSize = $postMaxSize;
	}

	/**
	 * @return mixed
	 */
	public function getMaxInputTime()
	{
		return $this->maxInputTime;
	}

	/**
	 * @param mixed $maxInputTime
	 */
	public function setMaxInputTime( $maxInputTime ) : void
	{
		$this->maxInputTime = $maxInputTime;
	}

	/**
	 * @return mixed
	 */
	public function getMemoryLimit()
	{
		return $this->memoryLimit;
	}

	/**
	 * @param mixed $memoryLimit
	 */
	public function setMemoryLimit( $memoryLimit ) : void
	{
		$this->memoryLimit = $memoryLimit;
	}

	/**
	 * @return mixed
	 */
	public function getDomain()
	{
		return $this->domain;
	}

	/**
	 * @param mixed $domain
	 */
	public function setDomain( $domain ) : void
	{
		$this->domain = $domain;
	}

	/**
	 * @return mixed
	 */
	public function getIp()
	{
		return $this->ip;
	}

	/**
	 * @param mixed $ip
	 */
	public function setIp( $ip ) : void
	{
		$this->ip = $ip;
	}

	/**
	 * @return string
	 */
	public function getPhpVersion() : string
	{
		return $this->phpVersion;
	}

	/**
	 * @param string $phpVersion
	 */
	public function setPhpVersion( string $phpVersion ) : void
	{
		$this->phpVersion = $phpVersion;
	}

	/**
	 * @return string
	 */
	public function getZendVersion() : string
	{
		return $this->zendVersion;
	}

	/**
	 * @param string $zendVersion
	 */
	public function setZendVersion( string $zendVersion ) : void
	{
		$this->zendVersion = $zendVersion;
	}

	/**
	 * @return string
	 */
	public function getMysqlVersion() : string
	{
		$mysql              = db()->query( "SELECT VERSION() as mysql_version" );
		$this->mysqlVersion = $mysql[0]['mysql_version'];
		return $this->mysqlVersion;
	}

	/**
	 * @param string $mysqlVersion
	 */
	public function setMysqlVersion( string $mysqlVersion ) : void
	{
		$this->mysqlVersion = $mysqlVersion;
	}

	/**
	 * @return int
	 */
	public function getDatetime() : int
	{
		return $this->datetime;
	}

	/**
	 * @param int $datetime
	 */
	public function setDatetime( int $datetime ) : void
	{
		$this->datetime = $datetime;
	}

	/**
	 * @return string
	 */
	public function getSwooleVersion() : string
	{
		return $this->swooleVersion;
	}

	/**
	 * @param string $swooleVersion
	 */
	public function setSwooleVersion( string $swooleVersion ) : void
	{
		$this->swooleVersion = $swooleVersion;
	}

	/**
	 * @return string
	 */
	public function getEasyswooleVersion() : string
	{
		return $this->easyswooleVersion;
	}

	/**
	 * @param string $easyswooleVersion
	 */
	public function setEasyswooleVersion( string $easyswooleVersion ) : void
	{
		$this->easyswooleVersion = $easyswooleVersion;
	}

	/**
	 * @return int
	 */
	public function getPort() : int
	{
		return $this->port;
	}

	/**
	 * @param int $port
	 */
	public function setPort( int $port ) : void
	{
		$this->port = $port;
	}

	/**
	 * @return string
	 */
	public function getFashopVersion() : string
	{
		return $this->fashopVersion;
	}

	/**
	 * @param string $fashopVersion
	 */
	public function setFashopVersion( string $fashopVersion ) : void
	{
		$this->fashopVersion = $fashopVersion;
	}


}