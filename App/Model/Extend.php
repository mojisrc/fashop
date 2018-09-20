<?php
/**
 * 物流数据模型
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

class Extend extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-07-24 22:47:42
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addExtend($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2017-07-24 22:47:42
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addExtendAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-07-24 22:47:42
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editExtend($condition = array(), $data = array()) {
		return $this->where($condition)->update($data);
	}
	/**
	 * 删除
	 * @datetime 2017-07-24 22:47:42
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delExtend($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2017-07-24 22:47:42
	 * @author 韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getExtendCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取物流单条数据
	 * @datetime 2017-07-24 22:47:42
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array | false
	 */
	public function getExtendInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得物流列表
	 * @datetime 2017-07-24 22:47:42
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getExtendList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}
    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelExtend($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>