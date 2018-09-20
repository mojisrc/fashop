<?php
/**
 * 支付业务逻辑
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

use ezswoole\Model;
use EasySwoole\Core\Component\Di;
use app\common\extend\Coupon\Coupon;
use EasyWeChat\Foundation\Application;

class Payment extends Model
{
	/**
	 * 获得预存款支付的订单和支付信息
	 * @method     GET
	 * @datetime 2017-05-29T22:25:00+0800
	 * @author   韩文博
	 * @param    string $pay_sn       充值单号
	 * @param    string $payment_code 支付方式
	 * @param    int    $user_id      用户id
	 * @return   array
	 */
	public function getPredepositPaymentInfo( $pay_sn, $payment_code, $user_id )
	{
		$pd_model               = model( 'PdRecharge' );
		$pay_info               = $pd_model->getPdRechargeInfo( ['sn' => $pay_sn, 'user_id' => $user_id] );
		$pay_info['subject']    = '预存款充值_'.$pay_info['sn'];
		$pay_info['order_type'] = 'predeposit';
		$pay_info['pay_sn']     = $pay_info['sn'];
		$pay_info['pay_amount'] = $pay_info['amount'];
		if( empty( $pay_info ) || $pay_info['payment_state'] == 1 ){
			throw new \Exception(lang( 'cart_order_pay_not_exists' ) );
		}
		return $pay_info;
	}




}
