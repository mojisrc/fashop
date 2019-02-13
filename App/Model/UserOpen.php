<?php
/**
 * 第三方帐号信息模型
 */

namespace App\Model;

class UserOpen extends Model
{
	protected $softDelete = true;
	protected $jsonFields = ['info_aggregate'];

	public function getUserOpenList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1, 20], $group = '' )
	{
		$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data;
	}


	public function getUserOpenInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getUserOpenValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getUserOpenColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}


	public function addUserOpen( $insert )
	{
		return $this->add( $insert );
	}


	public function editUserOpen( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}

	public function editMultiUserOpen( $update = [] )
	{
		return $this->editMulti( $update );
	}

}
