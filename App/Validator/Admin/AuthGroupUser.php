<?php

namespace App\Validator\Admin;

use ezswoole\Validator;

/**
 * 权限验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class AuthGroupUser extends Validator
{

	protected $rule
		= [
			'user_id'  => 'require|userExist',
			'group_id' => 'require|groupExist',
		];
	protected $scene
		= [
			'list' => [
				'group_id',
			],
			'add'  => [
				'group_id',
				'user_id',
			],
			'del'  => [
				'group_id',
				'user_id',
			],
		];

	protected function userExist( $value )
	{
		$scene = $this->getCurrentSceneName();
		// 删除不需要验证
		if( $scene == 'del' ){
			return true;
		} else{
			$find = \App\Model\User::init()->where( ['id' => $value] )->field( 'id' )->find();
			if( $find ){
				return true;
			} else{
				return '用户不存在';
			}
		}
	}

	protected function groupExist( $value )
	{
		$scene = $this->getCurrentSceneName();
		// 删除不需要验证
		if( $scene == 'del' ){
			return true;
		} else{
			$find = \App\Model\AuthGroup::init()->where( ['id' => $value] )->field( 'id' )->find();
			if( $find ){
				return true;
			} else{
				return '组不存在';
			}
		}
	}
}