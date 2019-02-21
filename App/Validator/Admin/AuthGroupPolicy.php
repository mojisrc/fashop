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
class AuthGroupPolicy extends Validator
{

	protected $rule
		= [
			'policy_id' => 'require|policyExist',
			'group_id'  => 'require|groupExist',
		];

	protected $scene
		= [
			'list' => [
				'group_id',
			],
			'add'  => [
				'group_id',
				'policy_id',
			],
			'del'  => [
				'group_id',
				'policy_id',
			],
		];

	protected function policyExist( $value )
	{
		$scene = $this->getCurrentSceneName();
		// 删除不需要验证
		if( $scene == 'del' ){
			return true;
		} else{
			$find = \App\Model\AuthPolicy::init()->where( ['id' => $value] )->field( 'id' )->find();
			if( $find ){
				return true;
			} else{
				return '策略不存在';
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