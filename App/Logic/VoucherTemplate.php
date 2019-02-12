<?php
/**
 * 优惠券模板逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Logic;
use ezswoole\Model;


class VoucherTemplate extends Model {

	/**
	 * 获得可用优惠券模板的基础条件
	 * @method     GET
	 * @datetime 2017-06-21T02:01:40+0800
	 * @return
	 */
	public function getAvailableTemplateBasicCondition() {
		return [
			'state'    => 1,
			'surplus'  => ['gt', 0],
			'end_date' => ['lt', time()],
		];
	}
}
