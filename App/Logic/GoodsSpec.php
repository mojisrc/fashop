<?php
/**
 * 规格管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

use ezswoole\Model;

class GoodsSpec extends Model
{
	/**
	 * @todo 等待废弃
	 * 获取规格列表(后)
	 * @method GET
	 */
	public function getGoodsSpecList( $get )
	{
		$model               = model( 'GoodsSpec' );
		$condition           = [];
		$condition['status'] = ['neq', - 1];
		$count               = \App\Model\Page::where( $condition )->count();
		$Page                = new Page( $count, isset( $get['rows'] ) ? $get['rows'] : 10 );
		$page                = $Page->currentPage.','.$Page->listRows;
		1;
		$list = \App\Model\Page::specList( $condition, '*', 'id desc', $page );
		$data = ['list' => $list, 'page' => $Page->show(), 'total' => $count];
		return $data;
	}

	/**
	 * 添加规格(后)
	 * @method POST
	 * @return      int 规格id
	 */
	public function addGoodsSpec( $post )
	{
		$model                  = model( 'GoodsSpec' );
		$post['category_title'] = $post['category_id'] ? model( 'GoodsCategory' )->where( ['id' => $post['category_id']] )->value( 'title' ) : '';
		$spec_id                = \App\Model\Page::addGoodsSpec( $post );
		//添加商品类型成功后，开始添加分类下的属性
		if( $spec_id && is_array( $post['attribute']['sort'] ) ){
			foreach( $post['attribute']['sort'] as $key => $value ){
				$attribute[$key]['sort']    = $post['attribute']['sort'][$key];
				$attribute[$key]['title']   = $post['attribute']['title'][$key];
				$attribute[$key]['spec_id'] = $spec_id;
			}
			//添加到规格的值表
			return \App\Model\GoodsSpecValue::addMultiGoodsSpecValue( $attribute );
		}
		return $spec_id;
	}

	/**
	 *  获取单个规格信息(后)
	 * @method GET
	 * @Author      沈旭
	 * @return      [一维数组]     [$data]
	 */
	public function getGoodsSpecInfo( $get )
	{
		$model = model( 'GoodsSpec' );
		$data  = \App\Model\Page::getSpecInfo( $get['id'] );
		return $data;
	}

	/**
	 * @method POST
	 * @return      [布尔]
	 */
	public function editGoodsSpec( $post )
	{
		$model  = model( 'GoodsSpec' );
		$result = \App\Model\Page::updateSpec( $post );
		return $result;
	}

	/**
	 *  删除规格
	 * @method POST
	 * @return
	 */
	public function delGoodsSpec( $post )
	{
		$model      = model( 'GoodsSpec' );
		$ids        = $post['ids'];
		$data['id'] = is_array( $ids ) ? ['in', implode( ',', $ids )] : $ids;
		$result     = \App\Model\Page::where( $data )->setField( 'status', - 1 );
		return $result;
	}
}