<?php
/**
 * 权限组角色数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Model;

class AuthGroupPolicy extends Model
{
	public function addAuthGroupPolicys( int $group_id, array $policy_ids )
	{
		// 先删除所有
		$this->where( ['group_id' => $group_id] )->delete();
		$data = [];
		foreach( $policy_ids as $policy_id ){
			$data[] = [
				'group_id'  => $group_id,
				'policy_id' => $policy_id,
			];
		}
		return $this->addMulti( $data );
	}

}

?>
