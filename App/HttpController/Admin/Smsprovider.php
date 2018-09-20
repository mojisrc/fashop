<?php
/**
 * 短信服务商方式
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
 * 短信服务商
 * Class SmsProvider
 * @package App\HttpController\Admin
 */
class Smsprovider extends Admin
{

	/**
	 * 短信服务商列表
	 * @author 韩文博
	 */
	public function list()
	{
		$model = model( 'SmsProvider' );
		$list  = $model->getSmsProviderList( [], '*', null, '1,1000' );
		return $this->send( Code::success, [
			'list' => $list,
		] );
	}

	/**
	 * 短信服务商设置
	 * @param string $type aliyun 阿里云
	 * @param array  $config
	 * @param int    $status
	 * @author 韩文博
	 */
	public function edit()
	{
		if( isset( $this->post['status'] ) ){
			if( $this->validate( $this->post, 'Admin/SmsProvider.status' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				model( 'SmsProvider' )->editSmsProvider( ['type' => $this->post['type']], [
					'status' => $this->post['status'] ? 1 : 0,
				] );
				$this->send( Code::success );
			}
		} else{
			if( $this->validate( $this->post, 'Admin/SmsProvider.edit' ) ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );
			} else{
				model( 'SmsProvider' )->editSmsProvider( ['type' => $this->post['type']], [
					'config' => $this->post['config'],
				] );
				$this->send( Code::success );
			}
		}
	}

	/**
	 * 详情
	 * @param string $type aliyun 阿里云
	 * @author 韩文博
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Admin/SmsProvider.info' ) !== true ){
			$this->send( Code::param_error, $this->getValidate()->getError() );
		} else{
			$info = model( 'SmsProvider' )->getSmsProviderInfo( ['type' => $this->get['type']] );
			$this->send( Code::success, ['info' => $info] );
		}
	}

}

?>