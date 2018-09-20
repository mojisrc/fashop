<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/26
 * Time: 下午9:58
 *
 */

namespace App\Logic\Wechat\Support;

use App\Logic\Wechat\AbstractInterface\BaseAbstract;

/**
 * Trait Broadcast
 * @package App\Controller\Admin\appTrait
 * 微信的群发消息接口有各种乱七八糟的注意事项及限制，具体请阅读微信官方文档。
 */
class Broadcast extends BaseAbstract
{
	/**
	 * 文本消息
	 * 同时指定目标用户
	 * 至少两个用户的 openid，必须是数组。
	 * @param string $text
	 * @param array  $openids
	 * @param string $group_id
	 * @return mixed
	 * @author 韩文博
	 */
	public function sendText( string $text, array $openids, string $group_id = null )
	{
		return $this->app->broadcasting->sendText( $text, $openids );
	}


	/**
	 * 图文消息
	 * @param $mediaId
	 * @author 韩文博
	 */
	public function sendNews( $mediaId, array $openids, string $group_id = null ) : array
	{
		return $this->app->broadcasting->sendNews( $mediaId );

	}

	/**
	 * 图片消息
	 * @author 韩文博
	 */
	public function sendImage( $mediaId, array $openids, string $group_id = null )
	{
		return $this->app->broadcasting->sendImage( $mediaId );
	}

	/**
	 * 语音消息
	 * @author 韩文博
	 */
	public function sendVoice( $mediaId, array $openids, string $group_id = null )
	{
		return $this->app->broadcasting->sendVoice( $mediaId );

	}

	/**
	 * 视频消息
	 * 用于群发的视频消息，需要先创建消息对象，
	 * @author 韩文博
	 */
	public function sendVideo( $mediaId, array $openids, string $group_id = null )
	{

		return $this->app->broadcasting->sendVideo( $videoMedia['media_id'] );
	}

	/**
	 * 卡券消息
	 * @param string $cardId
	 * @author 韩文博
	 */
	public function sendCard()
	{
		return $this->app->broadcasting->sendCard( $cardId, $groupId );

	}

	/**
	 * 发送预览群发消息给指定的 openId 用户
	 * @param $text
	 * @param $openId
	 * @author 韩文博
	 */
	public function previewText( $text, $openId )
	{
		return $this->app->broadcasting->previewText( $text, $openId );
	}

	public function previewNews( $mediaId, $openId )
	{
		return $this->app->broadcasting->previewNews( $mediaId, $openId );
	}

	public function previewVoice( $mediaId, $openId )
	{
		return $this->app->broadcasting->previewVoice( $mediaId, $openId );
	}

	public function previewImage( $mediaId, $openId )
	{
		return $this->app->broadcasting->previewImage( $mediaId, $openId );
	}

	public function previewVideo( $message, $openId )
	{
		return $this->app->broadcasting->previewVideo( $message, $openId );
	}

	public function previewCard( $cardId, $openId )
	{
		return $this->app->broadcasting->previewCard( $cardId, $openId );
	}


	/**
	 * 发送预览群发消息给指定的微信号用户
	 */
	public function previewTextByName( $text, $wxname )
	{
		return $this->app->broadcasting->previewTextByName( $text, $wxname );
	}

	public function previewNewsByName( $mediaId, $wxname )
	{
		return $this->app->broadcasting->previewNewsByName( $mediaId, $wxname );
	}

	public function previewVoiceByName( $mediaId, $wxname )
	{
		return $this->app->broadcasting->previewVoiceByName( $mediaId, $wxname );
	}

	public function previewImageByName( $mediaId, $wxname )
	{
		return $this->app->broadcasting->previewImageByName( $mediaId, $wxname );
	}

	public function previewVideoByName( $mediaId, $wxname )
	{
		return $this->app->broadcasting->previewVideoByName( $mediaId, $wxname );
	}

	public function previewCardByName( $cardId, $wxname )
	{
		return $this->app->broadcasting->previewCardByName( $cardId, $wxname );
	}

	/**
	 * 删除群发消息
	 * @author 韩文博
	 */
	public function delete( $msgId )
	{
		return $this->app->broadcasting->delete( $msgId );
	}

	/**
	 * 查询群发消息发送状态
	 * @author 韩文博
	 */
	public function status( $msgId )
	{
		return $this->app->broadcasting->status( $msgId );
	}

	/**
	 * 发送消息
	 * @param      $message
	 * @param null $to ，当 $to 为整型时为标签 id ，当 $to 为数组时为用户的 openid 列表（至少两个用户的 openid），当 $to 为 null 时表示全部用户
	 * @author 韩文博
	 */
	public function sendMessage( $message, $to = null )
	{
		return $this->app->broadcasting->sendMessage( $message, $to );
	}
}