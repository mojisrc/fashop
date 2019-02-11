<?php
/**
 * 运费模板模型
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


class Freight extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	protected $type
		= [
			'areas' => 'json',
		];

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addFreight( array $data )
	{
		return $this->add($data);
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addFreightAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editFreight( $condition = [], $data = [] )
	{
		$data['update_time'] = time();
		return $this->update( $data, $condition, true );
	}

	/**
	 * 获取单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getFreightInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获取总条数
	 * @method
	 * @param $condition
	 * @author   沈旭
	 */
	public function getFreightCount( $condition )
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
	public function getFreightList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelFreight( $condition )
	{
		$find = $this->where( $condition )->find();
		if( $find ){
			return $find->delete();
		} else{
			return false;
		}
	}
}