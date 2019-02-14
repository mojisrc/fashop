<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/1
 * Time: 下午2:00
 *
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use App\Logic\User as UserLogic;
use App\Logic\AccessToken;

/**
 * 成员
 * Class Member
 * @package App\HttpController\Admin
 */
class Member extends Admin
{
	/**
	 * 后台用户
	 * @method GET
	 * @param
	 */
	public function list()
	{
		$condition['is_member'] = ['eq', 1];
		$field                  = [
			'id',
			'username',
			'avatar',
			'nickname',
			'phone',
			'email',
			'sex',
		];
		$list                   = \App\Model\User::getUserList( $condition, $field, 'id desc', $this->getPageLimit() );
		return $this->send( Code::success, ['list' => $list] );
	}

	/**
	 * 添加成员
	 * @param string $username 登陆账号
	 * @param string $password 密码
	 * @param string $nickname 昵称  非必填
	 * @method POST
	 */
	public function add()
	{
		if( $this->validator( $this->post, 'Admin/Member.add' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$data = [
				'is_member' => 1,
				'username'  => $this->post['username'],
				'password'  => UserLogic::encryptPassword( $this->post['password'] ),
			];
			if( isset( $this->post['nickname'] ) ){
				$data['nickname'] = $this->post['nickname'];
			}
			\App\Model\User::addUser( $data );
			return $this->send();
		}
	}

	/**
	 * 修改
	 * @param int    $id       用户id
	 * @param string $avatar   头像 [非必填]
	 * @param string $nickname 昵称 [非必填]
	 * @param string $password 密码 [非必填]
	 * @method POST
	 */
	public function edit()
	{
		if( $this->validator( $this->post, 'Admin/Member.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$data = [];
			if( isset( $this->post['avatar'] ) ){
				$data['avatar'] = $this->post['avatar'];
			}
			if( isset( $this->post['nickname'] ) ){
				$data['nickname'] = $this->post['nickname'];
			}
			if( isset( $this->post['password'] ) ){
				$data['password'] = UserLogic::encryptPassword( $this->post['password'] );
			}
			\App\Model\User::editUser( ['id' => $this->post['id']], $data );
			$this->send();
		}
	}

	/**
	 * 获得详情
	 * @param int $id 用户id
	 * @method GET
	 */
	public function info()
	{
		if( $this->validator( $this->get, 'Admin/Member.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$field = [
				'id',
				'username',
				'avatar',
				'nickname',
				'name',
				'phone',
				'sex',
			];
			$info  = \App\Model\User::init()->getUserInfo( [
				'id' => $this->get['id'],
			], $field );
			$this->send( Code::success, ['info' => $info] );
		}
	}

	/**
	 * 登陆信息
	 * @method GET
	 */
	public function loginInfo()
	{
		$access_token_data = $this->getRequestAccessTokenData();
		$last_info         = \App\Model\AccessToken::getAccessTokenInfo( [
			'sub' => $access_token_data['sub'],
			'jti' => ['!=', $access_token_data['jti']],
		], '*', 'create_time desc' );

		$data['current_login_ip'] = $this->request->ip();
		if( !empty( $last_info ) ){
			$data['last_login_ip']   = $last_info['ip'];
			$data['last_login_time'] = $last_info['create_time'];
		} else{
			$data['last_login_ip']   = null;
			$data['last_login_time'] = null;
		}
		$this->send( Code::success, $data );
	}

	/**
	 * 删除后台用户
	 * @method POST
	 * @param int id
	 */
	public function del()
	{
		if( $this->validator( $this->post, 'Admin/Member.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\User::delUser( ['id' => $this->post['id']] );
			$this->send( Code::success );
		}
	}

	/**
	 * 修改自己的密码
	 * @param string $oldpassword 老密码
	 * @param string $password    密码
	 * @method POST
	 */
	public function selfPassword()
	{
		$user             = $this->getRequestUser();
		$this->post['id'] = $user['id'];
		if( $this->validator( $this->post, 'Admin/Member.selfPassword' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\User::editUser( ['id' => $user['id']], ['password' => UserLogic::encryptPassword( $this->post['password'] )] );
			$this->send( Code::success );
		}
	}

	/**
	 * 登陆
	 * @method     post
	 * @param string $username
	 * @param string $password
	 * @param string $verify_code
	 * @method POST
	 */
	public function login()
	{
		$loginLogic = new \App\Logic\Admin\Login();
		if( $this->validator( $this->post, 'Admin/Login.pcPassword' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$result = $loginLogic->pcPasswordLogin( $this->post['username'] );
			if( !empty( $result ) ){
				$this->send( Code::success, $result );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * @method POST
	 * @param string access_token 目前仅支持头部去携带
	 */
	public function token()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$accessTokenLogic     = new AccessToken();
			$start_time           = time();
			$refresh_access_token = $accessTokenLogic->refreshAccessToken( $this->getRequestAccessToken(), $start_time );
			if( !$refresh_access_token ){
				$this->send( Code::error );
			} else{
				$this->send( Code::success, $refresh_access_token );
			}
		}
	}

	/**
	 * 当前用户信息
	 * @method GET
	 */
	public function self()
	{
		$user  = $this->getRequestUser();
		$group = [];
		$rules = [];
		if( $user['id'] == 1 ){
			$rules = \App\Model\AuthRule::column( 'sign' );
		} else{
			$group_id = \ezswoole\Db::name( 'AuthGroupAccess' )->where( ['uid' => $user['id']] )->value( 'group_id' );
			if( $group_id > 0 ){
				$group = \App\Model\AuthGroup::getAuthGroupInfo( ['id' => $group_id] );
				$rules = \App\Model\AuthRule::init()->where( ['id' => ['in', $group['rule_ids']]] )->column( 'sign' );
			}
		}
		$rules = array_merge( $rules, \App\Logic\Admin\Auth::$noNeedAuthActionCheck );
		$this->send( Code::success, [
			'info'  => $this->getRequestUser(),
			'group' => $group,
			'rules' => $rules,
		] );
	}

	/**
	 * 修改当前用户的信息
	 * @param string $avatar   头像 [非必填]
	 * @param string $nickname 昵称 [非必填]
	 * @method POST
	 */
	public function selfEdit()
	{
		if( $this->validator( $this->post, 'Admin/Member.selfEdit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$user = $this->getRequestUser();
			$data = [];
			if( isset( $this->post['avatar'] ) ){
				$data['avatar'] = $this->post['avatar'];
			}
			if( isset( $this->post['nickname'] ) ){
				$data['nickname'] = $this->post['nickname'];
			}
			\App\Model\User::init()->editUser( ['id' => $user['id']], $data );
			$this->send();
		}
	}

	/**
	 * 退出
	 * @method   POST
	 */
	public function logout()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$jwt    = $this->getRequestAccessTokenData();
			$result = \App\Model\AccessToken::editAccessToken( [
				'jti' => $jwt['jti'],
			], [
				'is_logout'   => 1,
				'logout_time' => time(),
			] );

			if( $result ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 验证码
	 * @method GET
	 */
	public function verifyCode()
	{
//		$Conf = new Conf();
//		$Conf->setCharset( '123456ABCD' );
//		$Conf->setBackColor( '#FFFFFF' );
//		// 开启或关闭混淆曲线
//		$Conf->setUseCurve();
//		// 开启或关闭混淆噪点
//		$Conf->setUseNoise();
//
//		// 设置图片的宽度
//		$Conf->setImageWidth( 150 );
//		// 设置图片的高度
//		$Conf->setImageHeight( 50 );
//		// 设置生成字体大小
//		$Conf->setFontSize( 18 );
//		// 设置生成验证码位数
//		$Conf->setLength( 4 );
//
//		$VCode = new VerifyCode( $Conf );
//		// 随机生成验证码
//		$result = $VCode->drawCode();
//
//		session( 'verify_code', $result->getImageStr() );
//
//		$body = $result->getImageBody();
//
//		$this->response()->withHeader( 'Content-type', 'image/jpg' );
//
//		$this->response()->write( $body );
	}
}

