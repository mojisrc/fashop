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
namespace App\Logic;

use Firebase\JWT\JWT;
use EasySwoole\Config;
use ezswoole\Db;
use ezswoole\Request;

class Auth
{

	public $error = 0;

	public $errorMsg = '';

	public function getError()
	{
		return $this->send;
	}

	public function getErrorMsg()
	{
		return $this->sendMsg;
	}

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

	/**
	 * 自动验证Token权限
	 *
	 */
	public function autoCheckTokenAuth( string $token_string = null )
	{
		if( $token_string == null ){
			$token_string = $this->getRequestTokenString();
		}
		if( $token_string == '' || !$token_string ){
			return false;
		}
		$token_info = $this->getJWTokenInfo( $token_string );
		if( $token_info == false ){
			return false;
		}
		return $this->checkUserNodeAuth( Request::getInstance()->controller()."/".Request::getInstance()->action(), $token_info->user_id );
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
	public function checkUserNodeAuth( string $node, int $user_id = null, $type = 'admin', $mode = 'url', $relation = 'and' )
	{
		if( $user_id == null ){
			return false;
		}
		// todo 超级管理员变量
		if( $user_id == 1 ){
			return true;
		}
		try{
			// 无需验证节点
			if( in_array( $node, $this->notAuthAction ) ){
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
					if( in_array( $auth, $node ) && $intersect == $param ){
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
	 * 获得请求时带的字符串token
	 * todo 根据参数获得 其他渠道 目前只有header
	 * @return string
	 */
	public function getRequestTokenString()
	{
		$header = Request::getInstance()->header();
		if( isset( $header['authorization'] ) && $token = str_replace( "Bearer ", "", $header['authorization'] ) ){
			return $token;
		} else{
			$this->send    = - 1;
			$this->sendMsg = 'authorization miss';
			return '';
		}
	}

	/**
	 * 创建token
	 * @method     GET
	 * @datetime 2017-10-16T22:46:22+0800
	 * @author   韩文博
	 * @param    int    $user_id
	 * @param    string $access_token
	 * @return   string
	 */
	public function createJWToken( int $user_id, string $access_token )
	{
		$token_data = [
			// Subject (The user ID)
			'sub'          => $user_id,
			'user_id'      => $user_id,
			// Issued At
			'iat'          => time(),
			// Expires At
			'exp'          => time() + Config::getInstance()->getConf( 'jwt.expiration_intervals' ),
			'domain'       => Request::getInstance()->domain(),
			// Valid for 2 hours
			// The list of OAuth scopes this token includes
			//			'scope'        => $scope,
			// 用户的随机身份，每次改密码修改重要信息会重新生成
			'access_token' => $access_token,
		];
		return JWT::encode( $token_data, Config::getInstance()->getConf( 'jwt.key' ), Config::getInstance()->getConf( 'jwt.alg' ) );
	}

	/**
	 * 获得tokenInfo
	 * @datetime 2017-10-16T21:26:38+0800
	 * @author   韩文博
	 * @param    string $token_string
	 * @return array
	 * todo 让整个操作更简便一些，如果错了就返回错误类似validate->check()
	 */
	public function getJWTokenInfo( string $token_string )
	{
		try{
			$token_info      = JWT::decode( $token_string, Config::getInstance()->getConf( 'jwt.key' ), [Config::getInstance()->getConf( 'jwt.alg' )] );
			$this->tokenInfo = $token_info;
			$this->send     = 0;
			$this->sendMsg  = '';
		} catch( \Firebase\JWT\ExpiredException $e ){
			$token_info     = false;
			$this->send    = 0;
			$this->sendMsg = 'The token has expired';
		} catch( \Firebase\JWT\SignatureInvalidException $e ){
			$token_info     = false;
			$this->errpr    = 0;
			$this->sendMsg = 'The token provided was malformed';
		} catch( \Exception $e ){
			$token_info     = false;
			$this->send    = 0;
			$this->sendMsg = $e->getMessage();
		}
		if( is_array( $token_info ) && $token_info['domain'] == Request::getInstance()->domain() ){
			return [];
		} else{
			return $token_info;
		}
	}

	public function getTokenInfo()
	{
		return $this->tokenInfo;
	}

	/**
	 * 根据用户id获取用户组,返回值为数组
	 * @param  $uid int     用户id
	 * @return array       用户所属的用户组 array(
	 *              array('uid'=>'用户id','group_id'=>'用户组id','title'=>'用户组名称','rule_ids'=>'用户组拥有的规则id,多个,号隔开'),
	 *              ...)
	 */
	public function getGroups( $uid )
	{
		// 转换表名
		$auth_group_access = \ezswoole\Loader::parseName( 'auth_group_access', 1 );
		$auth_group        = \ezswoole\Loader::parseName( 'auth_group', 1 );
		// 执行查询
		$user_groups = Db::view( $auth_group_access, 'uid,group_id' )->view( $auth_group, 'title,rule_ids', "{$auth_group_access}.group_id={$auth_group}.id", 'LEFT' )->where( "{$auth_group_access}.uid='{$uid}' and {$auth_group}.status='1'" )->select();
		return $user_groups;
	}

	/**
	 * 获得权限列表
	 * @param integer $uid 用户id
	 * @param integer $type
	 * @return array
	 */
	public function getAuthList( $uid, $type )
	{
		//读取用户所属用户组
		$groups = $this->getGroups( $uid );
		$ids    = []; //保存用户所属用户组设置的所有权限规则id
		foreach( $groups as $g ){
			$ids = array_merge( $ids, $g['rule_ids'] );
		}
		$ids = array_unique( $ids );
		if( empty( $ids ) ){
			return [];
		}
		$map = [
			'id'   => ['in', $ids],
			'type' => $type,
		];
		//读取用户组所有权限规则
		$rule_ids = Db::name( 'auth_rule' )->where( $map )->field( 'condition,name' )->select();
		//循环规则，判断结果。
		$authList = []; //
		foreach( $rule_ids as $rule ){
			if( !empty( $rule['condition'] ) ){
				//根据condition进行验证
				$user    = Db::name( 'use' )->where( ['id' => $uid] )->find();
				$command = preg_replace( '/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition'] );
				@(eval( '$condition=('.$command.');' ));
				if( $condition ){
					$authList[] = strtolower( $rule['name'] );
				}
			} else{
				//只要存在就记录
				$authList[] = strtolower( $rule['name'] );
			}
		}
		return array_unique( $authList );
	}
}

?>
