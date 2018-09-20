<?php

namespace App\HttpController\Server;

use App\Utils\Code;

/**
 * 商品分类
 * Class Goodscategory
 * @package App\HttpController\Server
 */
class Goodscategory extends Server
{
	/**
	 * 商品分类列表
	 * @method GET
	 * @author 韩文博
	 */
	public function list()
	{
		$goods_category_model = model( 'GoodsCategory' );
		$condition            = [];
		$order                = 'sort asc';
		$list                 = $goods_category_model->getGoodsCategoryList( $condition, 'id,name,pid,icon,banner', $order, '1,1000' );
		$list                 = \App\Utils\Tree::listToTree( $list, 'id', 'pid', '_child', 0 );
		$this->send( Code::success, [
			'list' => $list,
		] );
	}
	/**
	 * 商品分类详情
	 * @method GET
	 * @param  int $id ID
	 * @author 韩文博
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Server/GoodsCategory.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$goods_category_model = model( 'GoodsCategory' );
			$info                 = $goods_category_model->getGoodsCategoryInfo( ['id' => $this->get['id']], '*' );
			if( !$info ){
				$this->send( Code::param_error, [] );
			} else{
				$this->send( Code::success, ['info' => $info] );
			}
		}
	}


}

?>