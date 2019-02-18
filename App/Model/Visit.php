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



class Visit extends Model
{
	protected $softDelete = true;
	protected $createTime = true;
	protected $jsonFields = ['model'];

	/**
	 * 添加一条浏览记录
	 * @param string $model             表名
	 * @param int    $model_relation_id 表的关键
	 * @param int    $user_id           用户id
	 *                                  todo 获得当前设备，坐标，request信息
	 */
	public function addVisit( array $data)
	{
//		$data['ip'] = \App\Utils\Ip::getClientIp();
		return $this->add( $data );
	}


	public function editVisit( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}


	public function delVisit( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getVisitCount( $condition )
	{
		return $this->where( $condition )->count();
	}


	public function getVisitInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	public function getVisitList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>