<?php
/**
 * 支付模型
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

class SmsProvider extends Model
{
	protected $resultSetType = 'collection';
	protected $type
		= [
			'config' => 'json',
		];


	/**
	 * 读取单行信息
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getSmsProviderInfo( $condition = [], $field = '*' ) : ? array
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : null;
	}


	/**
	 * 获得支付方式列表
	 * @datetime 2017-05-18 18:11:40
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getSmsProviderList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}


	/**
	 * 更新信息
	 */
	public function editSmsProvider( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

}
