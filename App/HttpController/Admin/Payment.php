<?php
/**
 * 支付方式
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
 * 支付方式
 * Class Payment
 * @package App\HttpController\Admin
 */
class Payment extends Admin
{

	/**
	 * 支付方式
	 * @author 韩文博
	 */
	public function list()
	{
		$payment_model = model( 'Payment' );
		$payment_list  = $payment_model->getPaymentList( [], '*', null, '1,1000' );
		return $this->send( Code::success, [
			'list' => $payment_list,
		] );
	}

	/**
	 * 支付设置
	 * @param string $type wechat 微信
	 * @param array  $config
	 * @param int    $status
	 * @author 韩文博
	 */
	public function edit()
	{
		if( $this->validate( $this->post, 'Admin/Payment.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$data = [];
			if( isset( $this->post['config'] ) ){
				$data['config'] = $this->post['config'];
			}
			if( isset( $this->post['status'] ) ){
				$data['status'] = $this->post['status'] ? 1 : 0;
			}

			model( 'Payment' )->editPayment( ['type' => $this->post['type']], $data );
			$this->send( Code::success );
		}
	}

	/**
	 * 详情
	 * @param string $type wechat 微信支付
	 * @author 韩文博
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Admin/Payment.info' ) !== true ){
			$this->send( Code::error, [], $this->getValidate()->getError() );
		} else{
			$info = model( 'Payment' )->getPaymentInfo( ['type' => $this->get['type']] );
			$this->send( Code::success, ['info' => $info] );
		}
	}

}

?>