<?php
/**
 * 相册数据模型
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

class Image extends Model
{
	protected $createTime = true;

	public function addImage( array $data )
	{
		return $this->add( $data );
	}


	public function delImage( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getImageList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>