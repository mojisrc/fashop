<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/28
 * Time: 下午4:14
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;
use App\Logic\VerifyCode;
use App\Utils\Code;

class OrderRefund extends Validate
{
	protected $rule
		= [
			'id'             => 'require',
			'refund_type'    => 'require|integer|in:1,2',
			'reason'         => 'require',
			'order_id'       => 'require|integer|gt:0',
			'order_goods_id' => 'require|integer|gt:0',
			'refund_amount'  => 'require|float|gt:0',
			'tracking_no'    => 'require',
			'tracking_phone' => 'require|checkPhone',
		];

	protected $message
		= [];
	protected $scene
		= [
			'apply'         => [
				'refund_type',
				'reason',
				'order_goods_id',
				'refund_amount',
			],
			'setTrackingNo' => [
				'id',
				'tracking_company',
				'tracking_no',
				'tracking_phone'
			],
			'revoke'=>[
				'id'
			]
		];


	protected function checkPhone( $value, $rule, $data )
	{
		if( !phone( $value) ){
			return Code::user_phone_format_error;
		}
		return true;
	}



}
