<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/5
 * Time: 下午5:20
 *
 */

namespace App\Model;

use ezswoole\Model;

class UserWechat extends Model
{

	public function addUserWechat( array $data )
	{
		return $this->add( $data );
	}

	public function editUserWechat( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function delUserWechat( $condition = [] )
	{
		return $this->where( $condition )->del();
	}


	public function getUserWechatInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	public function getUserWechatList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>