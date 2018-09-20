<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/14
 * Time: 下午10:40
 *
 */

namespace App\Logic\Wechat\Support;
use App\Logic\Wechat\AbstractInterface\BaseAbstract;


class Server extends BaseAbstract
{
	public function instance(){
		return  $this->app->server;
	}
}