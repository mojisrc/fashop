<?php
/**
 * 上传控制器
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

use ezswoole\utils\image\Image;
use App\Utils\Code;
use \EasySwoole\Core\Http\Message\UploadFile;

class Upload extends Server
{
	/**
	 * 添加图片
	 * @datetime 2017-05-02T16:03:25+0800
	 * @param string $type file | base64
	 * @param mixed  $image
	 * @author   韩文博
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
					$this->send( Code::param_error, [], $this->getValidate()->getError() );
				}
			} catch( \Exception $e ){
				$this->send( Code::error, [], $e->getMessage() );
			}

		} else{
			return $this->send( Code::user_not_login );
		}
	}

}
