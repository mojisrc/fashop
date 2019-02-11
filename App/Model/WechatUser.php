<?php
/**
 * 微信用户数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;

use ezswoole\Model;

class WechatUser extends Model
{
	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addWechatUser( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addWechatUserAll( $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editWechatUser( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delWechatUser( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getWechatUserCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取微信用户单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getWechatUserInfo( $condition = [], $field = '*', $order = 'id desc' )
	{
		$info = $this->where( $condition )->field( $field )->order( $order )->find();
		return $info;
	}

	/**
	 * 获得微信用户列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getWechatUserList( $condition = [], $field = '*', $order = '', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>