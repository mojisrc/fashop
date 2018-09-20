<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/3
 * Time: 下午11:27
 *
 */

namespace App;

class Provider
{
	public function get(){
		return [
			'lang'      => \ezswoole\Lang::class,
		];
	}
}