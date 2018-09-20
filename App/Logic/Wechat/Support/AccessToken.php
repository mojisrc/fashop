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


class AccessToken extends BaseAbstract
{
	/**
	 * @param bool $refresh
	 *
	 * @return array
	 */
	public function getToken(bool $refresh = false): array
	{
		return $this->app->access_token->getToken($refresh);
	}
}