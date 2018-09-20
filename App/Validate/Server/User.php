<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Server;

use ezswoole\Validate;
use App\Logic\VerifyCode;
use App\Utils\Code;
use ezswoole\Db;

class User extends Validate
{
	protected $rule
		= [
			'id'            => 'require',
			'username'      => 'require|checkUsername',
			'password'      => 'require|min:6|max:32',
			'behavior'      => 'require',
			'channel_type'  => 'require|checkChannelType',
			'verify_code'   => 'require|length:4|number|checkVerifyCode',
			'phone'         => 'require|phone|checkPhone',
			'wechat_openid' => 'require',
			'wechat'        => 'require,array',
		];
	protected $message
		= [
			'username.require' => "用户名必填",
			'password.require' => "密码必填",
			'password.min'     => "密码最小长度6位",
			'password.max'     => "密码最大长度32位",
			'verify_code.length'   => "短信验证码格式不正确",
			'verify_code.number'   => "短信验证码格式不正确",
		];

	protected $code
		= [
			'password.min' => Code::user_password_short,
		];
	protected $scene
		= [
			'editPasswordByFind' => [
				'username',
				'password',
				'channel_type',
				'verify_code',
			],
			'editPassword'       => [
				'oldpassword',
				'password',
			],
			'bindPhone'          => [
				'id',
				'phone',
				'password',
				'verify_code',
			],
			'bindWechat'         => [
				'id',
				'wechat',
				'wechat_openid',
			],
		];

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkVerifyCode( $value, $rule, $data )
	{
		$scene_name = $this->getCurrentSceneName();
		if( $scene_name == 'editPasswordByFind' ){
			if( !in_array( $data['channel_type'], VerifyCode::channelTypes ) ){
				return '验证码渠道不存在';
			}
			$condition['code']         = $value;
			$condition['channel_type'] = $data['channel_type'];
			$condition['behavior']     = 'findPassword';

		} elseif( $scene_name == 'bindPhone' ){
			$condition['code']         = $value;
			$condition['channel_type'] = 'sms';
			$condition['behavior']     = 'bindPhone';
		} else{
			return '没有该验证方法';
		}
		$condition['expire_time'] = ['egt', time()];
		$find                     = \ezswoole\Db::name( 'VerifyCode' )->where( $condition )->count();
		return $find ? true : "短信验证码已失效";

	}

	protected function checkPhone( $value, $rule, $data )
	{
		if( !$this->is( $value, 'phone', $data ) ){
			return Code::user_phone_format_error;
		}
		$condition['phone'] = $value;
		$find               = Db::name( 'User' )->where( $condition )->count();
		return $find ? true : Code::user_account_not_exist;
	}

	protected function checkWechatOpenid($wechat_openid,$rule,$data){
		$user_id = Db::name('User')->where(['wechat_openid'=>$wechat_openid])->value('id');
		if($user_id > 0){
			return "该微信已经绑定了";
		}else{
			return true;
		}
	}
	protected function checkWechat($wechat,$rule,$data){
		if(!isset($wechat['openid'])){
			return 'openid miss';
		}
		if(!isset($wechat['nickname'])){
			return 'nickname miss';
		}
		if(!isset($wechat['sex'])){
			return 'sex miss';
		}
		if(!isset($wechat['city'])){
			return 'city miss';
		}
		if(!isset($wechat['country'])){
			return 'country miss';
		}
		if(!isset($wechat['province'])){
			return 'province miss';
		}
		if(!isset($wechat['headimgurl'])){
			return 'headimgurl miss';
		}
		return true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkChannelType( $value, $rule, $data )
	{
		if( in_array( $value, VerifyCode::channelTypes ) ){
			return true;
		} else{
			return '验证码渠道不存在';
		}
	}
}