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

namespace App\Validate\Admin;

use ezswoole\Validate;
use ezswoole\Db;
use App\Logic\User as UserLogic;
use App\Logic\VerifyCode;

class Login extends Validate
{
	protected $rule
		= [
			'username'    => 'require|checkUsername',
			'password'    => 'require|min:6|max:32|checkPassword',
			'phone'       => 'require|checkPhone',
			'verify_code' => 'require|checkVerifyCode',
		];
	protected $message
		= [
			'username.require' => "用户名必填",
			'password.require' => "密码必填",
			'password.min'     => "密码最小长度6位",
			'password.max'     => "密码最大长度32位",
		];
	protected $scene
		= [
			'pcPassword' => [
				'username',
				'password',
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
		$condition['username']  = $value;
		$condition['state']     = 1;
		$find                   = Db::name( 'User' )->where( $condition )->count();
		return $find ? true : "该账号不存在或已被禁止";
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
			return "手机格式不正确";
		}
		$condition['phone'] = $value;
		$find               = Db::name( 'User' )->where( $condition )->count();
		return $find ? true : "手机号不存在";
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkPassword( $value, $rule, $data )
	{
		$condition['username'] = $data['username'];
		$condition['password'] = UserLogic::encryptPassword( $value );
		$find                  = Db::name( 'User' )->where( $condition )->count();
		return $find ? true : "账号或密码错误";
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkVerifyCode( $value, $rule, $data )
	{
		$verify_code = session( 'verify_code' );
		if( $verify_code !== $value ){
			return '验证码不正确';
		} else{
			return true;
		}
	}

}