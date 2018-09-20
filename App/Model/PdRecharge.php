<?php
namespace App\Model;
use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class PdRecharge extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';
	/**
	 * 生成充值编号
	 * @return string
	 */
	public function makeSn($user_id = 0) {
		return mt_rand(10, 99)
		. sprintf('%010d', time() - 946656000)
		. sprintf('%03d', (float) microtime() * 1000)
		. sprintf('%03d', (int) $user_id % 1000);
	}
	/**
	 * 取得充值列表
	 * @param array $condition
	 * @param string $fields
	 * @param string $order
	 * @param string $page
	 */
	public function getPdRechargeList($condition = array(), $fields = '*', $order = '', $page = '1,20') {
		$data = $this->where($condition)->field($fields)->order($order)->page($page)->select();
		return $data ? $data->toArray() : $data;
	}

	/**
	 * 添加充值记录
	 * @param array $data
	 */
	public function addPdRecharge($data) {
		return $this->insertGetId($data);
	}

	/**
	 * 编辑
	 * @param array $data
	 * @param array $condition
	 */
	public function editPdRecharge($condition = array(), $data) {
		return $this->update($data, $condition, true);
	}

	/**
	 * 取得单条充值信息
	 * @param array $condition
	 * @param string $fields
	 */
	public function getPdRechargeInfo($condition = array(), $fields = '*') {
		$data = $this->where($condition)->field($fields)->find();
		return $data ? $data->toArray() : $data;
	}

	/**
	 * 取充值信息总数
	 * @param array $condition
	 */
	public function getPdRechargeCount($condition = array()) {
		return $this->where($condition)->count();
	}
	/**
	 * 删除充值记录
	 * @param array $condition
	 */
	public function delPdRecharge($condition) {
		return $this->where($condition)->delete();
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelPdRecharge($condition) {
        return $this->where($condition)->find()->delete();
    }


}
