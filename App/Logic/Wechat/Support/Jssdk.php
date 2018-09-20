<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/14
 * Time: 下午10:38
 *
 */

namespace App\Logic\Wechat\Support;

use App\Logic\Wechat\AbstractInterface\BaseAbstract;

class Jssdk extends BaseAbstract
{
	/**
	 * 获取JSSDK的配置数组，默认返回 JSON 字符串，当 $json 为 false 时返回数组，你可以直接使用到网页中。
	 * @param array $apis
	 * @param bool  $debug
	 * @param bool  $beta
	 * @param bool  $json
	 * @author 韩文博
	 */
	public function buildConfig( array $apis, bool $debug, bool $beta, bool $json )
	{
		return $this->app->jssdk->buildConfig( $apis, $debug, $beta, $json );
	}

	/**
	 * 设置当前URL，如果不想用默认读取的URL，可以使用此方法手动设置，通常不需要。
	 * @param $url
	 * @author 韩文博
	 */
	public function setUrl( string $url )
	{
		return $this->app->jssdk->setUrl( $url );
	}
}