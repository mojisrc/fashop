<?php
/**
 * 模板模型
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

/**
 * Class Page
 * @package App\Model
 */
class Page extends Model
{
	protected $softDelete = true;
	protected $createTime = true;
	protected $jsonFields = ['body'];

	public function addPage( array $data )
	{
		return $this->add( $data );
	}

	public function editPage( $condition = [], $data = [] )
	{
		$data['update_time'] = time();
		return $this->where( $condition )->edit( $data );
	}

	public function getPageInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	public function getPageList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}