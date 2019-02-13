<?php
/**
 * 用户辅助信息模型
 */

namespace App\Model;

class UserProfile extends Model
{
	protected $softDelete = true;

	public function getUserProfileInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	public function getUserProfileMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->join( 'user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

}
