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

use EasyWechat\Kernel\Messages\Article;
use App\Utils\Code;
use ezswoole\utils\image\Image;

/**
 * @package App\Controller\Admin\appTrait
 *
 * 注意：微信图片上传服务有敏感检测系统，图片内容如果含有敏感内容，如色情，商品推广，虚假信息等，上传可能失败。
 */
class Material extends BaseAbstract
{
	/**
	 * 上传图片
	 * @param string $path
	 * @author 韩文博
	 */
	public function uploadImage( string $path )
	{
		return $this->app->material->uploadImage( $path );
	}

	/**
	 * 上传声音
	 * @param string $path
	 * @author 韩文博
	 */
	public function uploadVoice( string $path )
	{
		return $this->app->material->uploadVoice( $path );
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
		return $this->app->material->uploadVideo( $path, $title, $description );
	}

	/**
	 * 上传缩略图
	 * 用于视频封面或者音乐封面
	 * @param string $path
	 * @author 韩文博
	 */
	public function uploadThumb( string $path )
	{
		return $this->app->material->uploadThumb( $path );
	}

	/**
	 * 上传图文消息
	 * @param array $articles
	 * @author 韩文博
	 */
	public function uploadArticle( array $articles )
	{
		return $this->app->material->uploadArticle( $articles );
	}

	/**
	 * 修改图文消息
	 * @param string $media_id 要更新的文章的 mediaId
	 * @param array  $article  文章内容
	 * @param int    $index    要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义，单图片忽略此参数），第一篇为 0；
	 * @author 韩文博
	 */
	public function updateArticle( string $media_id, array $article, int $index = 0 )
	{
		return $this->app->material->updateArticle( $media_id, $article, $index );
	}

	/**
	 * 上传图文消息图片
	 * 返回值中 url 就是上传图片的 URL，可用于后续群发中，放置到图文消息中。
	 * @param string $image
	 * @author 韩文博
	 */
	public function uploadArticleImage( string $path )
	{
		return $this->app->material->uploadArticleImage( $path );
	}

	/**
	 * 获取永久素材
	 * @param string $media_id
	 * @author 韩文博
	 */
	public function get( string $media_id )
	{
		return $this->app->material->get( $media_id );
	}

	/**
	 * 获取永久素材列表
	 * @author 韩文博
	 * @param string $type 素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news)
	 * @param int    $offset
	 * @param int    $count
	 */
	public function list( string $type, int $offset, int $count )
	{
		return $this->app->material->list( $type, $offset, $count );
	}

	/**
	 * 获取素材计数
	 * @author 韩文博
	 */
	public function stats()
	{
		return $this->app->material->stats();
	}

	/**
	 * 删除永久素材；
	 * @method POST
	 * @param string $media_id
	 * @author 韩文博
	 */
	public function delete( string $media_id )
	{
		return $this->app->material->delete( $media_id );
	}

}