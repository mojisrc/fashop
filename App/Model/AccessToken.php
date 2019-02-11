<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/9
 * Time: 下午9:25
 *
 */

namespace App\Model;

use ezswoole\Model;

class AccessToken extends Model
{
	// todo addAll
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addAccessToken( array $data )
	{
		$data['ip'] = \App\Utils\Ip::getClientIp();
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addAccessTokenAll( $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editAccessToken( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delAccessToken( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getAccessTokenCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取权限单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getAccessTokenInfo( $condition = [], $field = '*', $order = 'create_time desc' )
	{
		$info = $this->where( $condition )->field( $field )->order( $order )->find();
		return $info;
	}

	/**
	 * 获得消息列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @param    string $group
	 * @return   array | false
	 */
	public function getAccessTokenList( $condition = [], $field = '*', $order = '', $page = [1, 10], $group = '' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->group( $group )->page( $page )->select();
		return $list;
	}

}

?>