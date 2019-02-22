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
use App\Biz\User as UserBiz;
use App\Biz\AccessToken;

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
		$field      = [
			'user.id',
			'user.username',
			'user.phone',
			'user.email',
			'user_admin.name',
			'user_admin.avatar',
			'user_admin.status',
			'user_admin.create_time',
		];
		$adminModel = new  \App\Model\UserAdmin;
		$list       = $adminModel->withTotalCount()->join( 'user', 'user.id = user_admin.user_id', 'LEFT' )->getUserAdminList( [], $field, 'id desc', $this->getPageLimit() );
		$this->send( Code::success, ['list' => $list, 'total_number' => $adminModel->getTotalCount()] );
	}

	/**
	 * 添加成员
	 * @param string $username 登陆账号 ，一旦注册不可修改，为了保障后台用户操作记录的唯一性
	 * @param string $password 密码
	 * @param string $name     昵称或者姓名 user_admin表
	 * @param int    $status   状态 1开启 0 禁止
	 * @method POST
	 */
	public function add()
	{
		if( $this->validator( $this->post, 'Admin/Member.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$result = \App\Model\User::init()->addAdminUser( [
				'username' => $this->post['username'],
				'password' => UserBiz::encryptPassword( $this->post['password'] ),
				'name'     => $this->post['name'],
				'status'   => $this->post['status'],
			] );

			if( $result > 0 ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 修改
	 * @param int    $id       require 用户id
	 * @param string $name     require 昵称或者姓名 user_admin表
	 * @param string $password 密码 非必填
	 * @param int    $status   require 状态 1开启 0 禁止
	 * @method POST
	 */
	public function edit()
	{
		if( $this->validator( $this->post, 'Admin/Member.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{

			if( isset($this->post['password']) && $this->post['password'] ){
				\App\Model\User::init()->editUser( ['id' => $this->post['id']], ['password' => UserBiz::encryptPassword( $this->post['password'] )] );
			}

			$result = \App\Model\UserAdmin::init()->editUserAdmin( ['user_id' => $this->post['id']], [
				'name'   => $this->post['name'],
				'status' => $this->post['status'],
			] );

			if( $result === true ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
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
				'user.id',
				'user.username',
				'user.phone',
				'user.email',
				'user_admin.name',
				'user_admin.avatar',
				'user_admin.status',
				'user_admin.create_time',
			];

			$info = \App\Model\UserAdmin::init()->where( ['user_id' => $this->get['id']] )->join( 'user', 'user.id = user_admin.user_id', 'LEFT' )->field( $field )->find();

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
		$last_info         = \App\Model\AccessToken::init()->getAccessTokenInfo( [
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
			\App\Model\UserAdmin::init()->delUserAdmin( ['id' => $this->post['id']] );
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
			\App\Model\User::init()->editUser( ['id' => $user['id']], ['password' => UserBiz::encryptPassword( $this->post['password'] )] );
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
		$loginLogic = new \App\Biz\Admin\Login();
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
		$this->send( Code::success, [
			'info' => $this->getRequestUser(),
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
			$result = \App\Model\AccessToken::init()->editAccessToken( [
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

