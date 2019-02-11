<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/4
 * Time: 下午1:30
 *
 */

namespace App\Model;

/**
 * 微信数据模型
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

class Wechat extends Model
{
	protected $type
		= [
			'auto_reply_subscribe_replay_content' => 'json',
		];

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addWechat( array $data )
	{
		return $this->add($data);
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addWechatAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editWechat( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delWechat( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getWechatCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取微信单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getWechatInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得微信列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getWechatList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ;
	}
}

?>