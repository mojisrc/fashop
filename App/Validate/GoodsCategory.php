<?php
namespace App\Validate;

use ezswoole\Validate;

/**
 * 商品分类验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

class GoodsCategory extends Validate{
	//验证
	protected $rule = [
		'id'       => 'require',
		'name'     => 'require',
		'sorts'    => 'array|checkSorts',
	];
	//提示
	protected $message = [
		'id.require'       => 'ID必填',
		'name.require'     => '分类名称必填',
		'sorts.array'      => '排序数集合必须是数组',
	];
	//场景
	protected $scene = [
		'add' => [
			'name',
		],
		'edit' => [
			'id',
		],
		'sorts'=>[
			'sorts',
		]
	];

	/**
	 * 检测排序集合
	 * @param $value
	 * @param $rule
	 * @param $data
	 * @datetime 2017/12/20 0020 下午 4:14
	 * @author 沈旭
	 */
	protected function checkSorts($value,$rule,$data){
		if(empty($value) || !is_array($value) || count($value) < 1){
			return '排序数集合错误';
		}
		foreach ($value as $sorts){
			if(!isset($sorts['id'])){
				return '错误：排序id必填';
			}
			if(!isset($sorts['index'])){
				return '错误：排序数必填';
			}
		}
		return true;
	}
}