<?php
/**
 * 微信辅助接口
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use App\Utils\Code;
use App\Logic\Wechat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use ezswoole\Log;

class Wechat extends Server
{
	/**
	 * @var Factory
	 */
	protected $wechat;

	protected function _initialize()
	{
		$this->wechat = new Factory();
	}

	/**
	 * 获得JSSDK的配置
	 * @http     get
	 * @param string $url
	 * @author   韩文博
	 */
	public function jssdk()
	{
		$js = $this->wechat->jssdk;
		if( isset( $this->get['url'] ) ){
			$js->setUrl( urldecode( $this->get['url'] ) );
		}
		$result = $js->buildConfig( [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			'onMenuShareQQ',
			'onMenuShareWeibo',
			'onMenuShareQZone',
			'hideMenuItems',
			'showMenuItems',
			'hideAllNonBaseMenuItem',
			'showAllNonBaseMenuItem',
			'translateVoice',
			'startRecord',
			'stopRecord',
			'onVoiceRecordEnd',
			'playVoice',
			'onVoicePlayEnd',
			'pauseVoice',
			'stopVoice',
			'uploadVoice',
			'downloadVoice',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage',
			'getNetworkType',
			'openLocation',
			'getLocation',
			'hideOptionMenu',
			'showOptionMenu',
			'closeWindow',
			'scanQRCode',
			'chooseWXPay',
			'openProductSpecificView',
			'addCard',
			'chooseCard',
			'openCard',
		], false, false, false );
		$this->send( Code::success, $result );
	}

	/**
	 * 获得微信code
	 * @http     GET
	 * @author   韩文博
	 * @param string $request_url 拿到code要返回的地址   授权后重定向的回调链接地址，请使用urlEncode对链接进行处理
	 * @param int    $scope       snsapi_userinfo 正常授权  snsapi_base 静默授权 不传默认为snsapi_base
	 *                            说明：会跳转到request_url地址，并且带上code
	 */
	public function code()
	{
		// code返回的跳转
		if( isset( $this->get['code'] ) ){
			$redirect = $this->get->request_url.(strstr( $this->get->request_url, '?' ) ? '&code='.$this->get->code : '?code='.$this->get->code);
			$this->response()->redirect( $redirect );
		} else{
			//请求code
			$request                   = request();
			$scope                     = $this->get['scope'] ? [$this->get['scope']] : ['snsapi_base'];
			$url_params['request_url'] = $this->get->request_url;
			$redirect_url              = $request->domain().$request->root()."/server/wechat/code?".http_build_query( $url_params );
			$oauth                     = $this->wechat->oauth->instance();
			$redirect                  = $oauth->scopes( $scope )->withRedirectUrl( $redirect_url )->redirect();
			$this->response()->redirect( $redirect->getTargetUrl() );
		}
	}

	/**
	 * 获得微信openid
	 * @http     get
	 * @param string $code
	 * @author   韩文博
	 */
	public function openid()
	{
		$oauth  = $this->wechat->oauth->instance();
		$user   = $oauth->user();
		$openid = $user->getId();
		$this->send( Code::success, ['openid' => $openid] );
	}

	/**
	 * @author 韩文博
	 */
	public function message()
	{
		try{
			$server  = $this->wechat->server->instance();
			$message = $server->getMessage();
			switch( $message['MsgType'] ){
			case 'event':
				// 关注自动回复
				if( $message['Event'] === 'subscribe' ){
					$autoReplyLogic = new \App\Logic\Wechat\AutoReply();
					$replyMessage   = $autoReplyLogic->getSubscribeReplyContent();
					if($replyMessage){
						$xml            = $server->buildResponse( $message['FromUserName'], $message['ToUserName'], $autoReplyLogic->buildMessage( $replyMessage ) );
						$this->response()->write( $xml );
					}
				} else{
					$text = new Text( '' );
					$xml  = $server->buildResponse( $message['FromUserName'], $message['ToUserName'], $text );
					$this->response()->write( $xml );
				}
			break;
			case 'text':
				// 5秒内给微信做出反馈，但不利用该接口，换使用客服消息，因为需求里存在发送全部，如果是随机一条可以使用本次请求的反馈
				$text = new Text( '' );
				$xml  = $server->buildResponse( $message['FromUserName'], $message['ToUserName'], $text );
				$this->response()->write( $xml );
				// 检查是否有能匹配的关键词
				$autoReplyLogic   = new \App\Logic\Wechat\AutoReply( ['key' => $message['Content']] );
				$replyContentList = $autoReplyLogic->getReplyContentList();
				if( $replyContentList ){
					$customerService = $this->wechat->customerService->instance();
					foreach( $replyContentList as $replyMessage ){
						$customerService->message( $autoReplyLogic->buildMessage( $replyMessage ) )->to( $message['FromUserName'] )->send();
					}
				}
			break;
			default:
				$text = new Text( '' );
				$xml  = $server->buildResponse( $message['FromUserName'], $message['ToUserName'], $text );
				$this->response()->write( $xml );
			break;
			}
		} catch( \Exception $e ){
			Log::write( $e->getMessage() );
		}
	}

}
