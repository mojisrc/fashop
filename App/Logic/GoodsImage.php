<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/10
 * Time: 下午4:04
 *
 */

namespace App\Logic;

class GoodsImage
{
	public function __construct( array $options = [] )
	{
		if( isset( $options['goods_id'] ) ){
			$this->goodsId = $options['goods_id'];
		}
		if( isset( $options['images'] ) ){
			$this->images = $options['images'];
		}
	}

	/**
	 * @var \App\Model\GoodsImage
	 */
	private $model;
	/**
	 * @var int
	 */
	private $goodsId;
	/**
	 * @var array
	 */
	private $images;

	/**
	 * @return mixed
	 */
	public function getModel() : \App\Model\GoodsImage
	{
		if( !$this->model instanceof \App\Model\GoodsImage ){
			$this->model = model( 'GoodsImage' );
		}
		return $this->model;
	}

	/**
	 * @param mixed $model
	 */
	public function setModel( $model ) : void
	{
		$this->model = $model;
	}


	/**
	 * @return bool
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function add() : bool
	{
		foreach( $this->images as $key => $img ){
			$addData[$key] = [
				'goods_id' => $this->goodsId,
				'img'      => $img,
			];
			if( $key === 0 ){
				$addData[$key]['is_default'] = 1;
			} else{
				$addData[$key]['is_default'] = 0;
			}
		}
		$count = $this->getModel()->addGoodsImageAll( $addData );
		if( $count > 0 ){
			return true;
		} else{
			throw new \Exception( "goods image add fail" );
		}
	}

	public static function make( array $options = [] ) : GoodsImage
	{
		return new static( $options );
	}

	/**
	 * @return bool
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function del() : bool
	{
		$state = $this->getModel()->delGoodsImage( ['goods_id' => $this->goodsId] );
		if( $state !== true ){
			throw new \Exception( "goods image del fail" );
		} else{
			return true;
		}
	}
}