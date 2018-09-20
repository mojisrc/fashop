<?php
/**
 * 优惠券数据模型
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

class Coupon extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

    protected $type = [
        'partake'      =>  'json',
    ];

    /**
     * 列表
     * @param  [type] $condition [条件]
     * @param  [type] $field     [字段]
     * @param  [type] $order     [排序]
     * @param  string $page      [分页]
     * @return [type]            [列表数据]
     */
    public function getCouponList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20') {
        $data = $this->where($condition)->order($order)->field($field)->page($page)->select();
        return $data ? $data->toArray() : array();
    }

	/**
	 * 列表更多
	 * @param  [type] $condition [description]
	 * @param  [type] $field     [description]
	 * @param  [type] $order     [description]
	 * @param  string $page      [description]
	 * @return [type]            [description]
	 */
	public function getCouponMoreList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20') {
        $data = $this->alias('xx1')->join('__XX2__ xx2','xx1.id = xx2.xx1_id','LEFT')->where($condition)->order($order)->field($field)->page($page)->select();
        return $data ? $data->toArray() : array();
	}

    /**
     * 查询普通的数据和软删除的数据
     * @return [type] [description]
     */
    public function getWithTrashedCouponList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20'){
        $data = $this->withTrashed()->where($condition)->order($order)->field($field)->page($page)->select();  //查询普通的数据和软删除的数据
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的数据
     * @return [type] [description]
     */
    public function getOnlyTrashedCouponList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20'){
        $data = $this->onlyTrashed()->where($condition)->order($order)->field($field)->page($page)->select(); //只查询软删除的
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得数量
     * @param  [type] $condition [description]
     * @param  [type] $field     [description]
     * @return [type]            [description]
     */
    public function getCouponCount($condition = array()) {
        return $this->where($condition)->count();
    }

    /**
     * 获得数量
     * @param  [type] $condition [description]
     * @param  [type] $field     [description]
     * @return [type]            [description]
     */
    public function getDiscounMoretCount($condition = array()) {
        return $this->alias('xx1')->join('__XX2__ xx2','xx1.id = xx2.xx1_id','LEFT')->where($condition)->count();
    }

    /**
     * 获得信息
     * @param  [type] $condition [description]
     * @param  [type] $field     [description]
     * @return [type]            [description]
     */
    public function getCouponInfo($condition = array(), $field = '*') {
        $data = $this->where($condition)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 修改数据
     * @param  [type] $update    [description]
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function updateCoupon($condition = array(),$update = array()) {
        return $this->save($update,$condition);
    }

    /**
     * 修改多条数据
     *
     * @param array $update 数据
     */
    public function updateAllCoupon($update) {
        return $this->saveAll($update);
    }

    /**
     * 加入单条数据
     *
     * @param array $insert 数据
     */
    public function insertCoupon($insert) {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 加入多条数据
     *
     * @param array $insert 数据
     */
    public function insertAllCoupon($insert) {
        return $this->saveAll($insert);
    }

    /**
     * 删除
     *
     * @param array $insert 数据
     */
    public function delCoupon($condition) {
        return $this->where($condition)->delete();
    }

    /**
     * 获取的id
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getCouponId($condition) {
        return $this->where($condition)->value('id');
    }

    /**
     * 获取的某个字段
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getCouponValue($condition, $field) {
        return $this->where($condition)->value($field);
    }
    /**
     * 获取的某个字段列
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getCouponColumn($condition, $field) {
        return $this->where($condition)->column($field);
    }

    /**
     * 获取的某个字段+1
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function setIncCoupon($condition, $field, $num) {
        return $this->where($condition)->setInc($field, $num);
    }
    /**
     * 获取的某个字段+1
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function setDecCoupon($condition, $field, $num) {
        return $this->where($condition)->setDec($field, $num);
    }

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelCoupon($condition) {
        return $this->where($condition)->find()->delete();
    }

}
