<?php
/**
 * 地区数据模型
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

class Area extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-04-20 18:07:52
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addArea( $data = [] )
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
	 * @datetime 2017-04-20 18:07:52
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addAreaAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-04-20 18:07:52
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editArea( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-04-20 18:07:52
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delArea( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-04-20 18:07:52
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getAreaCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取地区单条数据
	 * @datetime 2017-04-20 18:07:52
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array
	 */
	public function getAreaInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得地区列表
	 * @datetime 2017-04-20 18:07:52
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getAreaList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelArea( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}


	/**
	 * 获取id
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getAreaId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getAreaValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getAreaColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}
}

?>