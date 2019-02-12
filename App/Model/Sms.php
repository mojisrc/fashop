<?php
/**
 * 短信数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;

use ezswoole\Model;


class Sms extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	public function addSms( $data = [] )
	{
		return $this->add( $data );
	}
	public function editSms( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function delSms( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getSmsInfo( $condition = [], $field = '*', $order = 'id desc' )
	{
		$info = $this->where( $condition )->field( $field )->order( $order )->find();
		return $info;
	}

	public function getSmsList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

}

?>