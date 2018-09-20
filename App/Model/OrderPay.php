<?php
/**
 * 订单支付记录模型
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
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class OrderPay extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2018-04-06 22:19:06
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addOrderPay( $data = [] )
	{
		return $this->save($data) ? $this->id : false;

	}

	/**
	 * 添加多条
	 * @datetime 2018-04-06 22:19:06
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addOrderPayAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-04-06 22:19:06
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   $this
	 */
	public function editOrderPay( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-04-06 22:19:06
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delOrderPay( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-04-06 22:19:06
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getOrderPayCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取订单支付单条数据
	 * @datetime 2018-04-06 22:19:06
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getOrderPayInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得订单支付列表
	 * @datetime 2018-04-06 22:19:06
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getOrderPayList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelOrderPay( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}
}

?>