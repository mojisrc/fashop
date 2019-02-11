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
	 * @datetime 2017-07-24 22:47:42
	 * @param array $data
	 * @return boolean
	 */
	public function addExtendAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-07-24 22:47:42
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editExtend( $condition = [], $data = [] )
	{
		return $this->where( $condition )->update( $data );
	}

	/**
	 * 删除
	 * @datetime 2017-07-24 22:47:42
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delExtend( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-07-24 22:47:42
	 * @param array $condition 条件
	 * @return int
	 */
	public function getExtendCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取物流单条数据
	 * @datetime 2017-07-24 22:47:42
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
	 * @datetime 2017-07-24 22:47:42
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getExtendList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelExtend( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}
}

?>