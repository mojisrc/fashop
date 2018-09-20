<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/10
 * Time: 下午5:06
 *
 */

namespace App\Update\Db;


abstract class UpdateAbstract
{
	abstract public function run() : bool;
}