<?php
namespace App\Model;
use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class Corn extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 取单条任务信息
	 * @param array $condition
	 */
	public function getCronInfo($condition = array()) {
		return $this->where($condition)->find();
	}
	/**
	 * 任务队列列表
	 * @param array $condition
	 * @param number $limit
	 * @return array
	 */
	public function getCronList($condition, $limit = 10) {
		return $this->where($condition)->limit($limit)->select();
	}

	/**
	 * 保存任务队列
	 *
	 * @param array $insert
	 * @return array
	 */
	public function addCronAll($insert) {
		return $this->insertAll($insert);
	}

	/**
	 * 保存任务队列
	 *
	 * @param array $insert
	 * @return boolean
	 */
	public function addCron($insert) {
		$result = $this->allowField(true)->save($insert);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 删除任务队列
	 *
	 * @param array $condition
	 * @return array
	 */
	public function delCron($condition) {
		return $this->where($condition)->delete();
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelCron($condition) {
        return $this->where($condition)->find()->delete();
    }

}
