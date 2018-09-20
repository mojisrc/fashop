<?php
/**
 * 自动回复数据模型
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

class WechatAutoReplyKeywords extends Model
{
	protected $resultSetType = 'collection';
	protected $type
		= [
			'replay_content' => 'json',
		];

	/**
	 * 添加
	 * @datetime 2018-02-05 13:32:05
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addWechatAutoReplyKeywords( $data = [] )
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
	 * @datetime 2018-02-05 13:32:05
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addWechatAutoReplyKeywordsAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-02-05 13:32:05
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editWechatAutoReplyKeywords( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-02-05 13:32:05
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delWechatAutoReplyKeywords( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-02-05 13:32:05
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getWechatAutoReplyKeywordsCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取自动回复单条数据
	 * @datetime 2018-02-05 13:32:05
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getWechatAutoReplyKeywordsInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得自动回复列表
	 * @datetime 2018-02-05 13:32:05
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getWechatAutoReplyKeywordsList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>