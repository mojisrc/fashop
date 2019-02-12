<?php
/**
 * 支付模型
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



class SmsProvider extends Model
{
	protected $jsonFields = ['config'];

	public function getSmsProviderInfo( $condition = [], $field = '*' ) : ?array
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	public function getSmsProviderList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	public function editSmsProvider( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

}
