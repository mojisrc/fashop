<?php
/**
 * 商品所选分类
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




class GoodsCategoryIds extends Model
{
	protected $softDelete = true;

	/**
	 * @param array $data
	 * @return bool
	 */
	public function addMultiGoodsCategoryIds( array $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delGoodsCategoryIds( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

}
