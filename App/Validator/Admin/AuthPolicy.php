<?php

namespace App\Validator\Admin;

use ezswoole\Validator;
use hanwenbo\policy\Policy;

/**
 * 权限验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class AuthPolicy extends Validator
{

	protected $rule
		= [
			'name'       => 'require',
			'structure' => 'require|isPolicyStructure',
		];

	protected $scene
		= [
			'add'             => [
				'name','structure'
			],
			'edit'            => [
				'id',
				'name',
				'structure'
			],
			'info'             => [
				'id',
			],
			'del'             => [
				'id',
			],
		];


	protected function isPolicyStructure( $value)
	{
		$policy = new Policy;
		if($policy->verifyStructure($value)){
			return true;
		}else{
			return $policy->getErrMsg();
		}
	}
}