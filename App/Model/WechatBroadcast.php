<?php
/**
 * 微信群发数据模型
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

class WechatBroadcast extends Model
{
	protected $createTime = true;
	protected $type
		= [
			'condition'    => 'json',
			'send_content' => 'json',
		];
	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addWechatBroadcast( array $data )
	{
		return $this->add($data);
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addWechatBroadcastAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editWechatBroadcast( $condition = [], $data = [] )
	{
		return $this->edit( $data, $condition, true );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delWechatBroadcast( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getWechatBroadcastCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取微信群发单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getWechatBroadcastInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得微信群发列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getWechatBroadcastList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ;
	}
}

?>