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

class Register extends Validate
{
	protected $rule
		= [
			'username'      => 'require|checkUsername',
			'password'      => 'require|min:6|max:32',
			'behavior'      => 'require',
			'channel_type'  => 'require|checkChannelType',
			'verify_code'   => 'require|length:4|number|checkVerifyCode',
			'wechat_openid' => 'require',
			'wechat_mini_param'   => 'require|checkWechatMiniParam',

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
				'channel_type',
				'verify_code',
			],
			'wechatOpenid' => [
				'wechat_openid',
			],
			'wechatMini' => [
				'wechat_mini_param'
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
		if( !$this->is( $value, 'phone', $data ) ){
			return Code::user_username_or_email_error;
		}
		$condition['username|email|phone'] = $value;
		$find                              = \ezswoole\Db::name( 'User' )->where( $condition )->count();
		return $find ? Code::user_account_exist : true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 * @throws \Exception
	 */
	protected function checkVerifyCode( $value, $rule, $data )
	{
		if( !in_array( $data['channel_type'], VerifyCode::channelTypes ) ){
			return Code::verify_code_check_channel_type_error;
		}
		$condition['code']         = $value;
		$condition['channel_type'] = $data['channel_type'];
		$condition['receiver']     = $data['username'];
		$condition['behavior']     = 'register';
		$find                      = Db::name( 'VerifyCode' )->where( $condition )->order( 'create_time desc' )->find();
		if( !$find ){
			return Code::verify_code_not_exist;
		} elseif( $find['expire_time'] < time() ){
			return Code::verify_code_expire;
		} else{
			return true;
		}
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkChannelType( $value, $rule, $data )
	{
		if( in_array( $value, VerifyCode::channelTypes ) ){
			return true;
		} else{
			return Code::verify_code_check_channel_type_error;
		}
	}

	/**
	 * @access protected
	 * 数组必须包含code，encryptedData，iv
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkWechatMiniParam( $value, $rule, $data )
	{
		if( !isset( $value['code'] ) || !isset( $value['encryptedData'] ) || !isset( $value['iv'] ) ){
			return Code::wechat_mini_param_error;
		} else{
			return true;
		}
	}

}