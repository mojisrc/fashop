<?php
/**
 * 商品图片数据模型
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

//

class GoodsImage extends Model
{
	//    protected $softDelete = true;
	protected $createTime = true;


	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addGoodsImage( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addGoodsImageAll( $data )
	{
		return $this->addMulti( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editGoodsImage( $condition = [], $data = [] )
	{
		// return $this->foreach ($condition as $key => $value) {
		// 	$this->db->where($key, $value);
		// }
		// return $this->db->edit($this->table, $data);
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delGoodsImage( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getGoodsImageCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取商品图片单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array
	 */
	public function getGoodsImageInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得商品图片列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getGoodsImageList( $condition = [], $field = '*', $order = '', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	/**
	 * 列表更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getGoodsImageMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getGoodsImageMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods.id', 'LEFT' )->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 软删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function softDelGoodsImage( $condition = [] )
	{
		return $this->save( ['delete_time' => time()], $condition );
	}

}

?>