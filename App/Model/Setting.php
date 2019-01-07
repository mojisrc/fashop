<?php
/**
 * 配置
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;

use ezswoole\Model;

class Setting extends Model
{
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	protected $type
		= [
			'config' => 'json',
		];

	/**
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getSettingInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editSetting( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @param  array $condition
	 * @param        $condition_str
	 */
	public function delSetting( array $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->delete();
	}

}
