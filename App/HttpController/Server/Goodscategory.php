<?php

namespace App\HttpController\Server;

use App\Utils\Code;

/**
 * 商品分类
 * @package App\HttpController\Server
 */
class Goodscategory extends Server
{
	/**
	 * 商品分类列表
	 * @method GET
	 */
	public function list()
	{
		$condition            = [];
		$list                 = \App\Model\GoodsCategory::init()->getGoodsCategoryList( $condition, 'id,name,pid,icon,banner', 'sort asc', [1,1000] );
		$list                 = \App\Utils\Tree::listToTree( $list, 'id', 'pid', '_child', 0 );
		$this->send( Code::success, [
			'list' => $list,
		] );
	}
	/**
	 * 商品分类详情
	 * @method GET
	 * @param  int $id ID
	 */
	public function info()
	{
		if( $this->validator( $this->get, 'Server/GoodsCategory.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$info                 = \App\Model\GoodsCategory::init()->getGoodsCategoryInfo( ['id' => $this->get['id']], '*' );
			if( !$info ){
				$this->send( Code::param_error, [] );
			} else{
				$this->send( Code::success, ['info' => $info] );
			}
		}
	}


}

?>