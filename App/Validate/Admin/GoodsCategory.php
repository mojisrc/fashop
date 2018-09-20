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

class GoodsCategory extends Validate
{
	protected $rule
		= [
			'id'    => 'require',
			'name'  => 'require',
			'icon'  => 'require',
			'sorts' => 'require|array|checkSorts',
		];
	protected $message
		= [
			'id.require'    => "id必须",
			'name.require'  => "分类名称必须",
			'icon.require'  => "分类图必须",
			'sorts.require' => "序号必须",

		];
	protected $scene
		= [
			'add' => [
				'name',
			],

			'edit' => [
				'id',
				'name',
			],
			'del'  => [
				'id',
			],
			'info' => [
				'id',
			],
			'sort' => [
				'sorts',
			],
		];

	protected function checkSorts( $value, $rule, $data )
	{
		if( empty( $value ) ){
			return "排序不能为空";
		}
		foreach( $value as $item ){
			if( !isset( $item['id'] ) || !isset( $item['index'] ) ){
				return "排序格式错误";
			}
		}
		return true;
	}
}