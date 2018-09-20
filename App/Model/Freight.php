<?php
/**
 * 运费模板模型
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

class Freight extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';
	protected $type
		= [
			'areas' => 'json',
		];

	/**
	 * 添加
	 * @datetime 2017-10-17 15:18:56
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addFreight( $data = [] )
	{
		$data['create_time'] = time();
		$result              = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 添加多条
	 * @datetime 2017-10-17 15:18:56
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addFreightAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-10-17 15:18:56
	 * @author   韩文博
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
	 * @datetime 2017-10-17 15:18:56
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getFreightInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获取总条数
	 * @method
	 * @param $condition
	 * @datetime 2017/12/21 0021 下午 2:47
	 * @author   沈旭
	 */
	public function getFreightCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获得列表
	 * @datetime 2017-10-17 15:18:56
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getFreightList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
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