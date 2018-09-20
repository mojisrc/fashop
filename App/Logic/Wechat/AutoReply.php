<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/7
 * Time: 下午2:26
 *
 */

namespace App\Logic\Wechat;

use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Video;
use EasyWeChat\Kernel\Messages\Voice;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Article;

class AutoReply
{
	private $key;

	/**
	 * @return mixed
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param mixed $key
	 */
	public function setKey( $key ) : void
	{
		$this->key = $key;
	}

	public function __construct( array $data =[] )
	{
		if(isset($data['key'])){
			$this->setKey = $data['key'];
		}
	}

	public function getReplyContentList() : ? array
	{
		$model = model( 'WechatAutoReplyKeywords' );
		$find  = $model->getWechatAutoReplyKeywordsInfo( ['key' => $this->getKey(), 'match_mode' => 'equal'] );
		if( !$find ){
			$find = $model->getWechatAutoReplyKeywordsInfo( [
				'key'        => ['like', "%{$this->getKey()}%"],
				'match_mode' => 'contain',
			] );
		}
		if( $find ){
			$info = model( 'WechatAutoReply' )->getWechatAutoReplyInfo( ['id' => $find['auto_reply_id']] );
			if( $info['reply_mode'] === 'random_one' ){
				$message = array_rand( $info['reply_content'], 1 );
				return [$message];
			} else{
				return $info['reply_content'];
			}
		} else{
			return null;
		}
	}
	public function getSubscribeReplyContent()
	{
		$shop = model( 'Shop' )->getShopInfo(['id'=>1,'auto_reply_status'=>1],'auto_reply_subscribe_replay_content');
		if( $shop ){
			return $shop['auto_reply_subscribe_replay_content'];
		}else{
			return null;
		}
	}

	public function buildMessage( array $message )
	{
			switch( $message['type'] ){
			case 'text':
				$result = new Text( $message['content'] );
			break;
			case 'image':
				$result = new Image( $message['media_id'] );
			break;
			case 'news':
				foreach( $message['extra'] as $item ){
					$items[] = new NewsItem( [
						'title'       => $item['title'],
						'description' => $item['digest'],
						'image'       => $item['cover_url'],
						'url'         => $item['content_url'],
					] );
				}
				$result = new News( $items );
			break;
			case 'voice':
				$result = new Voice( $message['media_id'] );
			break;
			case 'video':
				$result = new Video( $message['media_id'] );
			break;
			case 'local_news':
				foreach( $message['extra'] as $item ){
					$option = [
						'title' => $item['title'],
						'url'   => "http://www.fashop.cn/material?".http_build_query( array_merge( $item['link']['param'], $item['link']['action'] ) ),
					];
					if( isset( $item['cover_pic'] ) ){
						$option['image'] = $item['cover_pic'];
					}
					$items[] = new NewsItem( $option );
				}
				$result = new News( $items );
			break;
			default :
				$result = null;
				break;
			}
		return $result;
	}
}