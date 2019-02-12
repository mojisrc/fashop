<?php
/**
 * 商品类别模型
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




class GoodsCategory extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addGoodsCategory( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
	 */
	public function editGoodsCategory( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delGoodsCategory( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * @param        $condition
	 * @param string $field
	 * @param string $order
	 * @param string $page
	 * @return array|bool|false|null
	 */
	public function getGoodsCategoryList( $condition, $field = '*', $order = 'pid asc,sort asc,id asc', $page = [1, 10] )
	{
		$list = $this->field( $field )->where( $condition )->order( $order )->page( $page )->select();
		return $list;
	}

	/**
	 * @param        $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getGoodsCategoryInfo( $condition, $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

}

?>