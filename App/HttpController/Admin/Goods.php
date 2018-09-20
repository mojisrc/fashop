<?php
/**
 *
 * 商品管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 商品管理
 * Class Goods
 * @package App\HttpController\Admin
 */
class Goods extends Admin
{
	/**
	 * 商品列表
	 * @method GET
	 * @param int    sale_state 售卖状态  1出售中 2已售完 3已下架
	 * @param string title 商品名称
	 * @param array  category_ids 分类id 数组格式
	 * @param int    order_type 1商品价格低到高 2商品价格高到低 3销量多到少 4销量少到多 5库存多到少 6库存少到多 7创建时间早到晚 8创建时间晚到早 9排序高到低 10排序低到高
	 */
	public function list()
	{
		$param      = !empty( $this->post ) ? $this->post : $this->get;
		$goodsLogic = new \App\Logic\GoodsSearch( $param );
		return $this->send( Code::success, [
			'total_number' => $goodsLogic->count(),
			'list'         => $goodsLogic->list(),
		] );
	}

	/**
	 * 添加商品
	 * @method POST
	 * @param string title 商品名称
	 * @param array category_ids 商品分类id集合，数组
	 * @param string freight_id 运费模板id
	 * @param int freight_fee 运费
	 * @param string images 商品图
	 * @param string body 商品详情
	 * @param array skus
	 */
	public function add()
	{
		// todo 把sort排序后加入到goods sku表里
		// todo 运费默认0
		if( $this->validate( $this->post, 'Admin/Goods.add' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$goodsLogic = new \App\Logic\Goods( $this->post );
			$state      = $goodsLogic->add();
			if( $state === true ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error, [], $goodsLogic->getException()->getMessage() );
			}
		}
	}

	/**
	 * 修改商品
	 * @method POST
	 * @param int    id
	 * @param string title 商品名称
	 * @param string category_ids 商品分类id集合，数组
	 * @param string freight_id 运费模板id
	 * @param string images 商品图
	 * @param string body 商品详情
	 * @param array skus
	 */
	public function edit()
	{
		if( $this->validate( $this->post, 'Admin/Goods.edit' ) !== true ){
			return $this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$goodsLogic = new \App\Logic\Goods( $this->post );
			$state      = $goodsLogic->edit();
			if( $state === true ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error, [], $goodsLogic->getException()->getMessage() );
			}
		}
	}

	/**
	 * 商品信息
	 * @method GET
	 * @param int id goods_common表id
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Admin/Goods.info' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$info = model( 'Goods' )->getGoodsInfo( ['id' => $this->get['id']], '*' );
			// 获得商品的规格
			$this->send( Code::success, ['info' => $info] );
		}
	}

	/**
	 *删除商品
	 * @method POST
	 * @param array ids 商品id集合 数组形式
	 */
	public function del()
	{
		if( $this->validate( $this->post, 'Admin/Goods.del' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$goodsLogic = new \App\Logic\Goods();
			$result     = $goodsLogic->del( $this->post['ids'] );
			if( $result ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 下架商品
	 * @method POST
	 * @param array ids 商品id集合 数组形式
	 */
	public function offSale()
	{
		if( $this->validate( $this->post, 'Admin/Goods.offSale' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$goodsLogic = new \App\Logic\Goods();
			$result     = $goodsLogic->offSale( $this->post['ids'] );
			if( $result === true ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 上架
	 * @method POST
	 * @param array ids 商品id集合 数组形式
	 */
	public function onSale()
	{
		if( $this->validate( $this->post, 'Admin/Goods.onSale' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$goodsLogic = new \App\Logic\Goods();
			$result     = $goodsLogic->onSale( $this->post['ids'] );
			if( $result === true ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

}

?>