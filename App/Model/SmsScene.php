<?php
/**
 * 短信场景数据模型
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

class SmsScene extends Model
{
	protected $createTime = true;

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addSmsScene( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editSmsScene( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delSmsScene( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 获取短信场景单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getSmsSceneInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得短信场景列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getSmsSceneList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>