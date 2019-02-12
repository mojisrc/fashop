<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/5
 * Time: 下午5:17
 *
 */

namespace App\Model;


/**
 * 用户临时表数据模型
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



class UserTemp extends Model
{
	public function addUserTemp( array $data )
	{
		return $this->add( $data );
	}

	public function editUserTemp( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function delUserTemp( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getUserTempCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	public function getUserTempInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	public function getUserTempList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>