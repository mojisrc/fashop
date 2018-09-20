<?php
/**
 * 浏览记录数据模型
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

class Visit extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 添加一条浏览记录
	 * @param string  $model 表名
	 * @param int  $model_relation_id 表的关键
	 * @param int $user_id 用户id
	 * todo 获得当前设备，坐标，request信息
	 * @author 韩文博
	 */
	public function addVisit($model, $model_relation_id, $user_id = 0) {
		$data = array(
			'model'             => $model,
			'model_relation_id' => $model_relation_id,
			'create_time'       => time(),
			'user_id'           => $user_id,
			'ip'                => \App\Utils\Ip::getClientIp(),
		);
		$result = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
	}
	/**
	 * 添加多条
	 * @datetime 2017-05-29 11:36:57
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addVisitAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-05-29 11:36:57
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editVisit($condition = array(), $data = array()) {
		return $this->update($data, $condition, true);
	}
	/**
	 * 删除
	 * @datetime 2017-05-29 11:36:57
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delVisit($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2017-05-29 11:36:57
	 * @author 韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getVisitCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取浏览记录单条数据
	 * @datetime 2017-05-29 11:36:57
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array | false
	 */
	public function getVisitInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得浏览记录列表
	 * @datetime 2017-05-29 11:36:57
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getVisitList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelVisit($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>