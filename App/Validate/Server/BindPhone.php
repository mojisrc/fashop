<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;
use App\Logic\VerifyCode;
use App\Utils\Code;
use ezswoole\Db;

class BindPhone extends Validate
{
	protected $rule
		= [
			'id'            => 'require',
			'phone'         => 'require|phone|checkPhone',
			'password'      => 'require|min:6|max:32',
			'verify_code'   => 'require|length:4|number|checkVerifyCode',
		];
	protected $message
		= [
			'password.require' => "密码必填",
			'password.min'     => "密码最小长度6位",
			'password.max'     => "密码最大长度32位",
			'verify_code.length'   => "短信验证码格式不正确",
			'verify_code.number'   => "短信验证码格式不正确",
		];

	protected $code
		= [
			'password.min' => Code::user_password_short,
		];
	protected $scene
		= [
			'bindPhone'          => [
				'id',
				'phone',
				'password',
				'verify_code',
			],
		];

	protected function checkPhone( $value, $rule, $data )
	{
		if( !$this->is( $value, 'phone', $data ) ){
			return Code::user_phone_format_error;
		}

		$condition['phone'] = $value;
        $condition['id']    = $data['id'];
        $find               = Db::name( 'User' )->where( $condition )->count();

		return $find ? Code::user_account_exist : true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkVerifyCode( $value, $rule, $data )
	{
		$scene_name = $this->getCurrentSceneName();

		if( $scene_name == 'bindPhone' ){
			$condition['code']         = $value;
			$condition['channel_type'] = 'sms';
			$condition['behavior']     = 'bindPhone';
		} else{
			return '没有该验证方法';
		}
		$condition['expire_time'] = ['egt', time()];
		$find                     = \ezswoole\Db::name( 'VerifyCode' )->where( $condition )->count();
		return $find ? true : "短信验证码已失效";

	}

}