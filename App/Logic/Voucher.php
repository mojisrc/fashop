<?php
/**
 * 优惠券逻辑层
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

class Voucher extends Model {
	/**
	 * 检查是否过期
	 * @param $phone 手机号
	 * @param $code 邀请码
	 * @param $model 模块名
	 */
	function setExpiredVoucherState() {
		// 更改过期的优惠券为过去(1-未用,2-已用,3-过期,4-收回)
		return model('Voucher')->editVoucher(['end_date' => ['lt', time()]], ['state' => 3]);
	}
	/**
	 * 添加优惠券
	 * @datetime 2017-06-21T02:16:16+0800
	 * @author 韩文博
	 * @param    int $coupon_template_id
	 * @param    int $owner_id
	 * @param    string $message_title
	 * @param    string $message_body
	 * @return array | int
	 */
	function addVoucher(int $coupon_template_id, int $owner_id, string $message_title, string $message_body) {
		$coupon_template_logic = model('VoucherTemplate', 'logic');
		$coupon_template_info  = model('VoucherTemplate')->getVoucherTemplateInfo(['id' => $coupon_template_id]);

		// 状态
		if ($coupon_template_info['state'] != 1) {
			return throw new \Exception('已经失效');
		}
		// 库存
		if ($coupon_template_info['surplus'] > 0) {

		} else {
			return throw new \Exception('优惠券发完了');
		}
		// 过期
		if ($coupon_template_info['end_date'] < time()) {
			return throw new \Exception('优惠券已过期');
		}
		// 判断用户领取的数量是否超过限制
		$coupon_model      = model('Voucher');
		$user_coupon_count = $coupon_model->getVoucherCount(['owner_id' => $owner_id]);
		if ($user_coupon_count >= $coupon_template_info['each_limit']) {
			return throw new \Exception('已经超出该优惠券每人可领张数');
		}

		$data                = [];
		$data['template_id'] = $coupon_template_info['id'];
		$data['title']       = $coupon_template_info['title'];
		$data['desc']        = $coupon_template_info['desc'];
		$data['start_date']  = $coupon_template_info['start_date'];
		$data['end_date']    = $coupon_template_info['end_date'];
		$data['price']       = $coupon_template_info['price'];
		$data['limit']       = $coupon_template_info['limit'];
		$data['state']       = 1;
		$data['owner_id']    = $owner_id;

		$relation_model_id = $coupon_model->addVoucher($data);
		// 添加消息通知，过滤外部字符变量
		$fliter[0] = ['[title]', '[start_date]', '[end_date]'];
		$fliter[1] = [$coupon_template_info['title'], date('Y-m-d H:i', $coupon_template_info['start_date']), date('Y-m-d H:i', $coupon_template_info['end_date'])];

		$message_title = str_replace($fliter[0], $fliter[1], $message_title);
		$message_body  = str_replace($fliter[0], $fliter[1], $message_body);

		model('Message', 'logic')->addMessage($owner_id, $message_title, $message_body, 'coupon_send', $relation_model_id, 4);

		return $relation_model_id;
	}
}
