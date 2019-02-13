<?php
/**
 * 用户资产模型
 */

namespace App\Model;


class UserAssets extends Model
{
	protected $softDelete = true;

	public function getUserAssetsInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}


	public function addUserAssets( $insert = [] )
	{
		return $this->add( $insert );
	}


	public function editUserAssets( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}


}
