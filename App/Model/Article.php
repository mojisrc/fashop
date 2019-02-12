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




class Article extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addArticle( array $data )
	{
		return $this->add( $data );
	}
	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
	 */
	public function editArticle( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delArticle( $condition = [] )
	{
		return $this->where( $condition )->del();
	}
	/**
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getArticleInfo( $condition = [], $field = '*' )
	{
		return $this->where( $condition )->field( $field )->find();
	}
	/**
	 * @param array  $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getArticleList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		return $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
	}

}

?>