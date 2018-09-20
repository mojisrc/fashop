<?php
/**
 * 文章数据模型
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

class Article extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addArticle( $data = [] )
	{
		$data['create_time'] = time();
		$result              = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
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
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delArticle( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-04-20 18:07:52
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getArticleCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取文章单条数据
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array
	 */
	public function getArticleInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得文章列表
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getArticleList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelArticle( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}


	/**
	 * 获取id
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getArticleId( $condition )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getArticleValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getArticleColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}
}

?>