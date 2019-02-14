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
	 * @param int $tree 1是否转成树形结构
	 */
	public function list()
	{
		$condition = [];
		$order     = 'sort asc';
		$list      = \App\Model\GoodsCategory::init()->getGoodsCategoryList( $condition, '*', $order, [1, 1000] );
		return $this->send( Code::success, [
			'list' => isset( $this->get['tree'] ) ? \App\Utils\Tree::listToTree( $list, 'id', 'pid', '_child', 0 ) : $list,
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
		if( $this->validator( $this->post, 'Admin/GoodsCategory.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$pid                  = $this->post['pid'];
			$prefix               = \EasySwoole\EasySwoole\Config::getInstance()->getConf( 'MYSQL.prefix' );
			$table_goods_category = $prefix."goods_category";
			$grandpa_info         = \App\Model\GoodsCategory::init()->rawQuery( "SELECT pid FROM $table_goods_category WHERE id=(SELECT pid FROM $table_goods_category WHERE id=$pid AND delete_time IS NULL) AND delete_time IS NULL" );
			if( $grandpa_info && $grandpa_info[0]['pid'] > 0 ){
				$this->send( Code::error, [], '至多三级分类' );
			} else{
				$result = \App\Model\GoodsCategory::init()->addGoodsCategory( (array)$this->post );
				if( $result ){
					$this->send( Code::success );
				} else{
					$this->send( Code::error );
				}
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
		if( $this->validator( $this->post, 'Admin/GoodsCategory.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$data = ['name' => $this->post['name']];
			if( isset( $this->post['pid'] ) && $this->post['id'] !== $this->post['pid'] ){
				$data['pid'] = $this->post['pid'];
			}
			if( isset( $this->post['icon'] ) ){
				$data['icon'] = $this->post['icon'];
			}
			$id                   = $this->post['id'];
			$prefix               = \EasySwoole\EasySwoole\Config::getInstance()->getConf( 'MYSQL.prefix' );
			$table_goods_category = $prefix."goods_category";
			$grandpa_info         = \App\Model\GoodsCategory::init()->rawQuery( "SELECT pid FROM $table_goods_category WHERE id=(SELECT pid FROM $table_goods_category WHERE id=(SELECT pid FROM $table_goods_category WHERE id=$id AND delete_time IS NULL) AND delete_time IS NULL) AND delete_time IS NULL" );
			if( $grandpa_info && $grandpa_info[0]['pid'] > 0 ){
				return $this->send( Code::error, [], '至多三级分类' );
			}
			\App\Model\GoodsCategory::init()->editGoodsCategory( ['id' => $this->post['id']], $data );
			$this->send( Code::success );
		}
	}

	/**
	 * 商品分类详情
	 * @method GET
	 * @param  int $id ID
	 */
	public function info()
	{
		if( $this->validator( $this->get, 'Admin/GoodsCategory.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$info = \App\Model\GoodsCategory::init()->getGoodsCategoryInfo( ['id' => $this->get['id']], '*' );
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
		if( $this->validator( $this->post, 'Admin/GoodsCategory.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{

			$condition       = [];
			$condition['id'] = $this->post['id'];
			$row             = \App\Model\GoodsCategory::init()->getGoodsCategoryInfo( $condition, '*' );
			if( !$row ){
				return $this->send( Code::param_error, [] );
			} else{
				$sub_info = \App\Model\GoodsCategory::init()->getGoodsCategoryInfo( ['pid' => $row['id']], '*' );
				if( $sub_info ){
					return $this->send( Code::param_error, [], '存在子级分类，不可删除' );
				}
				$result = \App\Model\GoodsCategory::init()->delGoodsCategory( $condition );
				if( !$result ){
					return $this->send( Code::error );
				} else{
					return $this->send( Code::success );

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
		if( $this->validator( $this->post, 'Admin/GoodsCategory.sort' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$is_display_order = $this->post['sorts'];
			$sql              = "UPDATE ".\EasySwoole\EasySwoole\Config::getInstance()->getConf( 'MYSQL.prefix' )."goods_category SET sort = CASE id ";
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