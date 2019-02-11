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
use ezswoole\Model;

class Invoice extends Model {
	protected $softDelete = true;
	protected $createTime = true;


	/**
	 * 取得买家默认发票
	 * @param array $condition
	 */
	public function getDefaultInvoiceInfo($condition = array()) {
		return $this->where($condition)->order('type asc')->find();
	}

	/**
	 * 添加
	 * @param  array $data
	 * @return int pk
	 */
	public function addInvoice($data = array()) {
		$data['create_time'] = time();
		return $this->add($data);
	}
	/**
	 * 添加多条
	 * @param array $data
	 * @return boolean
	 */
	public function addInvoiceAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editInvoice($condition = array(), $data = array()) {
		return $this->where($condition)->edit($data);
	}
	/**
	 * 删除
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delInvoice($condition = array()) {
		return $this->where($condition)->del();
	}
	/**
	 * 计算数量
	 * @param array $condition 条件
	 * @return int
	 */
	public function getInvoiceCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取发票单条数据
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array
	 */
	public function getInvoiceInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info;
	}
	/**
	 * 获得发票列表
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getInvoiceList($condition = array(), $field = '*', $order = '', $page = [1,10]) {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ;
	}

}
?>