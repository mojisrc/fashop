<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/22
 * Time: 下午1:30
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;
use App\Logic\VerifyCode;

class FindPassword extends Validate
{
	protected $rule
		= [
			'phone'        => 'require|checkPhoneExist',
			'email'        => 'require|checkEmailExist',
			'password'     => 'require|min:6|max:32',
			'behavior'     => 'require',
			'channel_type' => 'require|checkChannelType',
			'verify_code'  => 'require|length:4|number|checkVerifyCode',
		];
	protected $message
		= [
			'phone.require'      => "手机号必填",
			'email.require'      => "邮箱必填",
			'password.require'   => "密码必填",
			'password.min'       => "密码最小长度6位",
			'password.max'       => "密码最大长度32位",
			'verify_code.length' => "短信验证码格式不正确",
			'verify_code.number' => "短信验证码格式不正确",
		];
	protected $scene
		= [
			'phone' => [
				'phone',
				'password',
				'channel_type',
				'verify_code',
				'behavior',
			],
			'email' => [
				'email',
				'password',
				'channel_type',
				'verify_code',
				'behavior',
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
		if( !$this->is( $value, 'phone', $data ) && !$this->is( $value, 'email', $data ) ){
			return "账号不正确";
		}
		$condition['username|email|phone'] = $value;
		$find                              = \ezswoole\Db::name( 'User' )->where( $condition )->count();
		return $find ? true : "该账号不存在";
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkEmailExist( $value, $rule, $data )
	{
		if( !$this->is( $value, 'email', $data ) ){
			return "账号不正确";
		}
		$condition['email'] = $value;
		$find               = \ezswoole\Db::name( 'User' )->where( $condition )->count();
		return $find ? true : "该账号不存在";
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkPhoneExist( $value, $rule, $data )
	{
		if( !$this->is( $value, 'phone', $data ) ){
			return "账号不正确";
		}
		$condition['phone'] = $value;
		$find               = \ezswoole\Db::name( 'User' )->where( $condition )->count();
		return $find ? true : "该账号不存在";
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkVerifyCode( $value, $rule, $data )
	{
		if( !in_array( $data['channel_type'], VerifyCode::channelTypes ) ){
			return '验证码渠道不存在';
		}
		$condition['code']         = $value;
		$condition['channel_type'] = $data['channel_type'];
		$condition['behavior']     = 'findPassword';
		$condition['expire_time']  = ['egt', time()];
		$find                      = \ezswoole\Db::name( 'VerifyCode' )->where( $condition )->count();
		return $find ? true : "短信验证码已失效";
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
			return '验证码渠道不存在';
		}
	}
}