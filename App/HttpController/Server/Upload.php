<?php
/**
 * 上传控制器
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use ezswoole\utils\image\Image;
use App\Utils\Code;
use \EasySwoole\Core\Http\Message\UploadFile;

class Upload extends Server
{
	/**
	 * 添加图片
	 * @param string $type file | base64
	 * @param mixed  $image
	 */
	public function addImage()
	{
		if( $this->verifyResourceRequest() === true ){
			try{
				$file   = isset( $this->post['image'] ) ? $this->post['image'] : $this->request->file( 'image' );
				$images = Image::getInstance()->create( $file )->crop()->getImages();
				if( $images ){
					$host = $this->request->domain()."/";
					foreach( $images as $key => $image ){
						$images[$key]['path'] = $host.$image['path'];
					}
					$this->send( Code::success, $images );
				} else{
					$this->send( Code::param_error, [], $this->getValidator()->getError() );
				}
			} catch( \Exception $e ){
				$this->send( Code::error, [], $e->getMessage() );
			}

		} else{
			return $this->send( Code::user_not_login );
		}
	}

}
