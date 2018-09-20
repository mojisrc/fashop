<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/1
 * Time: 下午4:51
 *
 */

namespace App\Logic\Wechat;

use EasyWeChat\Factory as EasyWeChatFactory;

/**
 * Class Factory
 * @package App\Logic\Wechat
 * @property Support\AutoReply       $autoReplay
 * @property Support\Broadcast       $broadcast
 * @property Support\Comment         $comment
 * @property Support\CustomerService $customerService
 * @property Support\DataCube        $dataCube
 * @property Support\Jssdk           $jssdk
 * @property Support\Material        $material
 * @property Support\Media           $media
 * @property Support\Menu            $menu
 * @property Support\Message         $message
 * @property Support\Notice          $notice
 * @property Support\Payment         $paymentba
 * @property Support\Qrcode          $qrcode
 * @property Support\Server          $server
 * @property Support\Stats           $stats
 * @property Support\TemplateMessage $templateMessage
 * @property Support\User            $user
 * @property Support\UserTag         $userTag
 * @property Support\AccessToken     $accessToken
 * @property Support\Oauth           $oauth
 */
class Factory
{
	protected $container = [];
	protected $providers
		= [
			"autoReplay"      => Support\AutoReply::class,
			"broadcast"       => Support\Broadcast::class,
			"comment"         => Support\Comment::class,
			"customerService" => Support\CustomerService::class,
			"dataCube"        => Support\DataCube::class,
			"jssdk"           => Support\Jssdk::class,
			"material"        => Support\Material::class,
			"media"           => Support\Media::class,
			"menu"            => Support\Menu::class,
			"message"         => Support\Message::class,
			"notice"          => Support\Notice::class,
			"payment"         => Support\Payment::class,
			"qrcode"          => Support\Qrcode::class,
			"server"          => Support\Server::class,
			"stats"           => Support\Stats::class,
			"templateMessage" => Support\TemplateMessage::class,
			"user"            => Support\User::class,
			"userTag"         => Support\UserTag::class,
			"accessToken"     => Support\AccessToken::class,
			"oauth"           => Support\Oauth::class,
		];

	private $app;

	public function __construct()
	{
		$config    = \EasySwoole\Config::getInstance()->getConf( 'wechat' );
		$this->app = EasyWeChatFactory::officialAccount( $config );
		$this->app['cache'] = new \ezswoole\Cache();
		\App\Utils\Request::clearRequestFactory();
		$this->app->request = \App\Utils\Request::createFromGlobals();
	}

	/**
	 * @param $name
	 * @return mixed
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function __get( $name )
	{
		if( !isset( $this->providers[$name] ) ){
			throw new \Exception( "class not found" );
		} else{
			if( !isset( $this->container[$name] ) || !$this->container[$name] instanceof AbstractInterface\BaseAbstract ){
				try{
					$this->container["{$name}"] = new $this->providers[$name];
					$this->container["{$name}"]->setApp( $this->app );
				} catch( \Exception $e ){
					throw new $e;
				}
			}
			return $this->container["{$name}"];
		}
	}

}