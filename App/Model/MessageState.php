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


	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addMessageState( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addMessageStateAll( array $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editMessageState( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delMessageState( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getMessageStateCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取消息状态表单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getMessageStateInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得消息状态表列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getMessageStateList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	/**
	 * 更新消息{已读，已删除}
	 * @param $user_id 用户id
	 * @param $ids     消息id
	 * @param $type    消息类型  1系统消息
	 */
	public function updateMessageState( $user_id, $ids, $param )
	{
		if( $user_id > 0 && !empty( $ids ) ){
			$condition['to_user_id'] = $user_id;
			$condition['id']         = ['in', $ids];
			return $this->where( $condition )->update( $param );
		} else{
			return false;
		}
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelMessageState( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}
}

?>