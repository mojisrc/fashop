<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/27
 * Time: 下午12:45
 *
 */

namespace App\HttpController\Admin;

use ezswoole\Curl;
use ezswoole\utils\verifycode\Conf;
use ezswoole\utils\verifycode\VerifyCode;
use ezswoole\Controller;

/**
 * 杂项
 * Class Mix
 * @package App\HttpController\Admin
 */
class Mix extends Controller
{
	public function verifyCode()
	{
		$Conf = new Conf();
		$Conf->setCharset( '123456ABCD' );
		$Conf->setBackColor( '#FFFFFF' );
		// 开启或关闭混淆曲线
		$Conf->setUseCurve();
		// 开启或关闭混淆噪点
		$Conf->setUseNoise();

		// 设置图片的宽度
		$Conf->setImageWidth( 150 );
		// 设置图片的高度
		$Conf->setImageHeight( 50 );
		// 设置生成字体大小
		$Conf->setFontSize( 18 );
		// 设置生成验证码位数
		$Conf->setLength( 4 );

		$VCode = new VerifyCode( $Conf );
		// 随机生成验证码
		$result = $VCode->drawCode();

		session( 'verify_code', $result->getImageStr() );

		$body = $result->getImageBody();

		$this->response()->withHeader( 'Content-type', 'image/jpg' );

		$this->response()->write( $body );
	}

	public function testSessionCookie()
	{

		dump( cookie( 'PHPSESSID' ) );
		$fd = \ezswoole\Request::getInstance()->getEsRequest()->getSwooleRequest()->fd;
		session( 'fd', $fd );
		dump( session() );
	}

	/**
	 * 微信图片显示
	 * @method GET
	 * @param string $url 图片地址
	 * @author 韩文博
	 */
	public function wechatImage()
	{
		$curl     = new \ezswoole\Curl();
		$response = $curl->request( 'GET', $this->get['url'], [
			'user_opt' => [
				['CURLOPT_REFERER' => 'http://www.qq.com'],
			],
		] );
		$this->response()->withHeader( 'Content-Type', 'image/jpg' );
		$this->response()->write( $response->getBody() );
	}
}