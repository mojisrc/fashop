<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/2
 * Time: 下午12:13
 *
 */

namespace App\Validate\Admin\Wechat;

use ezswoole\Validate;

class Material extends Validate
{
	protected $rule
		= [
			'media_id'    => 'require',
			'type'        => 'require|checkType',
			'offset'      => 'require|integer',
			'count'       => 'require|integer|max:30',
			'image'       => 'offset',
			'path'        => 'require|videoCheckType',
			'title'       => 'require',
			'description' => 'require',
			'images'      => 'require',
			'media'       => 'require|file|isArticle|isArticles',
			'article'     => 'require|isArticle',
			'index'       => 'require|integer',

		];
	protected $message
		= [
			'offset.require'      => "偏移位置必填",
			'count.require'       => "数量必填",
			'image.require'       => "图片必传",
			'path.require'        => "视频必传",
			'title.require'       => "标题必填",
			'description.require' => "描述必填",
			'images.require'      => "描述必填",

		];
	protected $scene
		= [
			'get'    => ['media_id'],
			'delete' => ['media_id'],
			'list'   => [
				'type',
				'offset',
				'count',
			],
		];

	public function sceneUploadImage()
	{
		return $this->only( ['media'] )->remove( 'media', 'isArticle|isArticles' );
	}

	public function sceneUploadVoice()
	{
		return $this->only( ['media'] )->remove( 'media', 'isArticle|isArticles' );
	}

	public function sceneUploadVideo()
	{
		return $this->only( ['media'] )->remove( 'media', 'isArticle|isArticles' );
	}

	public function sceneUploadThumb()
	{
		return $this->only( ['media'] )->remove( 'media', 'isArticle|isArticles' );
	}

	public function sceneUploadArticle()
	{
		return $this->only( ['media'] )->remove( 'media', 'file|isArticles' );
	}

	public function sceneUpdateArticle()
	{
		return $this->only( ['media_id', 'article', 'index'] );
	}

	public function sceneUploadArticleImage()
	{
		return $this->only( ['media'] )->remove( 'media', 'file|isArticles' );
	}


	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function isArticle( $value, $rule, $data )
	{
		if( !isset( $value['title'] ) ){
			return "文章标题必填";
		}
		if( !isset( $value['thumb_media_id'] ) ){
			return "封面图永久素材ID必填";
		}
		if( !isset( $value['show_cover_pic'] ) ){
			return "是否显示封面图必填";
		}
		if( !isset( $value['content_source_url'] ) ){
			return "“阅读原文”后的URL必填";
		}
		if( !isset( $value['content'] ) ){
			return "图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS";
		}
		if( $this->getCurrentSceneName() === 'updateArticle' ){
			if( !isset( $value['author'] ) ){
				return "作者必填";
			}
			if( !isset( $value['digest'] ) ){
				return "图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空";
			}
		}
		return true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function isArticles( $values, $rule, $data )
	{
		foreach( $values as $value ){

			if( !isset( $value['title'] ) ){
				return "文章标题必填";
			}
			if( !isset( $value['thumb_media_id'] ) ){
				return "封面图永久素材ID必填";
			}
			if( !isset( $value['show_cover_pic'] ) ){
				return "是否显示封面图必填";
			}
			if( !isset( $value['content_source_url'] ) ){
				return "“阅读原文”后的URL必填";
			}
			if( !isset( $value['content'] ) ){
				return "图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS";
			}
			if( $this->getCurrentSceneName() === 'updateArticle' ){
				if( !isset( $value['author'] ) ){
					return "作者必填";
				}
				if( !isset( $value['digest'] ) ){
					return "图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空";
				}
			}
		}
		return true;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkType( $value, $rule, $data )
	{
		return in_array( $value, ['image', 'video', 'voice', 'news'] ) ? true : "类型不存在";
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function videoCheckType( $value, $rule, $data )
	{
		return in_array( $value, ['mp3'.'wma', 'wav', 'amr'] ) ? true : "类型不存在";
	}
}