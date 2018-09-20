<?php
/**
 * 短信数据模型
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

class Sms extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';
	/**
	 * 添加
	 * @datetime 2017-04-19 09:59:48
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addSms($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2017-04-19 09:59:48
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addSmsAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-04-19 09:59:48
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editSms($condition = array(), $data = array()) {
		return $this->update($data, $condition, true);
	}
	/**
	 * 删除
	 * @datetime 2017-04-19 09:59:48
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delSms($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2017-04-19 09:59:48
	 * @author 韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getSmsCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取短信单条数据
	 * @datetime 2017-04-19 09:59:48
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @param string $order 排序
	 * @return array | false
	 */
	public function getSmsInfo($condition = array(), $field = '*', $order = 'id desc') {
		$info = $this->where($condition)->field($field)->order($order)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得短信列表
	 * @datetime 2017-04-19 09:59:48
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $group
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getSmsList($condition = array(), $field = '*', $group = '', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}
    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelSms($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>