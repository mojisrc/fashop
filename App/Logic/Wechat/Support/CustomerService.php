<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/14
 * Time: 下午10:36
 *
 */

namespace App\Logic\Wechat\Support;
use App\Logic\Wechat\AbstractInterface\BaseAbstract;


class CustomerService extends BaseAbstract
{
	public function instance(){
		return  $this->app->customer_service;
	}
	/**
	 * 获取所有客服
	 * @author 韩文博
	 */
	public function list()
	{
		return $this->app->customer_service->list();
	}

	/**
	 * 获取所有在线的客服
	 * @author 韩文博
	 */
	public function online()
	{
		return $this->app->customer_service->online();

	}

	/**
	 * 添加客服
	 * @param  string $account
	 * @param  string $name
	 * @author 韩文博
	 */
	public function create( string $account, string $name )
	{
		return $this->app->customer_service->create( $account, $name );

	}

	/**
	 * 修改客服
	 * @author 韩文博
	 */
	public function update( string $account, string $name )
	{
		return $this->app->customer_service->update( $account, $name );

	}

	/**
	 * 删除账号
	 * @author 韩文博
	 */
	public function delete( string $account )
	{
		return $this->app->customer_service->delete( $account );
	}

	/**
	 * 设置客服头像
	 * @author 韩文博
	 */
	public function setAvatar( string $account, string $avatarPath )
	{
		return $this->app->customer_service->setAvatar( $account, $avatarPath ); // $avatarPath 为本地图片路径，非 URL
	}

	/**
	 * 获取客服与客户聊天记录
	 * @author 韩文博
	 *         示例:
	 *
	 * $records = $this->app->customer_service->messages('2015-06-07', '2015-06-21', 1, 20000);
	 */
	public function messages( $startTime, $endTime, $msgId = 1, $number = 10000 )
	{
		return $this->app->customer_service->messages( $startTime, $endTime, $msgId = 1, $number = 10000 );

	}

	/**
	 * 主动发送消息给用户
	 * @param      $message
	 * @param null $openId
	 * @param null $from 客服
	 * @param null $to
	 * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
	 * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
	 * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
	 * @author 韩文博
	 */
	public function message( $message, $openId = null, $from = null, $to = null )
	{
		$event = $this->app->customer_service->message( $message )->to( $openId )->send();
		if( $openId ){
			$event->to( $openId );
		}
		if( $from ){
			$event->from( $from );
		}
		if( $to ){
			$event->to( $to );
		}
		$event->send();
		return $event;
	}

	/**
	 * 邀请微信用户加入客服
	 *
	 * 以账号 foo@test 邀请 openid 为 openidxxxx 的微信用户加入客服。
	 * @author 韩文博
	 */
	public function invite()
	{
		return $this->app->customer_service->invite( 'foo@test', 'openidxxxx' );
	}

	/**
	 * 创建会话
	 * @author 韩文博
	 */
	public function sessionCreate()
	{
		return $this->app->customer_service_session->create( 'test1@test', 'OPENID' );

	}

	/**
	 * 关闭会话
	 * @author 韩文博
	 */
	public function sessionClose()
	{
		return $this->app->customer_service_session->close( 'test1@test', 'OPENID' );

	}

	/**
	 * 获取客户会话状态
	 * @author 韩文博
	 */
	public function sessionGet()
	{
		return $this->app->customer_service_session->get( 'OPENID' );
	}


	/**
	 * 获取客服会话列表
	 * @author 韩文博
	 */
	public function sessionList()
	{
		return $this->app->customer_service_session->list( 'test1@test' );
	}

	/**
	 * 获取未接入会话列表
	 * waiting
	 */
	public function sessionWaiting()
	{
		return $this->app->customer_service_session->waiting();
	}
}