<?php
/**
 * 短信数据模型
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


class Sms extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addSms( $data = [] )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addSmsAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editSms( $condition = [], $data = [] )
	{
		return $this->edit( $data, $condition, true );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delSms( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getSmsCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取短信单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @param string $order     排序
	 * @return array | false
	 */
	public function getSmsInfo( $condition = [], $field = '*', $order = 'id desc' )
	{
		$info = $this->where( $condition )->field( $field )->order( $order )->find();
		return $info;
	}

	/**
	 * 获得短信列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $group
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getSmsList( $condition = [], $field = '*', $group = '', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

}

?>