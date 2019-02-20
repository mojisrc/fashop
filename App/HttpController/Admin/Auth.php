<?php

namespace App\HttpController\Admin;

use App\Model\AuthGroupPolicy;
use App\Utils\Code;

class Auth extends Admin
{
	public function policyList()
	{
		$policyModel = new \App\Model\AuthPolicy;
		$list        = $policyModel->withTotalCount()->getAuthPolicyList( [], '*', 'id desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => $policyModel->getTotalCount(),
		] );
	}

	/**
	 * @param int $id
	 */
	public function policyInfo()
	{
		if( $this->validator( $this->get, 'Admin/AuthPolicy.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$policyModel = new \App\Model\AuthPolicy;
			$info        = $policyModel->getAuthPolicyInfo( ['id' => $this->get['id']] );
			$this->send( Code::success, [
				'info' => $info,
			] );
		}
	}

	/**
	 * 策略添加
	 * @param string $name
	 * @param array  $structure
	 */
	public function policyAdd()
	{
		if( $this->validator( $this->post, 'Admin/AuthPolicy.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\AuthPolicy::init()->addAuthPolicy( [
				'name'      => $this->post['name'],
				'structure' => $this->post['structure'],
			] );
			$this->send( Code::success );
		}
	}

	/**
	 * 策略添加
	 * @param int    $id
	 * @param string $name
	 * @param array  $structure
	 */
	public function policyEdit()
	{
		if( $this->validator( $this->post, 'Admin/AuthPolicy.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\AuthPolicy::init()->editAuthPolicy( [
				'id' => $this->post['id'],
			], [
				'name'      => $this->post['name'],
				'structure' => $this->post['structure'],
			] );
			$this->send( Code::success );
		}
	}

	/**
	 * 策略删除
	 * @param int $id
	 */
	public function policyDel()
	{
		if( $this->validator( $this->post, 'Admin/AuthPolicy.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\AuthPolicy::init()->delAuthPolicy( [
				'id' => $this->post['id'],
			] );
			$this->send( Code::success );
		}
	}

	public function groupList()
	{
		$groupModel = new \App\Model\AuthGroup;
		$list       = $groupModel->withTotalCount()->getAuthGroupList( [], '*', 'id desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => $groupModel->getTotalCount(),
		] );
	}

	/**
	 * @param int $id
	 */
	public function groupInfo()
	{
		if( $this->validator( $this->get, 'Admin/AuthGroup.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$groupModel = new \App\Model\AuthGroup;
			$info       = $groupModel->getAuthGroupInfo( ['id' => $this->get['id']] );
			$this->send( Code::success, [
				'info' => $info,
			] );
		}
	}

	/**
	 * 组添加
	 * @param string $name
	 * @param int    $status
	 */
	public function groupAdd()
	{
		if( $this->validator( $this->post, 'Admin/AuthGroup.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\AuthPolicy::init()->addAuthPolicy( [
				'name'   => $this->post['name'],
				'status' => $this->post['status'] ? 1 : 0,
			] );
			$this->send( Code::success );
		}
	}

	/**
	 * 组修改
	 * @param int    $id
	 * @param string $name
	 * @param int    $status
	 */
	public function groupEdit()
	{
		if( $this->validator( $this->post, 'Admin/AuthGroup.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\AuthGroup::init()->editAuthGroup( [
				'id' => $this->post['id'],
			], [
				'name'   => $this->post['name'],
				'status' => $this->post['status'] ? 1 : 0,
			] );
			$this->send( Code::success );
		}
	}

	/**
	 * 组删除
	 * @param int $id
	 */
	public function groupDel()
	{
		if( $this->validator( $this->post, 'Admin/AuthGroup.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\AuthPolicy::init()->delAuthGroup( [
				'id' => $this->post['id'],
			] );
			$this->send( Code::success );
		}
	}

	/**
	 * @param int $group_id
	 */
	public function groupPolicyList()
	{
		if( $this->validator( $this->get, 'Admin/AuthGroup.id' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$groupPolicyModel = new  \App\Model\AuthGroupPolicy;
			$list             = $groupPolicyModel->withTotalCount()->join( 'auth_policy', 'auth_policy.id = auth_group_policy.policy_id' )->where( [
				'auth_group_policy.group_id' => $this->get['group_id'],
			] )->page( $this->getPageLimit() )->select();
			$list             = $list ?? [];
			if( count( $list ) > 0 ){
				foreach( $list as $key => $item ){
					$list[$key]['structure'] = json_decode( $item['structure'], true );
				}
			}
			$this->send( Code::success, [
				'list'         => $list,
				'total_number' => $groupPolicyModel->getTotalCount(),
			] );

		}
	}

	/**
	 * 组策略添加
	 * @param int $policy_id
	 * @param int $group_id
	 */
	public function groupPolicyAdd()
	{
		if( $this->validator( $this->post, 'Admin/AuthGroupPolicy.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$authGroupPolicyModel = new \App\Model\AuthGroupPolicy;

			$data = [
				'policy_id' => $this->post['policy_id'],
				'group_id'  => $this->post['group_id'],

			];

			$find = $authGroupPolicyModel->where( $data )->find();

			if( !$find ){
				\App\Model\AuthGroupPolicy::init()->addAuthGroupPolicy();
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}

		}
	}

	/**
	 * 组策略删除
	 * @param int $policy_id
	 * @param int $group_id
	 */
	public function groupPolicyDel()
	{
		if( $this->validator( $this->post, 'Admin/AuthGroupPolicy.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$authGroupPolicyModel = new \App\Model\AuthGroupPolicy;

			$condition = [
				'policy_id' => $this->post['policy_id'],
				'group_id'  => $this->post['group_id'],
			];

			$authGroupPolicyModel->where( $condition )->delete();

			$this->send( Code::success );
		}
	}

	// todo 组详情接口
	// policy 详情文档  ，所有详情的文档    ，明天尽量把权限部分完成

	public function memberList()
	{

	}

	/**
	 * 成员添加
	 * @param int $user_id
	 * @param int $group_id
	 */
	public function memberAdd()
	{

	}

	/**
	 * 成员删除
	 * @param int $user_id
	 * @param int $group_id
	 */
	public function memberDel()
	{

	}
}