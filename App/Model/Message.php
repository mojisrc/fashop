<?php
/**
 * 消息数据模型
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


class Message extends Model
{
	protected $softDelete = true;
	protected $createTime = true;


	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addMessage( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addMessageAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editMessage( $condition = [], $data = [] )
	{
		return $this->edit( $data, $condition, true );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delMessage( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getMessageCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取消息单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getMessageInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
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
	public function getMessageList( $condition = [], $field = '*', $order = '', $page = '1,10', $group = '' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->group( $group )->page( $page )->select();
		return $list;
	}

	/**
	 * 消息列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @param    string $group
	 * @return   array
	 * @author 孙泉
	 */
	public function getMessageListMore( $condition, $field = '*', $order = "id desc", $page = '1,10', $group = '' )
	{
		$data = $this->alias( 'message' )->join( '__MESSAGE_STATE__ message_state', 'message.id = message_state.message_id', 'LEFT' )->where( $condition )->field( $field )->page( $page )->order( $order )->group( $group )->select();
		return $data ? $data->toArray() : $data;
	}


}

?>