<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/5
 * Time: 下午1:34
 *
 */

namespace App\Validate\Admin\Wechat;

use ezswoole\Validate;

class AutoReplySubscribe extends Validate
{
	protected $rule
		= [
			'reply_content' => 'require|array|checkReplyContentData',

		];
	protected $message
		= [
		];

	protected $scene
		= [
			'set' => [
				'reply_content',
			],
		];

	protected function checkReplyContentData( $value, $rule, $data )
	{
		if( !isset( $value['type'] ) ){
			return "回复类型必填";
		}
		if( !in_array( $value['type'], ['text', 'image', 'news', 'voice', 'video', 'local_news'] ) ){
			return "回复类型不存在";
		}
		if( $value['type'] == 'text' && !isset( $value['content'] ) ){
			return "回复文本内容必填";
		}
		if( in_array( $value['type'], ['image', 'news', 'voice', 'video'] ) && !isset( $value['media_id'] ) ){
			return "微信用就素材id必填";
		}
		if( $value['type'] == 'local_news' && !isset( $value['local_news_id'] ) ){
			return "本地图文id必填";
		}

		if($value['type'] === 'image'){
			if(!isset($value['extra']) || !isset($value['extra']['url'])){
				return "图片extra参数错误";
			}
		}
		if($value['type'] === 'news'){
			if(!isset($value['extra']) || !is_array($value['extra'])){
				return "图文extra参数错误";
			}else{
				foreach($value['extra'] as $news){
					if(!isset($news['title']) || !isset($news['thumb_media_id']) || !isset($news['author']) || !isset($news['digest']) || !isset($news['show_cover_pic']) || !isset($news['content']) || !isset($news['content_source_url']) ){
						return "图文extra数组参数错误";
					}
				}
			}
		}
		if($value['type'] === 'voice'){
			if(!isset($value['extra']) || !isset($value['extra']['name'])){
				return "音频extra参数错误";
			}
		}
		if($value['type'] === 'video'){
			if(!isset($value['extra']) || !isset($value['extra']['title']) || !isset($value['extra']['description']) || !isset($value['extra']['down_url'])){
				return "视频extra参数错误";
			}
		}
		if($value['type'] === 'local_news'){
			if(!isset($value['extra'])  || !is_array($value['extra'])){
				return "本地图文extra参数错误";
			}else{
				foreach($value['extra'] as $news){
					if(!isset($news['title']) || !isset($news['cover_pic'])  ){
						return "本地图文extra数组参数错误";
					}
				}
			}
		}
		return true;
	}
}