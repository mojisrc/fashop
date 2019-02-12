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




class Message extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	public function addMessage( array $data )
	{
		return $this->add( $data );
	}

	public function editMessage( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}


	public function delMessage( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getMessageList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10], $group = '' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->group( $group )->page( $page )->select();
		return $list;
	}

	/**
	 * todo
	 * 消息列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @param    string $group
	 * @return   array
	 * @author 孙泉
	 */
	public function getMessageListMore( $condition, $field = '*', $order = "id desc", $page = [1,10], $group = '' )
	{
		$data = $this->alias( 'message' )->join( '__MESSAGE_STATE__ message_state', 'message.id = message_state.message_id', 'LEFT' )->where( $condition )->field( $field )->page( $page )->order( $order )->group( $group )->select();
		return $data;
	}


}

?>