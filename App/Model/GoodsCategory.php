<?php
/**
 * 商品类别模型
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

class GoodsCategory extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-05-16 20:36:17
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addGoodsCategory( $data = [] )
	{
		$data['create_time'] = time();
		$result = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 添加多条
	 * @datetime 2017-05-16 20:36:17
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addGoodsCategoryAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-05-16 20:36:17
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editGoodsCategory( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-05-16 20:36:17
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delGoodsCategory( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 类别列表
	 *
	 * @param  array $condition 检索条件
	 * @return array   返回二位数组
	 */
	public function getGoodsCategoryList( $condition, $field = '*', $order = 'pid asc,sort asc,id asc', $page = '0,10' )
	{
		$list                = $this->field( $field )->where( $condition )->order( $order )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 取得店铺绑定的分类
	 *
	 * @param   number $pid   父级分类id
	 * @param   number $level 深度
	 * @return  array   二维数组
	 */
	public function getGoodsCategory( $pid = 0, $level = 1 )
	{
		return $this->getGoodsCategoryList( ['pid' => $pid], 'id, title, type_id' );
	}

	/**
	 * 类别详细
	 *
	 * @param   array $condition 条件
	 *                           $param   string  $field  字段
	 * @return  array   返回一维数组
	 */
	public function getGoodsCategoryInfo( $condition, $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获取分类详细信息
	 * @param  milit   $id    分类ID或标识
	 * @param  boolean $field 查询字段
	 * @return array     分类信息
	 */
	public function info( $id, $field = true )
	{
		/* 获取分类信息 */
		$map = [];
		if( is_numeric( $id ) ){
			//通过ID查询
			$map['id'] = $id;
		} else{
			//通过标识查询
			$map['name'] = $id;
		}
		return $this->field( $field )->where( $map )->find();
	}

	public function siblings( $id, $field = 'id,title', $order = 'sort asc,id desc' )
	{
		$pid = $this->where( ['id' => $id] )->value( 'pid' );
		return $this->where( ['pid' => $pid] )->field( $field )->order( $order )->select();
	}

	/**
	 * 获取指定分类子分类ID
	 * @param  string $category_id 分类ID
	 * @return string       id列表
	 */
	public function getChildrenId( $category_id )
	{
		$field = 'id,pid';
		$type  = $this->getTree( $category_id, $field );
		$ids   = [];
		foreach( $type['_'] as $key => $value ){
			$ids[] = $value['id'];
		}
		return implode( ',', $ids );
	}

	/**
	 * 获取分类树，指定分类则返回指定分类极其子分类，不指定则返回所有分类树
	 * @param  integer $id    分类ID
	 * @param  boolean $field 查询字段
	 * @return array          分类树
	 */
	public function getTree( $id = 0, $field = true )
	{
		/* 获取当前分类信息 */
		if( $id ){
			$info = $this->info( $id );
			$id   = $info['id'];
		}

		/* 获取所有分类 */
		$map  = ['status' => 1];
		$list = $this->field( $field )->where( $map )->order( 'sort' )->select();
		$list = \App\Utils\Tree::listToTree( $list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id );

		/* 获取返回数据 */
		if( isset( $info ) ){
			//指定分类则返回当前分类极其子分类
			$info['_'] = $list;
		} else{
			//否则返回所有分类
			$info = $list;
		}

		return $info;
	}

	/**
	 * 取单个分类的内容
	 *
	 * @param int $id 分类ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneGoodsCategory( $id )
	{
		if( intval( $id ) > 0 ){
			$result = $this->where( ['id' => $id] )->find();
			return $result;
		} else{
			return false;
		}
	}

	/**
	 * 取指定分类ID的所有父级分类
	 *
	 * @param int $id 父类ID/子类ID
	 * @return array $nav_link 返回数组形式类别导航连接
	 */
	public function getGoodsCategoryLineForTag( $id = 0 )
	{
		if( intval( $id ) > 0 ){
			$gc_line = [];
			/**
			 * 取当前类别信息
			 */
			$class = $this->getOneGoodsCategory( intval( $id ) );
			/**
			 * 是否是子类
			 */
			if( $class['pid'] != 0 ){
				$parent_1 = $this->getOneGoodsCategory( $class['pid'] );
				if( $parent_1['pid'] != 0 ){
					$parent_2                      = $this->getOneGoodsCategory( $parent_1['pid'] );
					$gc_line['id']                 = $parent_2['id'];
					$gc_line['type_id']            = $parent_2['type_id'];
					$gc_line['category_id_1']      = $parent_2['id'];
					$gc_line['category_tag_name']  = trim( $parent_2['title'] ).' >';
					$gc_line['category_tag_value'] = trim( $parent_2['title'] ).',';
				}
				$gc_line['id']      = $parent_1['id'];
				$gc_line['type_id'] = $parent_1['type_id'];
				if( !isset( $gc_line['category_id_1'] ) ){
					$gc_line['category_id_1'] = $parent_1['id'];
				} else{
					$gc_line['category_id_2'] = $parent_1['id'];
				}
				$gc_line['category_tag_name']  .= trim( $parent_1['title'] ).' >';
				$gc_line['category_tag_value'] .= trim( $parent_1['title'] ).',';
			}
			$gc_line['id']      = $class['id'];
			$gc_line['type_id'] = $class['type_id'];
			if( !isset( $gc_line['category_id_1'] ) ){
				$gc_line['category_id_1'] = $class['id'];
			} else if( !isset( $gc_line['category_id_2'] ) ){
				$gc_line['category_id_2'] = $class['id'];
			} else{
				$gc_line['category_id_3'] = $class['id'];
			}
			$gc_line['category_tag_name']  .= trim( $class['title'] ).' >';
			$gc_line['category_tag_value'] .= trim( $class['title'] ).',';
		}
		$gc_line['category_tag_name']  = trim( $gc_line['category_tag_name'], ' >' );
		$gc_line['category_tag_value'] = trim( $gc_line['category_tag_value'], ',' );
		return $gc_line;
	}

	/**
	 * 对应关系信息列表
	 * @param string $table 表名
	 * @param array  $map   一维数组
	 * @param string $id
	 * @param string $row   列名
	 * @return Array
	 */
	public function getGoodsTypeRelationList( $table, $map, $field = '*' )
	{
		$list_type = $this->table( $table )->where( $map )->field( $field )->order( $order )->select();
		return $list_type;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelGoodsCategory( $condition )
	{
		$find = $this->where( $condition )->find();		if($find){			return $find->delete();		}else{			return false;		}
	}
}

?>