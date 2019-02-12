<?php
/**
 * 上传数据模型
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


class Upload extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	public function addUpload( $data = [] )
	{
		return $this->add( $data );
	}

	public function editUpload( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}


	public function delUpload( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getUploadInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}


	public function getUploadList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>