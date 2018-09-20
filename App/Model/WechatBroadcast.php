<?php
/**
 * 微信群发数据模型
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

class WechatBroadcast extends Model
{
	protected $resultSetType = 'collection';
	protected $type
		= [
			'condition'    => 'json',
			'send_content' => 'json',
		];
	/**
	 * 添加
	 * @datetime 2018-02-05 19:27:36
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addWechatBroadcast( $data = [] )
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
	 * @datetime 2018-02-05 19:27:36
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addWechatBroadcastAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-02-05 19:27:36
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editWechatBroadcast( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-02-05 19:27:36
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delWechatBroadcast( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-02-05 19:27:36
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getWechatBroadcastCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取微信群发单条数据
	 * @datetime 2018-02-05 19:27:36
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getWechatBroadcastInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得微信群发列表
	 * @datetime 2018-02-05 19:27:36
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getWechatBroadcastList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>