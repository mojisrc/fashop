<?php
namespace App\Validate;
use ezswoole\Validate;

/**
 * 优惠券模板验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class VoucherTemplate extends Validate {

	protected $rule = [
		'id'       => 'require',
		'title'    => 'require',
		'total'    => 'require',
		'price'    => 'require',
		'end_date' => 'require',
		'limit'    => 'require',
		'desc'     => 'require',
	];

	protected $message = [
		'id.require'       => "id error",
		'title.require'    => "标题必填",
		'total.require'    => "总个数必填",
		'price.require'    => "价格必填",
		'end_date.require' => "结束时间必填",
		'limit.require'    => "人数限制必填",
		'desc.require'     => "描述必填",
	];
	protected $scene = [
		'add'  => [
			'title',
			'total',
			'price',
			'end_date',
			'limit',
			'desc',
		],
		'edit' => [
			'id',
			'title',
			'total',
			'price',
			'end_date',
			'limit',
			'desc',
		],
	];
}