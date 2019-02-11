<?php
/**
 * 浏览记录数据模型
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

class Visit extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * 添加一条浏览记录
	 * @param string $model             表名
	 * @param int    $model_relation_id 表的关键
	 * @param int    $user_id           用户id
	 *                                  todo 获得当前设备，坐标，request信息
	 */
	public function addVisit( $model, $model_relation_id, $user_id = 0 )
	{
		$data = [
			'model'             => $model,
			'model_relation_id' => $model_relation_id,
			'create_time'       => time(),
			'user_id'           => $user_id,
			'ip'                => \App\Utils\Ip::getClientIp(),
		];
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addVisitAll( $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editVisit( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delVisit( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getVisitCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取浏览记录单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getVisitInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得浏览记录列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getVisitList( $condition = [], $field = '*', $order = '', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>