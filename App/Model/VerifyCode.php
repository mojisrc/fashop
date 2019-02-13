<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/9
 * Time: 下午9:25
 *
 */

namespace App\Model;


class VerifyCode extends Model
{
	protected $createTime = true;

	public function addVerifyCode( array $data )
	{
		return $this->add( $data );
	}


	public function editVerifyCode( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function delVerifyCode( $condition = [] )
	{
		return $this->where( $condition )->del();
	}


	public function getVerifyCodeCount( $condition )
	{
		return $this->where( $condition )->count();
	}


	public function getVerifyCodeInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}


	public function getVerifyCodeList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10], $group = '' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->group( $group )->page( $page )->select();
		return $list;
	}

}

?>