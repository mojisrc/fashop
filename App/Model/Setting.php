<?php
/**
 * 设置数据模型
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

class Setting extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';
	/**
	 * 添加
	 * @datetime 2017-04-19 09:58:56
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addSetting($data = array()) {
		$data['create_time'] = time();
		$data['update_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2017-04-19 09:58:56
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addSettingAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-04-19 09:58:56
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editSetting($condition = array(), $data = array()) {
		return $this->update($data, $condition, true);
	}
	/**
	 * 删除
	 * @datetime 2017-04-19 09:58:56
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delSetting($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2017-04-19 09:58:56
	 * @author 韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getSettingCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取设置单条数据
	 * @datetime 2017-04-19 09:58:56
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array
	 */
	public function getSettingInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得设置列表
	 * @datetime 2017-04-19 09:58:56
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $group
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getSettingList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}
	/**
	 * 读取系统设置信息
	 *
	 * @param string $title 系统设置信息名称
	 * @return array 数组格式的返回结果
	 */
	public function getRowSetting($title) {
		$result = $this->where(array('title' => $title))->select();
		if (is_array($result) and is_array($result[0])) {
			return $result[0];
		}
		return false;
	}
	/**
	 * 读取系统设置列表
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getListSetting() {
		$result = $this->select();
		/**
		 * 整理
		 */
		if (is_array($result)) {
			$list_setting = array();
			foreach ($result as $k => $v) {
				$list_setting[$v['title']] = $v['value'];
			}
		}
		return $list_setting;
	}
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function updateSetting($param) {
		if (empty($param)) {
			return false;
		}
		if (is_array($param)) {
			foreach ($param as $k => $v) {
				$tmp             = array();
				$specialkeys_arr = array('statistics_code');
				$tmp['value']    = (in_array($k, $specialkeys_arr) ? htmlentities($v, ENT_QUOTES) : $v);
				$where           = " title = '" . $k . "'";
				$result          = $this->where($where)->update($tmp);
			}
			//清理缓存
			settingCache(0);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获取某个字段
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getSettingValue($condition, $field) {
		return $this->where($condition)->value($field);
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelSetting($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>
