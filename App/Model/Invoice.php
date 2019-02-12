<?php
/**
 * 发票数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Model;


class Invoice extends Model {
	protected $softDelete = true;
	protected $createTime = true;

	public function getDefaultInvoiceInfo($condition = array()) {
		return $this->where($condition)->order('type asc')->find();
	}

	public function addInvoice($data = array()) {
		return $this->add($data);
	}

	public function editInvoice($condition = array(), $data = array()) {
		return $this->where($condition)->edit($data);
	}

	public function delInvoice($condition = array()) {
		return $this->where($condition)->del();
	}


	public function getInvoiceInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info;
	}
	public function getInvoiceList($condition = array(), $field = '*', $order = 'id desc', $page = [1,10]) {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ;
	}

}
?>