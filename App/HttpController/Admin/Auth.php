<?php

namespace App\HttpController\Admin;

use App\Utils\Code;

class Auth extends Admin
{
	/**
	 * 权限模块列表
	 */
	public function moduleList(){
		$this->send(Code::success,[
			'list'=>[
				['name'=>'订单模块','value'=>'order'],
				['name'=>'商品模块','value'=>'goods'],
				['name'=>'退款模块','value'=>'refund'],
			]
		]);
	}
	/**
	 * 权限节点列表
	 * @param string $module 模块 ，如：order,goods
	 */
	public function actionList(){
		$this->send(Code::success,[
			'list'=>[
				['name'=>'列表','value'=>'order/list'],
				['name'=>'详情','value'=>'order/info'],
				['name'=>'发货','value'=>'order/send'],
			]
		]);
	}
	/**
	 * 策略列表
	 * @throws \EasySwoole\Mysqli\Exceptions\Option
	 */
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
	 * 策略详情
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
			$policyModel = new \App\Model\AuthPolicy;
			$policyModel->startTrace();
			try{
				// 删除策略
				$policyModel->delAuthPolicy( [
					'id' => $this->post['id'],
				] );
				// 删除组策略
				\App\Model\AuthGroupPolicy::init()->delAuthGroupPolicy( [
					'policy_id' => $this->post['id'],
				] );
				$policyModel->commit();
				$this->send( Code::success );
			} catch( \Exception $e ){
				$policyModel->rollback();
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 组列表
	 * @throws \EasySwoole\Mysqli\Exceptions\Option
	 */
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
	 * 组详情
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
			\App\Model\AuthGroup::init()->addAuthGroup( [
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
			$groupModel = new \App\Model\AuthGroup;
			$groupModel->startTrace();
			try{
				// 删除组
				$groupModel->delAuthGroup( [
					'id' => $this->post['id'],
				] );
				// 删除组相关的用户
				\App\Model\AuthGroupUser::init()->delAuthGroupUser( [
					'group_id' => $this->post['id'],
				] );
				// 删除组所的策略
				\App\Model\AuthGroupPolicy::init()->delAuthGroupPolicy( [
					'group_id' => $this->post['id'],
				] );
				$groupModel->commit();
				$this->send( Code::success );
			} catch( \Exception $e ){
				$groupModel->rollback();
				$this->send( Code::server_error, [], $e->getMessage() );
			}

		}
	}

	/**
	 * 组策略列表
	 * @param int $group_id
	 */
	public function groupPolicyList()
	{
		if( $this->validator( $this->get, 'Admin/AuthGroupPolicy.list' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$groupPolicyModel = new  \App\Model\AuthGroupPolicy;
			$list             = $groupPolicyModel->withTotalCount()->join( 'auth_policy', 'auth_policy.id = auth_group_policy.policy_id' ,'LEFT')->where( [
				'auth_group_policy.group_id' => $this->get['group_id'],
			] )->filed(['auth_policy.id','auth_policy.name'])->page( $this->getPageLimit() )->select();
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
				$authGroupPolicyModel->addAuthGroupPolicy($data);
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

	/**
	 * 用户列表
	 * 用于搜索用户
	 * @param string $keywords
	 * @throws \EasySwoole\Mysqli\Exceptions\JoinFail
	 * @throws \EasySwoole\Mysqli\Exceptions\Option
	 */
	public function userList(){
		$userModel = new \App\Model\User();
		if(isset($this->get['keywords'])){
			$userModel->where("(username like %{$this->get['keywords']}% OR phone like %{$this->get['keywords']}%)");
		}
		$list        = $userModel->withTotalCount()->join('user','user.id = auth_group_user.user_id','LEFT')->getUserList( [], '*', 'id desc', $this->getPageLimit() );

		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => $userModel->getTotalCount(),
		] );
	}
	/**
	 * 组成员列表
	 * @param int $group_id 可选
	 * @throws \EasySwoole\Mysqli\Exceptions\JoinFail
	 * @throws \EasySwoole\Mysqli\Exceptions\Option
	 */
	public function groupMemberList()
	{
		$groupUserModel = new \App\Model\AuthGroupUser();
		if(isset($this->get['group_id'])){
			$condition['auth_group_user.group_id'] = $this->get['group_id'];
		}else{
			$condition = [];
		}
		$list        = $groupUserModel->withTotalCount()->join('user','user.id = auth_group_user.user_id','LEFT')->getAuthGroupUserList( $condition, '*', 'id desc', $this->getPageLimit() );

		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => $groupUserModel->getTotalCount(),
		] );
	}

	/**
	 * 成员添加
	 * @param int $user_id
	 * @param int $group_id
	 */
	public function groupMemberAdd()
	{
		if( $this->validator( $this->post, 'Admin/AuthGroupUser.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$authGroupUserModel = new \App\Model\AuthGroupUser;

			$data = [
				'policy_id' => $this->post['policy_id'],
				'group_id'  => $this->post['group_id'],
			];

			$find = $authGroupUserModel->where( $data )->find();

			if( !$find ){
				$authGroupUserModel->addAuthGroupUser($data);
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 成员删除
	 * @param int $user_id
	 * @param int $group_id
	 */
	public function groupMemberDel()
	{
		if( $this->validator( $this->post, 'Admin/AuthGroupUser.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$authGroupUserModel = new \App\Model\AuthGroupPolicy;

			$condition = [
				'user_id' => $this->post['user_id'],
				'group_id'  => $this->post['group_id'],
			];

			$authGroupUserModel->where( $condition )->delete();

			$this->send( Code::success );
		}
	}
}