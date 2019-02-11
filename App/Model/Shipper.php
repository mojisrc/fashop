<?php
/**
 * 商家地址库模型
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


class Shipper extends Model
{

	protected $softDelete = true;
	protected $createTime = true;


	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addShipper( $data = [] )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addShipperAll( $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editShipper( $condition = [], $data = [] )
	{
		$data['update_time'] = time();
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 获取单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getShipperInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获取总条数
	 * @method
	 * @param $condition
	 */
	public function getShipperCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获得列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getShipperList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	/**
	 * 删除
	 *
	 * @param array  $insert 数据
	 * @param string $table  表名
	 */
	public function delShipper( $condition )
	{
		return $this->where( $condition )->del();
	}
}