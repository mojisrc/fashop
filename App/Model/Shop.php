<?php
/**
 * 店铺数据模型
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

class Shop extends Model {
	/**
	 * 添加
	 * @datetime 2018-01-29 23:16:14
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addShop($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2018-01-29 23:16:14
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addShopAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2018-01-29 23:16:14
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editShop($condition = array(), $data = array()) {
		return $this->update($data, $condition, true);
	}
	/**
	 * 删除
	 * @datetime 2018-01-29 23:16:14
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delShop($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2018-01-29 23:16:14
	 * @author 韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getShopCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取店铺单条数据
	 * @datetime 2018-01-29 23:16:14
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array | false
	 */
	public function getShopInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得店铺列表
	 * @datetime 2018-01-29 23:16:14
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getShopList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelShop($condition) {
        return $this->where($condition)->find()->delete();
    }

   	/**
	 * 获取id
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getShopId($condition) {
		return $this->where($condition)->value('id');
	}

	/**
	 * 获取某个字段
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getShopValue($condition, $field) {
		return $this->where($condition)->value($field);
	}
	/**
	 * 获取某个字段列
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getShopColumn($condition, $field) {
		return $this->where($condition)->column($field);
	}

}
?>