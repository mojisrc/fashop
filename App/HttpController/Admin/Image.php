<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/1
 * Time: 下午9:02
 *
 */

namespace App\HttpController\Admin;

use App\Logic\Wechat\Factory as WechatFactory;
use App\Utils\Code;
use ezswoole\utils\image\Image as ImageClass;

/**
 * 图片管理
 * Class Image
 * @package App\HttpController\Admin
 * @property \App\Logic\Wechat\Factory $wechat
 */
class Image extends Admin
{
	protected $wechat;

	protected function _initialize()
	{
		//		$this->wechat = new WechatFactory();//此版本不支持
	}

	/**
	 * 应用图片列表
	 * @method GET
	 * @param array $create_time
	 * @author 韩文博
	 */
	public function list()
	{
		$condition = [];
		if( isset( $this->get['create_time'] ) ){
			$condition['create_time'] = [
				'between',
				[$this->get['create_time']],
			];
		}
		$model = model( 'Image' );
		$list  = $model->getImageList( $condition, '*', 'create_time desc', $this->getPageLimit() );
		return $this->send( Code::success, [
			'total_number' => $model->where( $condition )->count(),
			'list'         => $list ? $list : [],
		] );
	}

	/**
	 * 微信图片列表
	 * @method GET
	 * @param int $offset
	 * @param int $count
	 * @author 韩文博
	 */
	public function wechat()
	{
		if( $this->validate( $this->get, 'Admin/Image.wechat' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$list = $this->wechat->material->list( 'image', $this->get->offset, $this->get->count );
			return $this->send( Code::success, $list );
		}
	}

	/**
	 * 上传图片
	 * @method POST
	 * @param string $name
	 * @param string $image
	 * @param string $is_save
	 * @author 韩文博
	 */
	public function add()
	{
		if( $this->validate( $this->get, 'Admin/Image.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			try{
				$images = ImageClass::getInstance()->create( $this->post->image )->crop()->getImages();
				if( $images ){
					$host = $this->request->domain()."/";
					if( isset( $this->post['is_save'] ) && $this->post['is_save'] == 1 ){
						$data = [
							'url'  => $host.$images['origin']['path'],
							'size' => $images['origin']['size'],
							'type' => $images['origin']['type'],
						];
						if( isset( $this->post['name'] ) ){
							$data['name'] = $this->post['name'];
						}
						model( 'Image' )->addImage( $data );
					}
					foreach( $images as $key => $image ){
						$images[$key]['path'] = $host.$image['path'];
					}
					$this->send( Code::success, $images );
				} else{
					$this->send( Code::param_error, [], $this->getValidate()->getError() );
				}
			} catch( \Exception $e ){
				$this->send( Code::error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 删除图片
	 * @method POST
	 * @author 韩文博
	 */
	public function del()
	{
		if( $this->validate( $this->post, 'Admin/Image.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Image' )->delImage( ['id' => $this->post['id']] );
			$this->send( Code::success );
		}
	}

	/**
	 * 提取网络图片
	 * @method POST
	 * @param string $url
	 * @author 韩文博
	 */
	public function remoteGrab()
	{
		// todo v1 版本不需要
	}

	/**
	 * 商品图列表
	 * @method GET
	 * @param string $keywords
	 * @author 韩文博
	 */
	public function goodsImageList()
	{
		$condition                           = [];
		$condition['goods_image.is_default'] = 1;
		if( isset( $this->get['keywords'] ) ){
			$condition['goods.title'] = ['like', '%'.$this->get['keywords'].'%'];
		}

		$field = 'goods_image.id,goods_image.goods_id,goods_image.img,goods.title';

		$model = model( 'GoodsImage' );
		$list  = $model->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods_id', 'LEFT' )->where( $condition )->field( $field )->order( 'goods_image.goods_id' )->group( 'goods_image.id' )->page( $this->getPageLimit() )->select();
		$count = $model->alias( 'goods_image' )->join( '__GOODS__ goods', 'goods_image.goods_id = goods_id', 'LEFT' )->where( $condition )->field( $field )->count( "distinct goods_image.id" );

		return $this->send( Code::success, [
			'totol_number' => $count,
			'list'         => $list ? $list->toArray() : [],
		] );
	}
}