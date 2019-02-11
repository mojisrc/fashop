<?php
/**
 * 模板模型
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


class Page extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	protected $jsonFields = ['body'];

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addPage( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editPage( $condition = [], $data = [] )
	{
		$data['update_time'] = time();
		return $this->where($condition)->edit($data);
	}

	/**
	 * 获取模板单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getPageInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得模板列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getPageList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}