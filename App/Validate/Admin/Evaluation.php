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

class Evaluation extends Validate
{
	protected $rule
		= [
			'id'      => 'require',
			'reply_content'      => 'require',
		];
	protected $message
		= [
			'id.require' => "id必须",
			'reply_content.require'     => "回复内容必须",

		];
	protected $scene
		= [
			'reply' => [
				'id',
				'reply_content',
			],

			'display' => [
				'id',
			],

		];

}