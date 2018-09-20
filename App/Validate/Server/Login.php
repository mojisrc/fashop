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
use ezswoole\Db;
use App\Logic\User as UserLogic;
use App\Utils\Code;

class Login extends Validate
{
	// tofo 验证登录时带wechat_qr_sign时的sign的有效状态，是否过期
	protected $rule
		= [
			'username'         => 'require|checkUsername',
			'password'         => 'require|min:6|max:32|checkPassword',
			'phone'            => 'require|checkPhone',
			'verify_code'      => 'require|number|length:4|checkVerifyCode',
			'wechat_openid'    => 'require|checkWechatOpenid',
			'wechat_mini_code' => 'require',
		];
	protected $message
		= [
			'username.require'   => Code::user_username_require,
			'password.require'   => Code::user_password_require,
			'password.min'       => Code::user_password_short,
			'password.max'       => Code::user_password_long,
			'verify_code.length' => Code::verify_code_length,
			'verify_code.number' => Code::verify_code_number,
		];
	protected $scene
		= [
			'password'     => [
				'username',
				'password',
			],
			'wechatOpenid' => [
				'wechat_openid',
			],
			'wechatMini'   => [
				'wechat_mini_code',
			],
		];

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkUsername( $value, $rule, $data )
	{
		if( is_numeric( $value ) ){
			if( !$this->is( $value, 'phone', $data ) ){
				return Code::user_username_or_email_error;
			}

			$condition['phone'] = $value;

		} else{
			$condition['username'] = $value;
		}

		$find = Db::name( 'User' )->where( $condition )->count();
		return $find ? true : Code::user_account_not_exist;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkPhone( $value, $rule, $data )
	{
		if( !$this->is( $value, 'phone', $data ) ){
			return Code::user_phone_format_error;
		}
		$condition['phone'] = $value;
		$find               = Db::name( 'User' )->where( $condition )->count();
		return $find ? true : Code::user_account_not_exist;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkPassword( $value, $rule, $data )
	{
		if( is_numeric( $data['username'] ) ){
			$condition['phone'] = $data['username'];
		} else{
			$condition['username'] = $data['username'];
		}

		$condition['password'] = UserLogic::encryptPassword( $value );
		$find                  = Db::name( 'User' )->where( $condition )->count();
		return $find ? true : Code::user_username_or_password_error;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkVerifyCode( $value, $rule, $data )
	{
		$condition['code']         = $value;
		$condition['channel_type'] = 'sms';
		$condition['receiver']     = $data['phone'];
		$condition['behavior']     = 'login';
		$condition['expire_time']  = ['egt', time()];
		$find                      = Db::name( 'VerifyCode' )->where( $condition )->count();
		return $find ? true : Code::verify_code_expire;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkWechatOpenid( $value, $rule, $data )
	{
		$condition['wenchat_openid'] = $value;
		$wechat_openid               = Db::name( 'User' )->where( $condition )->value( 'wechat_openid' );
		if( !$wechat_openid ){
			return Code::user_wechat_openid_not_exist;
		} else{
			return true;
		}
	}


}