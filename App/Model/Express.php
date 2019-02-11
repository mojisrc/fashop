<?php
/**
 * 快递公司数据模型
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



class Express extends Model
{
	protected $softDelete = true;
	protected $createTime = true;


	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addExpress( $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @datetime 2017-10-25 12:11:10
	 * @param array $data
	 * @return boolean
	 */
	public function addExpressAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-10-25 12:11:10
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editExpress( $condition = [], $data = [] )
	{
		$data['update_time'] = time();
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-10-25 12:11:10
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delExpress( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-10-25 12:11:10
	 * @param array $condition 条件
	 * @return int
	 */
	public function getExpressCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取快递公司单条数据
	 * @datetime 2017-10-25 12:11:10
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getExpressInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得快递公司列表
	 * @datetime 2017-10-25 12:11:10
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getExpressList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelExpress( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @return
	 */
	public function getExpressValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @return
	 */
	public function getExpressColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

}

?>