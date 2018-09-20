<?php
/**
 * 短信场景数据模型
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

class SmsScene extends Model
{
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2018-02-08 20:15:05
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addSmsScene( $data = [] )
	{
		$data['create_time'] = time();
		$result              = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 修改
	 * @datetime 2018-02-08 20:15:05
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editSmsScene( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-02-08 20:15:05
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delSmsScene( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 获取短信场景单条数据
	 * @datetime 2018-02-08 20:15:05
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getSmsSceneInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得短信场景列表
	 * @datetime 2018-02-08 20:15:05
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getSmsSceneList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>