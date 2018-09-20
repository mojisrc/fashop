<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/2
 * Time: 下午11:04
 *
 */

namespace App\Validate\Admin\Wechat;


use ezswoole\Validate;

class Menu extends Validate
{
	protected $rule
		= [
			'menu_id'=>'require',
			'buttons' => 'require|array',
		];
	protected $scene
		= [
			'create' => ['buttons'],
			'delete'=>['menu_id']
		];

}