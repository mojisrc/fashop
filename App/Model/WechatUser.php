<?php
/**
 * 微信用户数据模型
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

class WechatUser extends Model
{
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2018-03-05 16:15:59
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addWechatUser( $data = [] )
	{
		$result = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 添加多条
	 * @datetime 2018-03-05 16:15:59
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addWechatUserAll( $data )
	{
		return $this->addAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-03-05 16:15:59
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editWechatUser( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-03-05 16:15:59
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delWechatUser( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-03-05 16:15:59
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getWechatUserCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取微信用户单条数据
	 * @datetime 2018-03-05 16:15:59
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getWechatUserInfo( $condition = [], $field = '*' ,$order = 'id desc')
	{
		$info = $this->where( $condition )->field( $field )->order($order)->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得微信用户列表
	 * @datetime 2018-03-05 16:15:59
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getWechatUserList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>