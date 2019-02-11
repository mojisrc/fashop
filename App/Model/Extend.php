<?php
/**
 * 物流数据模型
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



class Extend extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addExtend( array $data )
	{
		return $this->add($data);
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addExtendAll( $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editExtend( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delExtend( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getExtendCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取物流单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getExtendInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得物流列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getExtendList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ;
	}


}

?>