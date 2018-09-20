<?php
/**
 *
 * 商家地址库管理
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
use ezswoole\Db;

/**
 * 物流地址
 * Class Shipper
 * @package App\HttpController\Admin
 */
class Shipper extends Admin
{

	/**
	 * 物流地址列表
	 * @method GET
	 * @param string
	 */
	public function list()
	{
		$shipper_model = model( 'Shipper' );
		$list = $shipper_model->getShipperList( [], 'id,name,province_id,city_id,area_id,combine_detail,address,contact_number,is_default', 'is_default desc ,id desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => $shipper_model->count(),

		] );
	}

	/**
	 * 物流地址信息
	 * @method GET
	 * @author 韩文博
	 */
	public function info()
	{
		$page_model = model( 'Shipper' );
		$info       = $page_model->getShipperInfo( ['id' => $this->get['id']] );
		$this->send( Code::success, ['info' => $info] );
	}

	/**
	 * 新增物流地址
	 * @method POST
	 * @param string name 发货人
	 * @param int district_id 区县ID
	 * @param string address 详细地址
	 * @param string contact_number  联系电话
	 */
	public function add()
	{
		if( $this->validate( $this->post, 'Admin/Shipper.add' ) !== true ){
			return $this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			try{
				$db         = Db::name( 'Area' );
				$area       = $db->where( ['id' => $this->post['area_id']] )->field( 'id,pid,name' )->find();
				$city       = $db->where( ['id' => $area['pid']] )->field( 'id,pid,name' )->find();
				$province   = $db->where( ['id' => $city['pid']] )->field( 'id,pid,name' )->find();
				$address_id = model( 'Shipper' )->addShipper( [
					'name'           => $this->post['name'],
					'province_id'    => $province['id'],
					'city_id'        => $city['id'],
					'area_id'        => $area['id'],
					'combine_detail' => "{$province['name']} {$city['name']} {$area['name']}",
					'address'        => $this->post['address'],
					'contact_number' => $this->post['contact_number'],
				] );
				if( $address_id ){
					$this->send( Code::success );
				} else{
					$this->send( Code::error );
				}
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}

	}

	/**
	 * 修改物流地址
	 * @method POST
	 * @param int id id
	 * @param string name 发货人
	 * @param int district_id 区县ID
	 * @param string address 详细地址
	 * @param string contact_number  联系电话
	 */
	public function edit()
	{
		if( $this->validate( $this->post, 'Admin/Shipper.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			try{
				$condition['id'] = $this->post['id'];
				$db              = Db::name( 'Area' );
				$area            = $db->where( ['id' => $this->post['area_id']] )->field( 'id,pid,name' )->find();
				$city            = $db->where( ['id' => $area['pid']] )->field( 'id,pid,name' )->find();
				$province        = $db->where( ['id' => $city['pid']] )->field( 'id,pid,name' )->find();
				model( 'Shipper' )->editShipper( $condition, [
					'name'           => $this->post['name'],
					'province_id'    => $province['id'],
					'city_id'        => $city['id'],
					'area_id'        => $area['id'],
					'combine_detail' => "{$province['name']} {$city['name']} {$area['name']}",
					'address'        => $this->post['address'],
					'contact_number' => $this->post['contact_number'],
				] );
				$this->send( Code::success );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 删除物流地址
	 * @method POST
	 * @param int id shipper表ID
	 */
	public function del()
	{
		if( $this->validate( $this->post, 'Admin/Shipper.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$condition       = [];
			$condition['id'] = $this->post['id'];
			$shipper_model   = model( 'Shipper' );
			$row             = $shipper_model->getShipperInfo( $condition, '*' );
			if( !$row ){
				$this->send( Code::param_error, [], '没有该记录' );
			} elseif( $row['is_system'] == 1 ){
				$this->send( Code::param_error, [], '系统数据，不可删除' );
			} else{
				$shipper_model->softDelShipper( $condition );
				$this->send( Code::success );
			}
		}
	}

	/**
	 * 设置默认地址
	 * @method POST
	 * @param int id shipper表ID 不是default的ID
	 */
	public function setDefault()
	{
		if( $this->validate( $this->post, 'Admin/Shipper.setDefault' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$condition       = [];
			$condition['id'] = $this->post['id'];
			$shipper_model   = model( 'Shipper' );
			$shipper_model->editShipper( [
				'id' => [
					'neq',
					$this->post['id'],
				],
			], ['is_default' => 0] );
			$shipper_model->editShipper( [
				'id' => $this->post['id'],
			], ['is_default' => 1] );
			$this->send( Code::success );
		}
	}

	/**
	 * 设置默认退货地址
	 * @method POST
	 * @param int id shipper表ID 不是default的ID
	 */
	public function setRefundDefault()
	{
		if( $this->validate( $this->post, 'Admin/Shipper.setRefundDefault' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$condition       = [];
			$condition['id'] = $this->post['id'];
			$shipper_model   = model( 'Shipper' );
			$shipper_model->editShipper( [
				'id' => [
					'neq',
					$this->post['id'],
				],
			], ['refund_default' => 0] );
			$shipper_model->editShipper( [
				'id' => $this->post['id'],
			], ['refund_default' => 1] );
			$this->send( Code::success );
		}
	}
}