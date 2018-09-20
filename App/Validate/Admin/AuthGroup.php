<?php

namespace App\Validate\Admin;

use ezswoole\Validate;
use ezswoole\Db;

/**
 * 权限节点验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class AuthGroup extends Validate
{

	protected $rule
		= [
			'id'         => 'require|checkId',
			'name'       => 'require|checkName',
			'rule_ids'   => 'require|array|arrayUnique',
			'member_ids' => 'require|array|arrayUnique',
		];

	protected $message
		= [
			'id.require'       => "组ID必填",
			'id.notIn'         => "默认分组不可操作",
			'title.require'    => "名称必填",
			'rule_ids.require' => '节点必填',
			'name.require'     => '组名必填',
		];
	protected $scene
		= [
			'add'             => [
				'name',
			],
			'edit'            => [
				'id',
				'name',
			],
			'del'             => [
				'id',
			],
			'groupMemberEdit' => [
				'member_ids',
				'id',
			],
			'groupAuthorise'  => [
				'id',
				'rule_ids',
			],
			'groupInfo'       => ['id'],
			'groupMemberList' => ['id'],
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
		switch( $scene ){
		case  'del' :
			if( $this->notIn( $value, 1 ) !== true ){
				return '管理组不可删除';
			}
		break;
		}
		return true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkName( $value, $rule, $data )
	{
		$scene = $this->getCurrentSceneName();
		$find  = Db::name( 'AuthGroup' )->where( ['name' => $value] )->find();
		switch( $scene ){
		case  'add' :
			if( $find ){
				return '组名不可重复';
			}
		break;
		case  'edit' :
			if( $find && isset( $find['name'] ) && $find['id'] != $data['id'] ){
				return '组名不可重复';
			}
		break;
		}
		return true;
	}
}