<?php
/**
 * 短信场景数据模型
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



class SmsScene extends Model
{
	protected $createTime = true;

	public function addSmsScene( array $data )
	{
		return $this->add( $data );
	}

	public function editSmsScene( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}

	public function delSmsScene( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getSmsSceneInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}


	public function getSmsSceneList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>