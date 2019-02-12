<?php
/**
 * 消息推送数据模型
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




class SystemTask extends Model
{
	protected $softDelete = true;
	protected $createTime = true;


	public function addSystemTask( $data = [] )
	{
		return $this->add( $data );
	}


	public function editSystemTask( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}

	public function delSystemTask( $condition = [] )
	{
		return $this->where( $condition )->del();
	}



	public function getSystemTaskInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}


	public function getSystemTaskList( $condition = [], $field = '*', $order = 'id desc', $page = [1,10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

}

?>