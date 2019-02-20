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
namespace App\Biz;

use hanwenbo\policy;

class Auth
{



	private $tokenInfo;
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

	public function getAuthGroupPolicyList(){

	}
}
?>
