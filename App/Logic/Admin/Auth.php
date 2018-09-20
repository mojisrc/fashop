<?php
/**
 * 权限业务逻辑处理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Logic\Admin;

use ezswoole\Db;
use ezswoole\Request;

class Auth
{
	// 无障碍权限 需要全小写
	static $notAuthAction
		= [
			'member/login',
			'member/verifycode',
			'auth/genrule',
		];
	// 不需要验证的 需要全小写
	static $noNeedAuthActionCheck
		= [
			'member/rulenoneedcheck',
			'member/token',
			'member/logout',
			'member/self',
			'member/selfpassword',
			'member/loginInfo',
			'shop/info',
			'auth/ruleTree',
		];
	private $userId;

	/**
	 * @return mixed
	 */
	public function getUserId() : int
	{
		return $this->userId;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId( $userId ) : void
	{
		$this->userId = $userId;
	}

	/**
	 * 检查权限
	 * @param        $node         string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
	 * @param        $user_id      int           认证用户的id
	 * @param int    $type         认证类型
	 * @param string $mode         执行check的模式
	 * @param string $relation     如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
	 * @return bool  通过验证返回true;失败返回false
	 */
	public function checkUserNodeAuth( string $node, string $type = 'admin', string $mode = 'url', string $relation = 'and' ) : bool
	{
		$user_id = $this->getUserId();
		if( $user_id === null ){
			return false;
		}
		if( $user_id == 1 ){
			return true;
		}
		try{
			// 无需验证节点
			if( in_array( $node, self::$notAuthAction ) || in_array( $node, self::$noNeedAuthActionCheck ) ){
				return true;
			}
			// 获取用户需要验证的所有有效规则列表
			$authList = $this->getAuthList( $user_id, $type );

			if( is_string( $node ) ){
				$name = strtolower( $node );
				if( strpos( $name, ',' ) !== false ){
					$node = explode( ',', $node );
				} else{
					$node = [$node];
				}
			}
			$list = []; //保存验证通过的规则名
			if( 'url' == $mode ){
				$REQUEST = unserialize( strtolower( serialize( Request::getInstance()->param() ) ) );
			}
			foreach( $authList as $auth ){
				$query = preg_replace( '/^.+\?/U', '', $auth );
				if( 'url' == $mode && $query != $auth ){
					parse_str( $query, $param ); //解析规则中的param
					$intersect = array_intersect_assoc( $REQUEST, $param );
					$auth      = preg_replace( '/\?.*$/U', '', $auth );
					if( in_array( $auth, $node ) && $intersect === $param ){
						//如果节点相符且url参数满足
						$list[] = $auth;
					}
				} else{
					if( in_array( $auth, $node ) ){
						$list[] = $auth;
					}
				}
			}
			if( 'or' == $relation && !empty( $list ) ){
				return true;
			}
			$diff = array_diff( $node, $list );
			if( 'and' == $relation && empty( $diff ) ){
				return true;
			}
			return false;
		} catch( \Exception $e ){
			return false;
		}
	}

	/**
	 * 根据用户id获取用户组,返回值为数组
	 * @param int $uid 用户id
	 * @return array
	 */
	public function getGroups( int $uid ) : array
	{
		$user_groups = Db::name( 'AuthGroupAccess' )->alias( 'AuthGroupAccess' )->join( '__AUTH_GROUP__ AuthGroup', 'AuthGroupAccess.group_id=AuthGroup.id', 'LEFT' )->where( "AuthGroupAccess.uid={$uid} AND AuthGroup.status=1" )->select();
		return $user_groups;
	}

	/**
	 * 获得权限列表
	 * @param integer $uid 用户id
	 * @param string  $type
	 * @return array
	 */
	public function getAuthList( int $uid, string $type ) : array
	{
		//读取用户所属用户组
		$groups = $this->getGroups( $uid );
		if( !empty( $groups ) ){
			$ruleIds = [];
			foreach( $groups as $group ){
				$group['rule_ids'] = json_decode( $group['rule_ids'], true );
				if( !empty( $group['rule_ids'] ) ){
					$ruleIds = array_merge( $ruleIds, $group['rule_ids'] );
				}
			}
			if( !empty( $ruleIds ) ){
				$ruleIds  = array_unique( $ruleIds );
				$map      = [
					'id'   => ['in', $ruleIds],
					'type' => $type,
				];
				$rules    = Db::name( 'AuthRule' )->where( $map )->field( 'condition,sign' )->select();
				$authList = [];
				foreach( $rules as $rule ){
					$authList[] = strtolower( $rule['sign'] );
				}
				return array_unique( $authList );
			} else{
				return [];
			}
		} else{
			return [];
		}

	}
}

?>
