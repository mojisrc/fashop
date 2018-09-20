<?php
/**
 * 素材数据模型
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

class Material extends Model
{
	protected $resultSetType = 'collection';
	protected $type
		= [
			'media' => 'json',
		];

	/**
	 * 添加
	 * @datetime 2018-02-03 10:33:28
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addMaterial( $data = [] )
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
	 * @datetime 2018-02-03 10:33:28
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addMaterialAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-02-03 10:33:28
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editMaterial( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-02-03 10:33:28
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delMaterial( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-02-03 10:33:28
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getMaterialCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取素材单条数据
	 * @datetime 2018-02-03 10:33:28
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getMaterialInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得素材列表
	 * @datetime 2018-02-03 10:33:28
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getMaterialList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>