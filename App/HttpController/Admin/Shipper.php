<?php
/**
 *
 * 商家地址库管理
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
		$list = \App\Model\Shipper::getShipperList( [], 'id,name,province_id,city_id,area_id,combine_detail,address,contact_number,is_default', 'is_default desc ,id desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => \App\Model\Shipper::count(),

		] );
	}

	/**
	 * 物流地址信息
	 * @method GET
	 */
	public function info()
	{
		$info = \App\Model\Shipper::getShipperInfo( ['id' => $this->get['id']] );
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
		if( $this->validator( $this->post, 'Admin/Shipper.add' ) !== true ){
			return $this->send( Code::error, [], $this->getValidator()->getError() );
		} else{
			try{
				$area       = Db::name( 'Area' )->where( ['id' => $this->post['area_id']] )->field( 'id,pid,name' )->find();
				$city       = Db::name( 'Area' )->where( ['id' => $area['pid']] )->field( 'id,pid,name' )->find();
				$province   = Db::name( 'Area' )->where( ['id' => $city['pid']] )->field( 'id,pid,name' )->find();
				$address_id = \App\Model\Shipper::addShipper( [
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
		if( $this->validator( $this->post, 'Admin/Shipper.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			try{
				$condition['id'] = $this->post['id'];
				$area            = Db::name( 'Area' )->where( ['id' => $this->post['area_id']] )->field( 'id,pid,name' )->find();
				$city            = Db::name( 'Area' )->where( ['id' => $area['pid']] )->field( 'id,pid,name' )->find();
				$province        = Db::name( 'Area' )->where( ['id' => $city['pid']] )->field( 'id,pid,name' )->find();
				\App\Model\Shipper::editShipper( $condition, [
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
		if( $this->validator( $this->post, 'Admin/Shipper.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$condition       = [];
			$condition['id'] = $this->post['id'];
			$row             = \App\Model\Shipper::getShipperInfo( $condition, '*' );
			if( !$row ){
				$this->send( Code::param_error, [], '没有该记录' );
			} elseif( $row['is_system'] == 1 ){
				$this->send( Code::param_error, [], '系统数据，不可删除' );
			} else{
				\App\Model\Shipper::delShipper( $condition );
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
		if( $this->validator( $this->post, 'Admin/Shipper.setDefault' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$condition       = [];
			$condition['id'] = $this->post['id'];
			\App\Model\Shipper::editShipper( [
				'id' => [
					'!=',
					$this->post['id'],
				],
			], ['is_default' => 0] );
			\App\Model\Shipper::editShipper( [
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
		if( $this->validator( $this->post, 'Admin/Shipper.setRefundDefault' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$condition       = [];
			$condition['id'] = $this->post['id'];
			\App\Model\Shipper::editShipper( [
				'id' => [
					'!=',
					$this->post['id'],
				],
			], ['refund_default' => 0] );
			\App\Model\Shipper::editShipper( [
				'id' => $this->post['id'],
			], ['refund_default' => 1] );
			$this->send( Code::success );
		}
	}
}