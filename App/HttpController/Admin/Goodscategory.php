<?php

namespace App\HttpController\Admin;

use App\Utils\Code;
use ezswoole\Db;

/**
 * 商品分类
 * Class Goodscategory
 * @package App\HttpController\Admin
 */
class Goodscategory extends Admin
{
	/**
	 * 商品分类列表
	 * @method GET
	 * @author 孙泉
	 */
	public function list()
	{
		$db_prefix            = config( 'database.prefix' );
		$table_goods_common   = $db_prefix.'goods';
		$table_goods_category = $db_prefix.'goods_category';
		$goods_category_model = model( 'GoodsCategory' );

		$condition = [];
		$field = "*,(SELECT count(*) FROM $table_goods_common WHERE category_ids LIKE CONCAT('%\"',$table_goods_category.id,'\"%')) as goods_number";
		$order = 'sort asc';
		$list  = $goods_category_model->getGoodsCategoryList( $condition, $field, $order, '1,1000' );
		$list  = \App\Utils\Tree::listToTree( $list, 'id', 'pid', '_child', 0 );
		return $this->send( Code::success, [
			'list' => $list,
		] );
	}

	/**
	 * 添加商品分类
	 * @method POST
	 * @param  string $name 名称
	 * @param  int    $pid  父级ID
	 * @param  string $icon 商品分类图标，图片地址
	 * @param  int    $sort 排序值
	 */
	public function add()
	{
		if( $this->validate( $this->post, 'Admin/GoodsCategory.add' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = model( 'GoodsCategory' )->addGoodsCategory( $this->post );
			if( $result ){
				return $this->send( Code::success );
			} else{
				return $this->send( Code::error );
			}
		}
	}

	/**
	 * 修改商品分类
	 * @method POST
	 * @param  int    $id   ID
	 * @param  string $name 名称
	 * @param  int    $pid  父级ID
	 * @param  string $icon 商品分类图标，图片地址
	 */
	public function edit()
	{
		if( $this->validate( $this->post, 'Admin/GoodsCategory.edit' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$data = [
				'name' => $this->post['name'],
			];
			if( isset( $data['pid'] ) && $this->post['id'] !== $data['pid'] ){
				$data['pid'] = $this->post['pid'];
			}
			if( isset( $data['icon'] ) ){
				$data['icon'] = $this->post['icon'];
			}
			$model = model( 'GoodsCategory' );
			// 只允许二级
			$childs = $model->getGoodsCategoryList( ['pid' => $this->post['id']], 'id' );
			if( count( $childs ) > 0 && $this->post['pid'] ){
				return $this->send( Code::error, [], '当前分类存在子分类，不可从属其他分类' );
			}
			model( 'GoodsCategory' )->editGoodsCategory( ['id' => $this->post['id']], $data );
			return $this->send( Code::success );
		}
	}

	/**
	 * 商品分类详情
	 * @method GET
	 * @param  int $id ID
	 * @author 韩文博
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Admin/GoodsCategory.info' ) !== true ){
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

	/**
	 * 删除商品分类
	 * @method POST
	 * @param  int $id ID
	 * @author 孙泉
	 */
	public function del()
	{
		if( $this->validate( $this->post, 'Admin/GoodsCategory.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{

			$condition       = [];
			$condition['id'] = $this->post['id'];

			$goods_category_model = model( 'GoodsCategory' );
			$row                  = $goods_category_model->getGoodsCategoryInfo( $condition, '*' );
			if( !$row ){
				$this->send( Code::param_error, [] );
			} else{
				$result = $goods_category_model->softDelGoodsCategory( $condition );
				if( !$result ){
					$this->send( Code::error );
				} else{
					$this->send( Code::success );

				}
			}
		}
	}

	/**
	 * 分类排序
	 * @method POST
	 * @param array $sorts [{id:d,index:d}]
	 * @author   韩文博
	 */
	public function sort()
	{
		if( $this->validate( $this->post, 'Admin/GoodsCategory.sort' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$is_display_order = $this->post['sorts'];
			$sql              = "UPDATE ".config( 'database.prefix' )."goods_category SET sort = CASE id ";
			$ids              = [];
			foreach( $is_display_order as $sort ){
				$ids[] = $sort['id'];
				$sql   .= sprintf( "WHEN %d THEN %d ", $sort['id'], $sort['index'] ); // 拼接SQL语句
			}
			$ids_string = implode( ',', $ids );
			$sql        .= "END WHERE id IN ($ids_string)";
			Db::query( $sql );
			return $this->send();
		}
	}

}

?>