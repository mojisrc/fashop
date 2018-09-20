<?php
/**
 * 发票数据模型
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

class Invoice extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 取得买家默认发票
	 *
	 * @param array $condition
	 */
	public function getDefaultInvoiceInfo($condition = array()) {
		return $this->where($condition)->order('type asc')->find();
	}

	/**
	 * 添加
	 * @datetime 2017-04-19 09:56:04
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addInvoice($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2017-04-19 09:56:04
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addInvoiceAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-04-19 09:56:04
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editInvoice($condition = array(), $data = array()) {
		return $this->update($data, $condition, true);
	}
	/**
	 * 删除
	 * @datetime 2017-04-19 09:56:04
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delInvoice($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2017-04-19 09:56:04
	 * @author 韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getInvoiceCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取发票单条数据
	 * @datetime 2017-04-19 09:56:04
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array
	 */
	public function getInvoiceInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得发票列表
	 * @datetime 2017-04-19 09:56:04
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getInvoiceList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelInvoice($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>