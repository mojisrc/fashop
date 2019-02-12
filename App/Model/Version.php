<?php
/**
 * 版本控制数据模型
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

class Version extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	public function addVersion( $data = [] )
	{
		return $this->add( $data );
	}

	public function editVersion( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	public function delVersion( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getVersionCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	public function getVersionInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	public function getVersionList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>