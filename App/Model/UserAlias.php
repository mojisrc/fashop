<?php
/**
 * 用户ID别名模型
 */

namespace App\Model;


class UserAlias extends Model
{
	protected $softDelete = true;

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function addUserAlias( $insert = [] )
	{
		return $this->add( $insert );
	}

}
