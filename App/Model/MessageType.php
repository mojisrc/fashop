<?php
/**
 * 消息类型数据模型
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


class MessageType extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	public function addMessageType( array $data )
	{
		return $this->add( $data );
	}

	public function editMessageType( array $condition, array $data )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function delMessageType( $condition = [] )
	{
		return $this->where( $condition )->del();
	}


	public function getMessageTypeInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	public function getMessageTypeList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

}

?>