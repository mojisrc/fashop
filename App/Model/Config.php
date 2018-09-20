<?php
/**
 * 公用配置数据模型
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

class Config extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-04-19 09:48:42
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addConfig($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 修改
	 * @datetime 2017-04-19 09:48:42
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editConfig($condition = array(), $data = array()) {
		return $this->update($data, $condition, true);
	}
	/**
	 * 删除
	 * @datetime 2017-04-19 09:48:42
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delConfig($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2017-04-19 09:48:42
	 * @author 韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getConfigCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取公用配置单条数据
	 * @datetime 2017-04-19 09:48:42
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array
	 */
	public function getConfigInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得公用配置列表
	 * @datetime 2017-04-19 09:48:42
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $group
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getConfigList($condition = array(), $field = '*', $group = '', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelConfig($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>