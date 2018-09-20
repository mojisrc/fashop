<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/4
 * Time: 下午1:30
 *
 */

namespace App\Model;

/**
 * 微信数据模型
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

class Wechat extends Model
{
	protected $resultSetType = 'collection';

	protected $type
		= [
			'auto_reply_subscribe_replay_content' => 'json',
		];

	/**
	 * 添加
	 * @datetime 2018-02-04 13:30:39
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addWechat( $data = [] )
	{
		$result = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 添加多条
	 * @datetime 2018-02-04 13:30:39
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addWechatAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-02-04 13:30:39
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editWechat( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-02-04 13:30:39
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delWechat( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-02-04 13:30:39
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getWechatCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取微信单条数据
	 * @datetime 2018-02-04 13:30:39
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getWechatInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得微信列表
	 * @datetime 2018-02-04 13:30:39
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getWechatList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>