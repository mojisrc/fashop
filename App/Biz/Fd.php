<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019/1/6
 * Time: 3:04 PM
 *
 */

namespace App\Biz;


class Fd
{
	protected $tabel;

	/**
	 * Client constructor.
	 * @param array $config
	 * @throws \ezswoole\Exception
	 */
	public function __construct( $config = [] )
	{
		$this->tabel = db( 'Fd' );
	}

	/**
	 * 没有才添加
	 * 设置用户
	 * @param    int $uid
	 */
	public function add( int $uid, int $fd ) : bool
	{
		try{
			$result = $this->tabel->insert( [
				'uid' => $uid,
				'fd'  => $fd,
			] );
			return $result ? true : false;
		} catch( \Exception $e ){
			return false;
		}
	}

	/**
	 * 删除用户并删除所有相关客户端
	 * @param    int $fd
	 * @return   bool
	 */
	public function del( int $fd )
	{
		try{
			$result = $this->tabel->delete( [
				'fd' => $fd,
			] );
			return $result ? true : false;
		} catch( \Exception $e ){
			return false;
		}
	}

	/**
	 * 获得用户的所有client
	 * @http     get
	 * @param    int $uid
	 * @return   array
	 */
	public function user( int $uid ) : array
	{
		try{
			return $this->tabel->where( ['uid' => $uid] )->column( 'fd' );
		} catch( \Exception $e ){
			return [];
		}
	}

	/**
	 * 获得某个
	 * 使用场景：判断这个用户是否登陆了
	 * @param int $fd
	 * @return mixed
	 */
	public function get( int $fd ) : ?array
	{
		try{
			return $this->tabel->where( ['fd' => $fd] )->find();
		} catch( \Exception $e ){
			return null;
		}
	}

	/**
	 * 每次重启服务应该重置所有数据
	 * @return bool
	 */
	static function clearAll() : bool
	{
		try{
			$table = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix')."fd";
			db()->execute( "truncate {$table}" );
			return true;
		} catch( \Exception $e ){
			return false;
		}
	}
}