<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/10
 * Time: 下午4:16
 *
 */

namespace App\Update;


class Behavior
{
	/**
	 * 当升级包的文件覆盖完毕后
	 * @author 韩文博
	 */
	public function onFilesCoverComplete() : bool
	{
		return true;
	}

}