<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/14
 * Time: 下午10:34
 *
 */

namespace App\Logic\Wechat\Support;
use App\Logic\Wechat\AbstractInterface\BaseAbstract;


class AutoReply extends BaseAbstract
{
	/**
	 * 获取当前设置的回复规则
	 * @method GET
	 * @author 韩文博
	 */
	public function current()
	{
		return $this->app->auto_reply->current();
	}

	public function smartreply(){

	}
	public function autoreply(){

	}
	public function beadded(){

	}
}