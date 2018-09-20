<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/2
 * Time: 下午9:41
 *
 */

namespace App\Logic\Wechat\Support;

use App\Logic\Wechat\AbstractInterface\BaseAbstract;

class Oauth extends BaseAbstract
{
	public function instance(){
		return  $this->app->oauth;
	}
//	public function scopes(array $option){
//		return $this->app->oauth->scopes($option);
//	}
//	public function withRedirectUrl(string $url) : Oauth
//	{
//		 $this->app->oauth->withRedirectUrl($url);
//		 return $this;
//	}
//	public function redirect():void{
//		$this->app->oauth->redirect();
//	}
}