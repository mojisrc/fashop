<?php
/**
 * 权限业务逻辑处理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Biz\Admin;

use hanwenbo\policy\Policy;
use \hanwenbo\policy\RequestBean\Policy as PolicyBean;
class Auth
{
	/**
	 * @var Policy
	 */
	protected $policy;
	/**
	 * @var int
	 */
	protected $user_id;
	/**
	 * @var string
	 */
	protected $actionName;
	/**
	 * @var array
	 */
	protected $user_policy_list = [];

	/**
	 * 不需要验证的节点
	 */
	static $notAuthAction
		= [
			'user/login',
			'user/logout',
			'member/login',
			'member/logout',
			'member/refreshToken',
			'upload/addImage',
		];
	public function __construct()
	{
		$this->policy = new Policy;
	}

	public function verify(){
		// 不需要验证的模块
		return $this->policy->verify($this->actionName);
	}

	/**
	 * 设置该组的权限列表
	 * @return array
	 */
	public function setUserPolicyList() : void {
		// 获得用户所属的组
		$groupIds = \App\Model\AuthGroupUser::init()->where(['user_id'=>$this->user_id])->column('group_id');
		if($groupIds){
			// 获得组的所有策略id集合
			$policyIds = \App\Model\AuthGroupPolicy::init()->where(['group_id'=>['in',$groupIds]])->column('policy_id');
			if($policyIds){
				// 获得所有策略信息，并且仍给本类的policy实例
				$policy_list =  \App\Model\AuthPolicy::init()->getAuthPolicyList(['id'=>['in',$policyIds],'*','id desc',[1,10000]]);
				$this->user_policy_list = $policy_list ?? [];
				// 给策略库添加规则信息
				if(!empty($this->group_policy_list)){
					foreach($this->group_policy_list as $policy){
						$policyBean = new PolicyBean($policy['structure']);
						$this->policy->addPolicy($policyBean);
					}
				}
			}
		}
	}

	/**
	 * @param int $user_id
	 */
	public function setUserId( int $user_id ) : void
	{
		$this->user_id = $user_id;
	}

	/**
	 * @param string $actionName
	 */
	public function setActionName( string $actionName ) : void
	{
		$this->actionName = $actionName;
	}
}
?>
