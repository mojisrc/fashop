<?php
/**
 * 店铺数据模型
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




class Shop extends Model
{
	protected $createTime = true;

	public function addShop( $data = [] )
	{
		return $this->add( $data );
	}

	public function editShop( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function delShop( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getShopCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	public function getShopInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

}

?>