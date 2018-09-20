<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Admin;

use ezswoole\Validate;
use ezswoole\Db;
use App\Logic\VerifyCode;

class SendArea extends Validate
{
	protected $rule
		= [
			'id'      => 'require',
			'title'      => 'require',
			'area_ids'      => 'require',
		];
	protected $message
		= [
			'id.require' => "id必须",
			'title.require'     => "配送区域模板名称必须",
			'area_ids.require'     => "省或市id集合必须",
		];
	protected $scene
		= [
			'add' => [
				'title',
				'area_ids',
			],

			'edit' => [
				'id',
				'title',
				'area_ids',
			],
			'del' => [
				'id',
			],

		];

}