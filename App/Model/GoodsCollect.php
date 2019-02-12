<?php
/**
 * 共用收藏数据模型
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




class GoodsCollect extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addGoodsCollect( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delGoodsCollect( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getGoodsCollectInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}
}

?>