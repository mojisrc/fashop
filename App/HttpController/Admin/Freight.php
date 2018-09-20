<?php
/**
 *
 * 运费模板
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
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
	 * @author 韩文博
	 */
	public function add()
	{
		if( $this->validate( $this->post, 'Admin/Freight.add' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$model      = model( 'Freight' );
			$freight_id = $model->addFreight( [
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
	 * @author 韩文博
	 */
	public function edit()
	{
		if( $this->validate( $this->post, 'Admin/Freight.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Freight' )->editFreight( ['id' => $this->post['id']], [
				'name'  => $this->post['name'],
				'areas' => $this->post['areas'],
			] );
			$this->send( Code::success );
		}

	}

	/**
	 * 运费列表
	 * @method GET
	 * @author 韩文博
	 */
	public function list()
	{
		$freight_model = model( 'Freight' );
		$list          = $freight_model->getFreightList( [], 'id,name,pay_type,create_time,update_time,areas', 'id desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => $freight_model->count(),
		] );
	}

	/**
	 * 运费模板信息
	 * @method GET
	 * @author 韩文博
	 */
	public function info()
	{
		$model = model( 'Freight' );
		$info  = $model->getFreightInfo( ['id' => $this->get['id']] );
		$this->send( Code::success, ['info' => $info] );
	}

	/**
	 * 删除运费模板
	 * @method POST
	 * @param int id
	 * @author 韩文博
	 */
	public function del()
	{
		if( $this->validate( $this->post, 'Admin/Freight.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Freight' )->softDelFreight( ['id' => $this->post['id']] );
			$this->send( Code::success );
		}
	}

}