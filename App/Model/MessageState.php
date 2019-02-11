<?php
/**
 * 消息状态表数据模型
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

class MessageState extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	public function addMessageState( array $data )
	{
		return $this->add( $data );
	}

	public function addMultiMessageState( array $data )
	{
		return $this->addMulti( $data );
	}

	public function editMessageState( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}


	public function delMessageState( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 更新消息{已读，已删除}
	 * @param int   $user_id
	 * @param array $ids
	 * @param array $data
	 * @return bool|mixed
	 */
	public function updateMessageState( int $user_id, array $ids,array $data )
	{
		if( $user_id > 0 && !empty( $ids ) ){
			$condition['to_user_id'] = $user_id;
			$condition['id']         = ['in', $ids];
			return $this->where( $condition )->edit( $data );
		} else{
			return false;
		}
	}

}

?>