<?php
/**
 * 商家地址库模型
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

class Shipper extends Model{

    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addShipper($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addShipperAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editShipper($condition = array(), $data = array()) {
		$data['update_time'] = time();
		return $this->update($data, $condition, true);
	}
	/**
	 * 获取单条数据
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array | false
	 */
	public function getShipperInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获取总条数
	 * @method
	 * @param $condition
	 * @datetime 2017/12/21 0021 下午 2:47
	 * @author 沈旭
	 */
	public function getShipperCount($condition){
		return $this->where($condition)->count();
	}
	/**
	 * 获得列表
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getShipperList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 删除
	 *
	 * @param array $insert 数据
	 * @param string $table 表名
	 */
	public function delShipper($condition) {
		return $this->where($condition)->delete();
	}

	/**
	 * 软删除
	 *
	 * @param array $insert 数据
	 * @param string $table 表名
	 */
	public function softDelShipper($condition) {
        return $this->where($condition)->find()->delete();
	}

}