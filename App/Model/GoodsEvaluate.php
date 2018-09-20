<?php
/**
 * 店铺的商品评论模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;

use ezswoole\Model;
use traits\model\SoftDelete;

class GoodsEvaluate extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';
	protected $type
		= [
			'images'            => 'json',
			'additional_images' => 'json',
		];

	/**
	 * 查询评价列表
	 * @datetime 2017-05-28T21:48:45+0800
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $order
	 * @param    string $field
	 * @param    string $page
	 * @return   array
	 */
	public function getGoodsEvaluateList( $condition, $field = '*', $order = 'id desc', $page = '1,20' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		$list = $list ? $list->toArray() : [];
		return $list;
	}

	/**
	 * 根据编号查询商品评价
	 * @method     GET
	 * @datetime 2017-05-28T21:49:17+0800
	 * @author   韩文博
	 * @param    int $id 评价id
	 * @return   array
	 */
	public function getGoodsEvaluateInfoByID( $id )
	{
		if( intval( $id ) <= 0 ){
			return false;
		}
		$info = $this->alias( 'evaluate' )->join( '__USER__ user', 'user.id = evaluate.user_id', 'LEFT' )->field( 'evaluate.*,user.avatar,user.nickname' )->where( [
			'evaluate.id' => $id,
		] )->find();
		$info = $info ? $info->toArray() : [];
		unset( $info['images'] );
		return $info;
	}

	/**
	 * 根据商品编号查询商品评价信息
	 * @datetime 2017-05-28T21:49:53+0800
	 * @author   韩文博
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
		$goods_model->editGoods( 'id='.$goods_id, $update );
		return $info;
	}

	/**
	 * 添加商品评价
	 */
	public function addGoodsEvaluate( array $insert )
	{
		$insert['create_time'] = time();
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 */
	public function editGoodsEvaluate( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 批量添加商品评价
	 */
	public function addGoodsEvaluateAll( $param )
	{
		return $this->insertAll( $param );
	}

	/**
	 * 删除商品评价
	 */
	public function delGoodsEvaluate( $condition )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelGoodsEvaluate( $condition )
	{
		$find = $this->where( $condition )->find();
		if( $find ){
			return $find->delete();
		} else{
			return false;
		}
	}

	/**
	 * 获得大条信息
	 * @param  array $condition
	 * @param  string] $field
	 */
	public function getGoodsEvaluateInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data ? $data->toArray() : [];
	}

}
