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
namespace App\Logic\Server;


class Login
{
	/**
	 * @var string
	 */
	private $loginType;
	/**
	 * @var string
	 */
	private $wechatOpenid;
	/**
	 * @var array
	 */
	private $options;
	/**
	 * @var string
	 */
	private $username;
	/**
	 * @var string
	 */
	private $phone;
	/**
	 * @var string
	 */
	private $password;
	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @return int
	 */
	public function getUserId() : int
	{
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId( int $userId ) : void
	{
		$this->userId = $userId;
	}

	/**
	 * @return string
	 */
	public function getPassword() : string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword( string $password ) : void
	{
		$this->password = $password;
	}


	/**
	 * @return string
	 */
	public function getPhone() : string
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone( string $phone ) : void
	{
		$this->phone = $phone;
	}

	/**
	 * @return string
	 */
	public function getUsername() : string
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername( string $username ) : void
	{
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getWechatOpenid() : string
	{
		return $this->wechatOpenid;
	}

	/**
	 * @param string $openid
	 */
	public function setWechatOpenid( string $openid ) : void
	{
		$this->wechatOpenid = $openid;
	}

	/**
	 * @return array
	 */
	public function getOptions() : array
	{
		return $this->options;
	}

	/**
	 * @param array $options
	 */
	public function setOptions( array $options = null ) : void
	{
		$this->options = $options;
	}

	public function __construct( array $options )
	{
		$this->setOptions( $options );
	}

	/**
	 * @return string
	 */
	public function getLoginType() : string
	{
		return $this->loginType;
	}

	/**
	 * @param string $loginType
	 */
	public function setLoginType( string $loginType ) : void
	{
		$this->loginType = $loginType;
	}


	/**
	 * @return array|null
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function login() : ? array
	{
		$this->setLoginType( $this->options['login_type'] );
		switch( $this->getLoginType() ){
		case  'password':
			return $this->byPassword();
		case 'wechat_openid':
			return $this->byWechatOpenid();
		case 'wechat_mini':
			return $this->byWechatMini();
		default:
			throw new \Exception( "login_type not exist" );
		}
	}

	/**
	 * @return array|null
	 * @throws \Exception
	 * @author 韩文博
	 */
	private function byPassword() : ? array
	{
		$this->setUsername( $this->options['username'] );
		$this->setPassword( $this->options['password'] );
		$username              = $this->getUsername();
		$condition['password'] = \App\Logic\User::encryptPassword( $this->getPassword() );

		if( is_numeric( $username ) ){
			$condition['phone']	   = $username;
		}else{
			$condition['username'] = $username;
		}

		$user = model( 'User' )->getUserInfo( $condition, 'id' );
		if( $user ){
			return $this->createAccessToken( $user['id'] );
		} else{
			return null;
		}
	}

	private function byWechatOpenid() : ? array
	{
		$this->setWechatOpenid( $this->options['wechat_openid'] );
        $user_id = model('UserOpen')->getUserOpenValue(['openid' => $this->getWechatOpenid()], '', 'user_id');
		if( $user_id > 0 ){
			return $this->createAccessToken( $user_id);
		} else{
			return null;
		}
	}

	private function createAccessToken( int $user_id = null ) : ? array
	{
		if( $user_id != null ){
			$this->setUserId( $user_id );
		}
		$accessTokenLogic = new \App\Logic\AccessToken();
		return $accessTokenLogic->createAccessToken( $this->getUserId(), time() );
	}

	private function byWechatMini() : ? array
	{
		$wechatminiApi   = new \App\Logic\Wechatmini\Factory();
		// @error 这儿报错了
		$session = $wechatminiApi->getApp()->auth->session($this->options['wechat_mini_code']);
		if(is_array($session) && array_key_exists('openid',$session)){
            $user_id = model('UserOpen')->getUserOpenValue(['openid' => $session['openid']], '', 'user_id');
            if( $user_id > 0 ){
				return $this->createAccessToken( $user_id );
			}
		}
		return null;
	}

}

?>
