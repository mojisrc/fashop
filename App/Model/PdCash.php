<?php
/**
 * 提现数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Model;
use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class PdCash extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';
	/**
	 * 取提现单信息总数
	 * @param array $condition
	 */
	public function getPdCashCount($condition = array()) {
		return $this->where($condition)->count();
	}

	/**
	 * 取得提现列表
	 * @param array $condition
	 * @param string $page
	 * @param string $field
	 * @param string $order
	 */
	public function getPdCashList($condition = array(), $field = '*', $order = '', $page = '1,20') {
		$data = $this->where($condition)->field($fields)->order($order)->page($page)->select();
		return $data ? $data->toArray() : $data;
	}

	/**
	 * 添加提现记录
	 * @param array $data
	 */
	public function addPdCash($data) {
		return $this->insertGetId($data);
	}

	/**
	 * 编辑提现记录
	 * @param array $data
	 * @param array $condition
	 */
	public function editPdCash($condition = array(), $data) {
		return $this->update($data, $condition, true);
	}

	/**
	 * 取得单条提现信息
	 * @param array $condition
	 * @param string $field
	 */
	public function getPdCashInfo($condition = array(), $field = '*') {
		$data = $this->where($condition)->field($field)->find();
		return $data ? $data->toArray() : $data;
	}

	/**
	 * 删除提现记录
	 * @param array $condition
	 */
	public function delPdCash($condition) {
		return $this->where($condition)->delete();
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelPdCash($condition) {
        return $this->where($condition)->find()->delete();
    }
}
