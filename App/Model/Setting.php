<?php
/**
 * 配置
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

class Setting extends Model
{
	protected $jsonFields = ['config'];

	public function getSettingInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}
	public function editSetting( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}
	public function delSetting( array $condition = [] )
	{
		return $this->where( $condition )->del();
	}

}
