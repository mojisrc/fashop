<?php
/**
 * 文章数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;

use ezswoole\Model;


class Article extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addArticle( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addArticleAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editArticle( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delArticle( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 获取文章单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array
	 */
	public function getArticleInfo( $condition = [], $field = '*' )
	{
		return $this->where( $condition )->field( $field )->find();
	}

	/**
	 * 获得文章列表
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getArticleList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		return $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
	}

}

?>