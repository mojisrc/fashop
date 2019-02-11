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
	/**
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getSettingInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editSetting( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除
	 * @param  array $condition
	 * @param        $condition_str
	 */
	public function delSetting( array $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->del();
	}

}
