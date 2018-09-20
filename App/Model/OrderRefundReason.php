<?php
namespace App\Model;
use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class OrderRefundReason extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';
	/**
	 * 退款\退款退货原因列表
	 * @param  [type] $condition [条件]
	 * @param  [type] $field     [字段]
	 * @param  [type] $order     [排序]
	 * @param  string $page      [分页]
	 * @return [type]            [退款\退款退货原因(线上+线下)列表数据]
	 */
	public function getOrderRefundReasonList($condition = array(), $field = '*', $order = 'id asc', $page = '1,20') {
		$data = $this->order($order)->where($condition)->field($field)->page($page)->select();
		return $data ? $data->toArray() : array();
	}

	/**
	 * 获得退款\退款退货原因信息
	 * @param  [type] $condition [description]
	 * @param  [type] $field     [description]
	 * @return [type]            [description]
	 */
	public function getOrderRefundReasonInfo($condition = array(), $field = '*') {
		$data = $this->where($condition)->field($field)->find();
		return $data ? $data->toArray() : array();
	}

	/**
	 * 修改退款\退款退货原因信息
	 * @param  [type] $update    [description]
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function updateOrderRefundReason($update, $condition) {
		return $this->where($condition)->update($update);
	}

	/**
	 * 退款\退款退货原因加入 单条数据
	 *
	 * @param array $insert 数据
	 * @param string $table 表名
	 */
	public function insertOrderRefundReason($insert) {
		return $this->insertGetId($insert);
	}

	/**
	 * 退款\退款退货原因加入 多条数据
	 *
	 * @param array $insert 数据
	 * @param string $table 表名
	 */
	public function insertAllOrderRefundReason($insert) {
		return $this->insertAll($insert);
	}

	/**
	 * 退款\退款退货原因删除
	 *
	 * @param array $insert 数据
	 * @param string $table 表名
	 */
	public function delOrderRefundReason($condition) {
		return $this->where($condition)->delete();
	}

	/**
	 * 退款\退款退货原因的id
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getOrderRefundReasonId($condition) {
		return $this->where($condition)->value('id');
	}

	/**
	 * 退款\退款退货原因的某个字段
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getOrderRefundReasonValue($condition, $field) {
		return $this->where($condition)->value($field);
	}
	/**
	 * 退款\退款退货原因的某个字段列
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getOrderRefundReasonColumn($condition, $field) {
		return $this->where($condition)->column($field);
	}

	/**
	 * 退款\退款退货原因的某个字段+1
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function setIncOrderRefundReason($condition, $field, $num) {
		return $this->where($condition)->setInc($field, $num);
	}
	/**
	 * 退款\退款退货原因的某个字段+1
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function setDecOrderRefundReason($condition, $field, $num) {
		return $this->where($condition)->setDec($field, $num);
	}
    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelOrderRefundReason($condition) {
        return $this->where($condition)->find()->delete();
    }
}
