<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/26
 * Time: 下午9:59
 *
 */

namespace App\Logic\Wechat\Support;

use App\Logic\Wechat\AbstractInterface\BaseAbstract;

/**
 * Trait Material
 * @package App\Controller\Admin\appTrait
 *          上传的临时多媒体文件有格式和大小限制，如下：
 *
 * 图片（image）: 1M，支持 JPG 格式
 * 语音（voice）：2M，播放长度不超过 60s，支持 AMR\MP3 格式
 * 视频（video）：10MB，支持 MP4 格式
 * 缩略图（thumb）：64KB，支持 JPG 格式
 * 上传图片
 *
 * 注意：微信图片上传服务有敏感检测系统，图片内容如果含有敏感内容，如色情，商品推广，虚假信息等，上传可能失败。
 */
class Media extends BaseAbstract
{

	/**
	 * @param $path
	 * @author 韩文博
	 */
	public function uploadImage( string $path )
	{
		return $this->app->media->uploadImage( $path );
	}

	/**
	 * 上传声音
	 * @param $path
	 * @author 韩文博
	 */
	public function uploadVoice( string $path )
	{
		return $this->app->media->uploadVoice( $path );
	}

	/**
	 * 上传视频
	 * @param string $path
	 * @param string $title
	 * @param string $description
	 * @author 韩文博
	 */
	public function uploadVideo( string $path, string $title, string $description )
	{
		return $this->app->media->uploadVideo( $path, $title, $description );
	}

	/**
	 * todo
	 * 上传缩略图
	 * 用于视频封面或者音乐封面
	 * @param string $path
	 * @author 韩文博
	 */
	public function uploadThumb( string $path )
	{
		return $this->app->media->uploadThumb( $path );

	}

	/**
	 * 上传群发视频
	 * 上传视频获取 media_id 用以创建群发消息用。
	 * @param string $path
	 * @param string $title
	 * @param string $description
	 * @author 韩文博
	 */
	public function uploadVideoForBroadcasting( string $path, string $title, string $description )
	{
		return $this->app->media->uploadVideoForBroadcasting( $path, $title, $description );
	}

	/**
	 * 创建群发消息
	 * 不要与上面 上传群发视频 搞混了，上面一个是上传视频得到 media_id，这个是使用该 media_id 加标题描述 创建一条消息素材 用来发送给用户。详情参见：消息群发
	 * @param string $mediaId
	 * @param string $title
	 * @param string $description
	 * @author 韩文博
	 */
	public function createVideoForBroadcasting( string $mediaId, string $title,string $description )
	{
		return $this->app->media->createVideoForBroadcasting( $mediaId, $title, $description );
	}

	/**
	 * 获取临时素材内容
	 * 比如图片、语音等二进制流内容，响应为 EasyWechat\Kernel\Http\StreamResponse 实例。
	 * @author 韩文博
	 */
	public function get( string $mediaId )
	{
		return $stream = $this->app->media->get( $mediaId );
	}


	/**
	 * 获取 JSSDK 上传的高清语音
	 * @param $mediaId
	 * @author 韩文博
	 */
	public function getJssdkMedia(string $mediaId )
	{
		return $stream = $this->app->media->getJssdkMedia( $mediaId );
	}
}