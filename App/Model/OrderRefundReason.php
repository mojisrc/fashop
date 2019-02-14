<?php

namespace App\Model;




class OrderRefundReason extends Model
{
	protected $softDelete = true;

	/**
	 * 退款\退款退货原因列表
	 * @param         $condition
	 * @param         $field
	 * @param         $order
	 * @param  string $page
	 * @return             [退款\退款退货原因(线上+线下)列表数据]
	 */
	public function getOrderRefundReasonList( $condition = [], $field = '*', $order = 'id asc', $page = [1,20] )
	{
		$data = $this->order( $order )->where( $condition )->field( $field )->page( $page )->select();
		return $data;
	}

	/**
	 * 获得退款\退款退货原因信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getOrderRefundReasonInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

	/**
	 * 修改退款\退款退货原因信息
	 * @param   $update
	 * @param   $condition
	 * @return
	 */
	public function editOrderRefundReason( $update, $condition )
	{
		return $this->where( $condition )->edit( $update );
	}

	/**
	 * 退款\退款退货原因加入 单条数据
	 *
	 * @param array  $insert 数据
	 * @param string $table  表名
	 */
	public function insertOrderRefundReason( $insert )
	{
		return $this->insertGetId( $insert );
	}

	/**
	 * 退款\退款退货原因加入 多条数据
	 *
	 * @param array  $insert 数据
	 * @param string $table  表名
	 */
	public function insertAllOrderRefundReason( $insert )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 退款\退款退货原因删除
	 *
	 * @param array  $insert 数据
	 * @param string $table  表名
	 */
	public function delOrderRefundReason( $condition )
	{
		return $this->where( $condition )->del();
	}


}
