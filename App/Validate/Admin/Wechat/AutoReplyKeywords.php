<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/5
 * Time: 下午2:02
 *
 */

namespace App\Validate\Admin\Wechat;

use ezswoole\Validate;

class AutoReplyKeywords extends Validate
{
	protected $rule
		= [
			'id'            => 'require',
			'rule_name'     => 'require|max:60',
			'reply_mode'    => 'require|checkReplyMode',
			'keywords'      => 'require|array|checkKeywordsData',
			'reply_content' => 'require|array|checkReplyContentData',
		];

	protected $scene
		= [
			'add'  => [
				'rule_name',
				'reply_mode',
				'keywords',
				'reply_content',
			],
			'edit' => [
				'id',
				'rule_name',
				'reply_mode',
				'keywords',
				'reply_content',
			],
			'del'  => [
				'id',
			],
			'info' => [
				'id',
			],
		];

	protected function checkReplyMode( $value, $rule, $data )
	{
		if( !in_array( $value, ['reply_all', 'random_one'] ) ){
			return '回复模式不存在';
		} else{
			return true;
		}
	}

	protected function checkKeywordsData( $value, $rule, $data )
	{
		if( count( $value ) > 10 ){
			return '最多10条关键词';
		}
		foreach( $value as $item ){
			if( !isset( $item['key'] ) || !isset( $item['match_mode'] ) ){
				return 'keywords参数key或match_mode错误';
			}
			if( !in_array( $item['match_mode'], ['contain', 'equal'] ) ){
				return 'keywords参数match_mode模式不存在';
			}
		}
		return true;
	}

	protected function checkReplyContentData( $value, $rule, $data )
	{
		if( count( $value ) > 5 ){
			return '最多5条回复内容';
		}

		foreach( $value as $item ){
			if( !isset( $item['type'] ) ){
				return "回复类型必填";
			}
			if( !in_array( $item['type'], ['text', 'image', 'news', 'voice', 'video', 'local_news'] ) ){
				return "回复类型不存在";
			}
			if( $item['type'] == 'text' && !isset( $item['content'] ) ){
				return "回复文本内容必填";
			}
			if( in_array( $item['type'], ['image', 'news', 'voice', 'video'] ) && !isset( $item['media_id'] ) ){
				return "微信用就素材id必填";
			}
			if($item['type'] === 'image'){
				if(!isset($item['extra']) || !isset($item['extra']['url'])){
					return "图片extra参数错误";
				}
			}
			if($item['type'] === 'news'){
				if(!isset($item['extra']) || !is_array($item['extra'])){
					return "图文extra参数错误";
				}else{
					foreach($item['extra'] as $news){
						if(!isset($news['title']) || !isset($news['thumb_media_id']) || !isset($news['author']) || !isset($news['digest']) || !isset($news['show_cover_pic']) || !isset($news['content']) || !isset($news['content_source_url']) ){
							return "图文extra数组参数错误";
						}
					}
				}
			}
			if($item['type'] === 'voice'){
				if(!isset($item['extra']) || !isset($item['extra']['name'])){
					return "音频extra参数错误";
				}
			}
			if($item['type'] === 'video'){
				if(!isset($item['extra']) || !isset($item['extra']['title']) || !isset($item['extra']['description']) || !isset($item['extra']['down_url'])){
					return "视频extra参数错误";
				}
			}
			if( $item['type'] == 'local_news' && !isset( $item['local_news_id'] ) ){
				return "本地图文id必填";
			}
			if($item['type'] === 'local_news'){
				if(!isset($item['extra'])  || !is_array($item['extra'])){
					return "本地图文extra参数错误";
				}else{
					foreach($item['extra'] as $news){
						if(!isset($news['title']) || !isset($news['cover_pic'])  ){
							return "本地图文extra数组参数错误";
						}
					}
				}
			}

		}
		return true;
	}
}