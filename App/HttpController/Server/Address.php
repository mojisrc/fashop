<?php
/**
 * 用户收货地址管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use App\Utils\Code;
use ezswoole\Db;

class Address extends Server
{
	/**
	 * 买家设置默认收货地址
	 * @method POST
	 * @param int $id 地址id
	 */
	public function setDefault()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user = $this->getRequestUser();
			\App\Model\Address::init()->editAddress( ['user_id' => $user['id']], ['is_default' => 0] );
			\App\Model\Address::init()->editAddress( ['user_id' => $user['id'], 'id' => $this->post['id'],], ['is_default' => 1] );
			$this->send( Code::success );
		}
	}

	/**
	 * 获得默认收货地址
	 * @method GET
	 */
	public function default()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user = $this->getRequestUser();
			$info = \App\Model\Address::init()->getDefaultAddressInfo( ['user_id' => $user['id']] );
			$this->send( Code::success, ['info' => $info] );
		}
	}

	/**
	 * 获取地址详情
	 * @method GET
	 * @param int $id 地址id
	 * @Author      韩文博
	 */
	public function info()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validator( $this->get, 'Server/Address.info' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidator()->getError() );
			} else{
				$user = $this->getRequestUser();
				$info = \App\Model\Address::init()->getAddressInfo( ['id' => $this->get['id'], 'user_id' => $user['id']] );
				$this->send( Code::success, ['info' => $info] );
			}
		}
	}

	/**
	 * 买家收货地址列表
	 * @method GET
	 */
	public function list()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$user = $this->getRequestUser();
			$list = \App\Model\Address::init()->getAddressList( ['user_id' => $user['id']], '*', 'is_default desc,id desc', $this->getPageLimit() );
			$this->send( Code::success, ['list' => $list] );
		}
	}

	/**
	 * 添加新的收货地址
	 * @method POST
	 * @param string $type         类型 个人 公司 其他
	 * @param string $truename     真实姓名 [必填]
	 * @param int    $area_id      地区id(县、区) [必填]
	 * @param string $address      具体地址 [必填]
	 * @param string $mobile_phone 手机号
	 */
	public function add()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validator( $this->post, 'Server/Address.add' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidator()->getError() );
			} else{
				try{
					$user       = $this->getRequestUser();
					$area       = Db::name( 'Area' )->where( ['id' => $this->post['area_id']] )->field( 'id,pid,name' )->find();
					$city       = Db::name( 'Area' )->where( ['id' => $area['pid']] )->field( 'id,pid,name' )->find();
					$province   = Db::name( 'Area' )->where( ['id' => $city['pid']] )->field( 'id,pid,name' )->find();
					$address_id = \App\Model\Address::init()->addAddress( [
						'user_id'        => $user['id'],
						'truename'       => $this->post['truename'],
						'province_id'    => $province['id'],
						'city_id'        => $city['id'],
						'area_id'        => $area['id'],
						'combine_detail' => "{$province['name']} {$city['name']} {$area['name']}",
						'address'        => $this->post['address'],
						'mobile_phone'   => $this->post['mobile_phone'],
						'type'           => $this->post['type'],
						'is_default'     => $this->post['is_default'],
					] );
					if( $address_id ){
						if( intval( $this->post['is_default'] ) === 1 ){
							\App\Model\Address::init()->editAddress( [
								'id'      => ['!=', $address_id],
								'user_id' => $user['id'],
							], ['is_default' => 0] );
						}
						$this->send( Code::success, ['id' => $address_id] );
					} else{
						$this->send( Code::error );
					}
				} catch( \Exception $e ){
					$this->send( Code::server_error, [], $e->getMessage() );
				}
			}
		}
	}

	/**
	 * 修改收货地址
	 * @method POST
	 * @param int id 地址id [必填]
	 * @param string $type         类型 0个人 1公司 2其他
	 * @param string $truename     真实姓名 [必填]
	 * @param int    $area_id      地区id(县、区) [必填]
	 * @param string $address      具体地址 [必填]
	 * @param string $mobile_phone 手机号
	 */
	public function edit()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validator( $this->post, 'Server/Address.edit' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidator()->getError() );
			} else{
				try{
					$user     = $this->getRequestUser();
					$area     = Db::name( 'Area' )->where( ['id' => $this->post['area_id']] )->field( 'id,pid,name' )->find();
					$city     = Db::name( 'Area' )->where( ['id' => $area['pid']] )->field( 'id,pid,name' )->find();
					$province = Db::name( 'Area' )->where( ['id' => $city['pid']] )->field( 'id,pid,name' )->find();
					$result   = \App\Model\Address::init()->editAddress( ['id' => $this->post['id']], [
						'user_id'        => $user['id'],
						'truename'       => $this->post['truename'],
						'province_id'    => $province['id'],
						'city_id'        => $city['id'],
						'area_id'        => $area['id'],
						'combine_detail' => "{$province['name']} {$city['name']} {$area['name']}",
						'address'        => $this->post['address'],
						'mobile_phone'   => $this->post['mobile_phone'],
						'type'           => $this->post['type'],
						'is_default'     => $this->post['is_default'],
					] );
					if( $result ){
						if( $this->post['is_default'] === 1 ){
							\App\Model\Address::init()->editAddress( [
								'id'      => ['!=', $this->post['id']],
								'user_id' => $user['id'],
							], ['is_default' => 0] );
						}
						$this->send( Code::success );
					} else{
						$this->send( Code::error );
					}
				} catch( \Exception $e ){
					$this->send( Code::server_error, [], $e->getMessage() );
				}
			}
		}
	}

	/**
	 * 买家删除收货地址
	 * @method POST
	 * @param  int id 地址id
	 */
	public function del()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validator( $this->post, 'Server/Address.del' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidator()->getError() );
			} else{
				$user = $this->getRequestUser();
				\App\Model\Address::init()->delAddress( ['id' => $this->post['id'], 'user_id' => $user['id']] );
				$this->send( Code::success, [] );
			}
		}
	}
}
