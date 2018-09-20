<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/19
 * Time: 下午4:42
 *
 */

namespace App\HttpController\Server;

use App\Utils\Code;
use EasySwoole\Core\Swoole\Task\TaskManager;
use Overtrue\EasySms\EasySms;

class Verifycode extends Server
{
	/**
	 * todo 还需要优化发送的设计模式
	 * todo 后台检测短信配置，给友好提示
	 * 获得验证码
	 * @method POST
	 * @param string $behavior
	 * @param string $channel_type
	 * @param string $receiver
	 * @author 韩文博
	 */
	public function add()
	{
		// 有的行为需要加登陆验证
		// todo 验证发送频率
		// 获得发验证码的token 从拿到到请求如果小于3秒则为机器
		// 限制一个手机号码最多能获得验证码的最大额度
		if( $this->validate( $this->post, 'VerifyCode.add' ) !== true ){
			return $this->send( Code::error, [], $this->getValidate()->getError() );
		}
		try{
			// 发送验证码
			if(
				$this->post['channel_type'] == 'sms' && in_array( $this->post['behavior'], [
					'register',
					'findPassword',
					'editPassword',
					'bindPhone',
				] )
			){
				$sms_scene = model( 'SmsScene' )->getSmsSceneInfo( ['id' => 1] );
				// 目前只有阿里云
				if( $sms_scene['provider_type'] == 'aliyun' ){
					$sms_provider = model( 'SmsProvider' )->getSmsProviderInfo( ['status' => 1] );
					if( $sms_provider ){
						$post = $this->post;
//						TaskManager::async( function() use ( $post, $sms_provider, $sms_scene ){
							$code    = rand( 1000, 9999 );
							$config  = [
								// HTTP 请求的超时时间（秒）
								'timeout'  => 5.0,
								// 默认发送配置
								'default'  => [
									// 网关调用策略，默认：顺序调用
									'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
									// 默认可用的发送网关
									'gateways' => [
										'aliyun',
									],
								],
								// 可用的网关配置
								'gateways' => [
									'errorlog' => [
										'file' => EASYSWOOLE_ROOT.'/Runtime/Log/easy-sms.log',
									],
									'aliyun'   => [
										'access_key_id'     => $sms_provider['config']['access_key_id'],
										'access_key_secret' => $sms_provider['config']['access_key_secret'],
										'sign_name'         => $sms_scene['signature'],
									],
								],
							];
							$easySms = new EasySms( $config );
							try{
								$result   = $easySms->send( $this->post['receiver'], [
									'template' => $sms_scene['provider_template_id'],
									'data'     => [
										'code' => $code,
									],
								], ['aliyun'] );
								$now_time = time();
								model( 'VerifyCode' )->addVerifyCode( [
									'receiver'     => $post['receiver'],
									'code'         => $code,
									'channel_type' => $post['channel_type'],
									'behavior'     => $post['behavior'],
									'ip'           => \App\Utils\Ip::getClientIp(),
									'send_state'   => $result === true ? 1 : 0,
									'create_time'  => $now_time,
									'expire_time'  => $now_time + 5 * 60,
								] );
							} catch( \Exception $e ){
								\ezswoole\Log::write( $e->getMessage() );
							}
//						} );
					}
				}
			}
		} catch( \Throwable $e ){
			\ezswoole\Log::write( $e->getMessage() );
		}
		$this->send( Code::success );
	}
}