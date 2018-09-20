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
use App\Logic\VerifyCode;

class User extends Validate
{
	protected $rule
		= [
			'id'    => 'require',
			'name'  => 'require',
			'phone' => 'require|checkPhone',
			'sex'   => 'require',
			'ids'   => 'require|checkUserIds',


		];
	protected $message
		= [
			'id.require'    => "用户id必须",
			'name.require'  => "姓名必须",
			'phone.require' => "手机号必须",
			'sex.require'   => "性别必须",
			'ids.require'   => "用户id数组必须",
		];


	protected $scene
		= [
			'add' => [
				'name',
				'phone',
				'sex',
			],

			'edit' => [
				'id',
			],

			'info' => [
				'id',
			],

			'del' => [
				'ids',
			],
		];

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
		return $find ? "手机号已存在" : true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkUserIds( $value, $rule, $data )
	{
		if( isset( $value ) && is_array( $value ) ){
			$result = true;
		} else{
			$result = '参数错误';

		}
		return $result;
	}


}