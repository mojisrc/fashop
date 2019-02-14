<?php
/**
 * 用户辅助信息模型
 */

namespace App\Model;

class UserProfile extends Model
{
	protected $softDelete = true;

	public function getUserProfileInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}


}
