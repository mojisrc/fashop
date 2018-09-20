<?php

namespace App\Validate;

use ezswoole\Validate;


/**
 * 商品规格验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class GoodsSpecValue extends Validate
{
	protected $rule
		= [
			'id'      => 'require',
			'spec_id' => 'require',
			'name'    => 'require|checkName',
		];
	protected $message
		= [
			'id.require'      => '规格值ID必填',
			'spec_id.require' => '规格ID必填',
			'name.require'    => '规格值名称必填',
		];
	protected $scene
		= [
			'values' => [
				'spec_id',
			],
			'add'    => [
				'spec_id',
				'name',
			],
			'edit'   => [
				'id',
			],
		];

	protected function checkName( $value, $rule, $data )
	{
		$find = \ezswoole\Db::name( 'GoodsSpecValue' )->where( [
			'spec_id' => $data['spec_id'],
			'name'    => $value,
		] )->find();
		if( $find ){
			return "名字重复";
		} else{
			return true;
		}
	}
}