<?php
/**
 * 店铺的商品评论模型
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


class GoodsEvaluate extends Model
{
	protected $softDelete = true;
	protected $createTime = true;
	protected $jsonFields = ['images', 'additional_images'];

	/**
	 * 根据商品编号查询商品评价信息
	 * @datetime 2017-05-28T21:49:53+0800
	 * @param    int $goods_id 商品id
	 * @return   array
	 */
	public function getGoodsEvaluateInfoByGoodsID( $goods_id )
	{

		$info   = [];
		$good   = $this->field( 'count(*) as count' )->where( [
			'goods_id' => $goods_id,
			'score'    => ['in', '4,5'],
		] )->find();
		$normal = $this->field( 'count(*) as count' )->where( [
			'goods_id' => $goods_id,
			'score'    => ['in', '2,3'],
		] )->find();
		$bad    = $this->field( 'count(*) as count' )->where( [
			'goods_id' => $goods_id,
			'score'    => ['in', '1'],
		] )->find();
		$image  = $this->field( 'count(*) as count' )->where( [
			'goods_id' => $goods_id,
			'images'   => "not null",
		] )->find();

		$info['good']   = $good['count'];
		$info['normal'] = $normal['count'];
		$info['bad']    = $bad['count'];
		$info['all']    = $info['good'] + $info['normal'] + $info['bad'];
		$info['image']  = $image;

		if( intval( $info['all'] ) > 0 ){
			$info['good_percent']   = intval( $info['good'] / $info['all'] * 100 );
			$info['normal_percent'] = intval( $info['normal'] / $info['all'] * 100 );
			$info['bad_percent']    = intval( $info['bad'] / $info['all'] * 100 );
			$info['good_star']      = ceil( $info['good'] / $info['all'] * 5 );
		} else{
			$info['good_percent']   = 100;
			$info['normal_percent'] = 0;
			$info['bad_percent']    = 0;
			$info['good_star']      = 5;
		}
		// 更新商品表好评星级和评论数 todo 废除
		$goods_model                  = model( 'Goods' );
		$update                       = [];
		$update['evaluate_good_star'] = $info['good_star'];
		$update['evaluate_count']     = $info['all'];
		\App\Model\Goods::editGoods( 'id='.$goods_id, $update );
		return $info;
	}

	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addGoodsEvaluate( array $data )
	{
		return $this->add( $data );
	}


	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
	 */
	public function editGoodsEvaluate(array $condition , array $data )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getGoodsEvaluateInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}

}
