<?php
/**
 * 发票业务逻辑
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

class Invoice extends Model {

	/**
	 * 获得为展示的默认发票信息
	 * @param int $user_id 用户id
	 * @datetime 2017-05-25T18:20:43+0800
	 * @author 韩文博
	 * todo 暂时不用
	 */
	public function getDefaultInvoiceInfoForShow($user_id) {
		// 输出默认使用的发票信息
		$invoice_info = model('Invoice')->getDefaultInvoiceInfo(array('user_id' => $user_id));
		if ($invoice_info['type'] == 2 && !$vat_deny) {
			$invoice_info['content'] = '增值税发票 ' . $invoice_info['company_name'] . ' ' . $invoice_info['company_register_address'] . ' ' . $invoice_info['company_register_address'];
		} elseif ($invoice_info['type'] == 2 && $vat_deny) {
			$invoice_info            = array();
			$invoice_info['content'] = '不需要发票';
		} elseif (!empty($invoice_info)) {
			$invoice_info['content'] = '普通发票 ' . $invoice_info['title'] . ' ' . $invoice_info['content'];
		} else {
			$invoice_info            = array();
			$invoice_info['content'] = '不需要发票';
		}
		return $invoice_info;
	}
}
