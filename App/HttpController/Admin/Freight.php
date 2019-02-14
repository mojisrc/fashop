<?php
/**
 *
 * 运费模板
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 运费模板
 * Class Freight
 * @package App\HttpController\Admin
 */
class Freight extends Admin
{
	/**
	 * 添加运费模板
	 * @method POST
	 * @param string $name     模板名称
	 * @param string $pay_type 计费方式
	 * @param array  $areas
	 */
	public function add()
	{
		if( $this->validator( $this->post, 'Admin/Freight.add' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$freight_id = \App\Model\Freight::init()->addFreight( [
				'name'     => $this->post['name'],
				'pay_type' => $this->post['pay_type'],
				'areas'    => $this->post['areas'],
			] );
			if( $freight_id > 0 ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 编辑运费模板
	 * @method POST
	 * @param int id $id
	 * @param string $name 模板名称
	 * @param string $areas
	 */
	public function edit()
	{
		if( $this->validator( $this->post, 'Admin/Freight.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\Freight::init()->editFreight( ['id' => $this->post['id']], [
				'name'  => $this->post['name'],
				'areas' => $this->post['areas'],
			] );
			$this->send( Code::success );
		}

	}

	/**
	 * 运费列表
	 * @method GET
	 */
	public function list()
	{
		$list = \App\Model\Freight::init()->getFreightList( [], 'id,name,pay_type,create_time,update_time,areas', 'id desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => \App\Model\Freight::count(),
		] );
	}

	/**
	 * 运费模板信息
	 * @method GET
	 */
	public function info()
	{
		$info = \App\Model\Freight::init()->getFreightInfo( ['id' => $this->get['id']] );
		$this->send( Code::success, ['info' => $info] );
	}

	/**
	 * 删除运费模板
	 * @method POST
	 * @param int id
	 */
	public function del()
	{
		if( $this->validator( $this->post, 'Admin/Freight.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\Freight::init()->delFreight( ['id' => $this->post['id']] );
			$this->send( Code::success );
		}
	}

}