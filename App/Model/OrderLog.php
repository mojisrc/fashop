<?php
/**
 * 订单日志模型
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




class OrderLog extends Model
{
	protected $softDelete = true;
	protected $createTime = true;
	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addOrderLog( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 获得订单日志列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getOrderLogList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}


}

?>