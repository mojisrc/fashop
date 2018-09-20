<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/2
 * Time: 下午4:11
 *
 */

namespace App\Validate\Admin;

use ezswoole\Validate;
use App\Logic\User as UserLogic;
use ezswoole\Db;

class Member extends Validate
{
	protected $rule
		= [
			'id'          => 'require|checkId',
			'username'    => 'require|checkUsername',
			'avatar'      => 'require',
			'nickname'    => 'require',
			'phone'       => 'require',
			'email'       => 'require',
			'password'    => 'checkPassword',
			'oldpassword' => 'require|min:6|max:32|checkOldPassword',

		];

	protected $message
		= [];

	protected $code
		= [

		];
	protected $scene
		= [
			'add'          => ['username', 'password'],
			'edit'         => ['id'],
			'selfEdit'     => ['avatar', 'nickname'],
			'info'         => ['id'],
			'selfPassword' => ['id', 'oldpassword', 'password'],
			'del'          => ['id'],
		];

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkId( $value, $rule, $data )
	{
		$scene = $this->getCurrentSceneName();
		if( $scene == 'del' && $value == 1 ){
			return '管理员不可删除';
		} elseif( $scene == 'edit' && $value == 1 ){
			return '管理员信息仅可自己修改';
		}
		$condition['username'] = $value;
		$find                  = Db::name( 'User' )->where( $condition )->count();
		return $find ? "该账号已存在" : true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkUsername( $value, $rule, $data )
	{
		$condition['username|phone|email'] = $value;
		$find                              = Db::name( 'User' )->where( $condition )->count();
		return $find ? "该账号已存在" : true;
	}

	protected function checkPassword( $value, $rule, $data )
	{
		$scene = $this->getCurrentSceneName();
		// 修改用户资料password 不是必填
		if( ($scene == 'edit' && isset( $data['password'] )) || $scene == 'add' || $scene == 'selfPassword' ){
			if( Validate::min( $value, 6 ) !== true ){
				return '密码不得小于6位';
			}
			if( Validate::max( $value, 32 ) !== true ){
				return '密码不得大于32位';
			}
		}
		return true;
	}

	protected function checkOldPassword( $value, $rule, $data )
	{
		if( $value == $data['password'] ){
			return '新密码和老密码一样';
		}
		$condition['id']       = $data['id'];
		$condition['password'] = UserLogic::encryptPassword( $value );
		$find                  = Db::name( 'User' )->where( $condition )->count();
		return $find ? true : "老密码错误";
	}
}

?>