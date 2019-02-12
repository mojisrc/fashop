<?php
/**
 * 短信服务商方式
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
 * 短信服务商
 * Class SmsProvider
 * @package App\HttpController\Admin
 */
class Smsprovider extends Admin
{

	/**
	 * 短信服务商列表
	 */
	public function list()
	{
		$list  = \App\Model\SmsProvider::getSmsProviderList( [], '*', null, [1,1000] );
		return $this->send( Code::success, [
			'list' => $list,
		] );
	}

	/**
	 * 短信服务商设置
	 * @param string $type aliyun 阿里云
	 * @param array  $config
	 * @param int    $status
	 */
	public function edit()
	{
		if( isset( $this->post['status'] ) ){
			if( $this->validator( $this->post, 'Admin/SmsProvider.status' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidator()->getError() );
			} else{
				\App\Model\SmsProvider::editSmsProvider( ['type' => $this->post['type']], [
					'status' => $this->post['status'] ? 1 : 0,
				] );
				$this->send( Code::success );
			}
		} else{
			if( $this->validator( $this->post, 'Admin/SmsProvider.edit' ) ){
				$this->send( Code::param_error, [], $this->getValidator()->getError() );
			} else{
				\App\Model\SmsProvider::editSmsProvider( ['type' => $this->post['type']], [
					'config' => $this->post['config'],
				] );
				$this->send( Code::success );
			}
		}
	}

	/**
	 * 详情
	 * @param string $type aliyun 阿里云
	 */
	public function info()
	{
		if( $this->validator( $this->get, 'Admin/SmsProvider.info' ) !== true ){
			$this->send( Code::param_error, $this->getValidator()->getError() );
		} else{
			$info = \App\Model\SmsProvider::getSmsProviderInfo( ['type' => $this->get['type']] );
			$this->send( Code::success, ['info' => $info] );
		}
	}

}

?>