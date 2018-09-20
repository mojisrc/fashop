<?php
/**
 * 优惠券模板逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Logic;
use ezswoole\Model;
use EasySwoole\Core\Component\Di;

class VoucherTemplate extends Model {

	/**
	 * 获得可用优惠券模板的基础条件
	 * @method     GET
	 * @datetime 2017-06-21T02:01:40+0800
	 * @author 韩文博
	 * @return   [type]
	 */
	public function getAvailableTemplateBasicCondition() {
		return [
			'state'    => 1,
			'surplus'  => ['gt', 0],
			'end_date' => ['lt', time()],
		];
	}
}
