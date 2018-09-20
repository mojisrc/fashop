<?php
/**
 * 权限节点数据模型
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

class AuthRule extends Model
{
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-10-18 17:24:55
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addAuthRule( $data = [] )
	{
		$result = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 添加多条
	 * @datetime 2017-10-18 17:24:55
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addAuthRuleAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-10-18 17:24:55
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editAuthRule( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-10-18 17:24:55
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delAuthRule( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-10-18 17:24:55
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getAuthRuleCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取权限节点单条数据
	 * @datetime 2017-10-18 17:24:55
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getAuthRuleInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得权限节点列表
	 * @datetime 2017-10-18 17:24:55
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getAuthRuleList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>