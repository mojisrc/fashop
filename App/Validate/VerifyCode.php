<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/20
 * Time: 下午8:17
 *
 */

namespace App\Validate;

use ezswoole\Validate;
use App\Logic\VerifyCode as VerifyCodeLogic;
use ezswoole\Db;

class VerifyCode extends Validate
{
	protected $rule
		= [
			'ip'           => 'require|checkIp',
			'behavior'     => 'require|checkBehaviourType',
			'channel_type' => 'require|checkChannelType',
			'receiver'     => 'require|checkReceiver',
		];

	protected $message
		= [
			'behavior.require'     => '行为必填',
			'channel_type.require' => "渠道类型必填",
			'receiver.require'     => "接收者必填",
		];
	protected $scene
		= [
			'add' => [
				//				'ip',
				'receiver',
				'behavior',
				'channel_type',
			],

		];

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkIp( $value, $rule, $data )
	{
		// todo
		return true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkBehaviourType( $value, $rule, $data )
	{
		return in_array( $value, VerifyCodeLogic::behaviourTypes ) ? true : '不存在该类型';
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkChannelType( $value, $rule, $data )
	{
		return in_array( $value, VerifyCodeLogic::channelTypes ) ? true : '不存在该类型';

	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkReceiver( $value, $rule, $data )
	{
		if( !$this->is( $value, 'phone', $data ) && !$this->is( $value, 'email', $data ) ){
			return "接收者格式错误";
		}
		if( $data['channel_type'] === 'phone' && !$this->is( $value, 'phone' ) ){
			return "手机格式错误";
		}
		if( $data['channel_type'] === 'email' && !$this->is( $value, 'email' ) ){
			return "邮箱格式错误";
		}

		$now_time = time();
		$start    = strtotime( date( 'Y-m-d 00:00' ) );
		$end      = strtotime( date( 'Y-m-d 23:59:59' ) );

		// 检查频率
		$find = Db::name( 'VerifyCode' )->where( [
			'receiver'     => $value,
			'channel_type' => $data['channel_type'],
			'behavior'     => $data['behavior'],
		] )->find();
		if( $find && $find['create_time'] + 60 > $now_time ){
			return "您的操作过于频繁，请稍后再试";
		}
		// todo 验证cookie

		// 判断当日发送频率
		$send_count = Db::name( 'VerifyCode' )->where( [
			'create_time'  => ['between', [$start, $end]],
			'receiver'     => $value,
			'channel_type' => $data['channel_type'],
			'behavior'     => $data['behavior'],
		] )->count();

		if( $send_count > 30 ){
			return '您已超过今日发送最大频率，请明天再试';
		}

		// 检查IP发送频率
		$ip_count = Db::name( 'VerifyCode' )->where( [
			'create_time' => ['between', [$now_time, $now_time + 5 * 60]], // 5分钟
			'ip'          => \App\Utils\Ip\getClientIp(),
		] )->count();

		// 100/10 ，粗略估计10人 每人发10个验证码
		if( $ip_count > 100 ){
			return "禁止发送";
		}

		// 当日该IP发送频率不得大于300
		// 300/10 ，粗略估计30人 每人发10个验证码
		$ip_count = Db::name( 'VerifyCode' )->where( [
			'create_time' => ['between', [$start, $end]], // 5分钟
			'ip'          => \App\Utils\Ip\getClientIp(),
		] )->count();
		if( $ip_count > 300 ){
			return "禁止发送";
		}

		// todo 访问记录，如果当前用户其他接口都没有请求过，只访问了发送请求发送短信可判断是机器
		// todo 如果当前用户访问的频率和之前高频访问的客户端请求高度一致可判断是机器
		// todo 黑名单列表

		return true;
	}
}