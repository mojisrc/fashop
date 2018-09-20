<?php
/**
 * 收获地址数据模型
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

class Address extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 取得买家默认收货地址
	 * @datetime 2017-04-18T22:57:31+0800
	 * @author 韩文博
	 * @param    array $condition
	 * @return   array
	 */
	public function getDefaultAddressInfo($condition = array(), $field = '') {
		$condition['is_default'] = 1;
		$info                    = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得某条收获地址的详情
	 * @datetime 2017-04-18T22:57:54+0800
	 * @author 韩文博
	 * @param    array $condition
	 * @return   array
	 */
	public function getAddressInfo($condition = array(), $field = '') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得收获地址列表
	 * @datetime 2017-04-19 09:56:04
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $group
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getAddressList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 新增地址
	 * @datetime 2017-04-18T22:59:13+0800
	 * @author 韩文博
	 * @param    array $data
	 * @return   integer pk
	 */
	public function addAddress($data = array()) {
		$result = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 更新地址信息
	 * @datetime 2017-04-18T23:01:19+0800
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editAddress($condition = array(), $data = array()) {
		return $this->where($condition)->update($data);
	}
	/**
	 * 删除地址
	 * @datetime 2017-04-18T23:02:06+0800
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delAddress($condition = array()) {
		return $this->where($condition)->delete();
	}

	/**
	 * 软删除
	 * @param    array  $condition
	 */
	public function softDelAddress($condition) {
        return $this->where($condition)->find()->delete();
	}
}
