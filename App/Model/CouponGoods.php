<?php
/**
 * 优惠券商品数据模型
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

class CouponGoods extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

    // protected $type = [
    //     ''      =>  'json',
    // ];

    /**
     * 列表
     * @param  [type] $condition [条件]
     * @param  [type] $field     [字段]
     * @param  [type] $order     [排序]
     * @param  string $page      [分页]
     * @return [type]            [列表数据]
     */
    public function getCouponGoodsList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20') {
        if($page == ''){
            $data = $this->where($condition)->order($order)->field($field)->select();

        }else{
            $data = $this->where($condition)->order($order)->field($field)->page($page)->select();

        }
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
	public function getCouponGoodsMoreList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20') {
        $data = $this->alias('coupon_goods')->join('__GOODS__ goods','coupon_goods.goods_id = goods.id','LEFT')->where($condition)->order($order)->field($field)->page($page)->select();
        return $data ? $data->toArray() : array();
	}

    /**
     * 查询普通的数据和软删除的数据
     * @return [type] [description]
     */
    public function getWithTrashedCouponGoodsList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20'){
        $data = $this->withTrashed()->where($condition)->order($order)->field($field)->page($page)->select();  //查询普通的数据和软删除的数据
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的数据
     * @return [type] [description]
     */
    public function getOnlyTrashedCouponGoodsList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20'){
        $data = $this->onlyTrashed()->where($condition)->order($order)->field($field)->page($page)->select(); //只查询软删除的
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得数量
     * @param  [type] $condition [description]
     * @param  [type] $field     [description]
     * @return [type]            [description]
     */
    public function getCouponGoodsCount($condition = array()) {
        return $this->where($condition)->count();
    }

    /**
     * 获得数量
     * @param  [type] $condition [description]
     * @param  [type] $field     [description]
     * @return [type]            [description]
     */
    public function getDiscounGoodsMoretCount($condition = array()) {
        return $this->alias('coupon_goods')->join('__GOODS__ goods','coupon_goods.goods_id = goods.id','LEFT')->where($condition)->count();
    }

    /**
     * 获得信息
     * @param  [type] $condition [description]
     * @param  [type] $field     [description]
     * @return [type]            [description]
     */
    public function getCouponGoodsInfo($condition = array(), $field = '*') {
        $data = $this->where($condition)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 修改信息
     * @param  [type] $update    [description]
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function updateCouponGoods($condition = array(),$update = array()) {
        return $this->save($update,$condition);
    }
    /**
     * 修改多条数据
     *
     * @param array $update 数据
     */
    public function updateAllCouponGoods($update) {
        return $this->saveAll($update);
    }

    /**
     * 加入单条数据
     *
     * @param array $insert 数据
     */
    public function insertCouponGoods($insert) {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 加入多条数据
     *
     * @param array $insert 数据
     */
    public function insertAllCouponGoods($insert) {
        return $this->saveAll($insert);
    }

    /**
     * 删除
     *
     * @param array $insert 数据
     */
    public function delCouponGoods($condition) {
        return $this->where($condition)->delete();
    }

    /**
     * 获取的id
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getCouponGoodsId($condition) {
        return $this->where($condition)->value('id');
    }

    /**
     * 获取的某个字段
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getCouponGoodsValue($condition, $field) {
        return $this->where($condition)->value($field);
    }
    /**
     * 获取的某个字段列
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getCouponGoodsColumn($condition, $field) {
        return $this->where($condition)->column($field);
    }

    /**
     * 获取的某个字段+1
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function setIncCouponGoods($condition, $field, $num) {
        return $this->where($condition)->setInc($field, $num);
    }
    /**
     * 获取的某个字段+1
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function setDecCouponGoods($condition, $field, $num) {
        return $this->where($condition)->setDec($field, $num);
    }

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelCouponGoods($condition) {
        return $this->where($condition)->find()->delete();
    }

    /**
     * 获得商品sku列表
     * @param  [type] $condition [description]
     * @param  [type] $field     [description]
     * @param  [type] $order     [description]
     * @param  string $page      [description]
     * @return [type]            [description]
     */
    public function getGoodsSkuMoreList($condition = array(), $field = '*', $order = 'id desc', $page = '1,20') {

        if($page == ''){
            $data = $this->alias('goods_sku')->join('__COUPON_GOODS__ coupon_goods','goods_sku.id = coupon_goods.goods_sku_id','LEFT')->where($condition)->order($order)->field($field)->select();

        }else{
            $data = $this->alias('goods_sku')->join('__COUPON_GOODS__ coupon_goods','goods_sku.id = coupon_goods.goods_sku_id','LEFT')->where($condition)->order($order)->field($field)->page($page)->select();

        }

        return $data ? $data->toArray() : array();
    }


    /**
     * 获得商品sku数量
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getGoodsSkuMoreCount($condition = array()) {
        return $this->alias('goods_sku')->join('__COUPON_GOODS__ coupon_goods','goods_sku.id = coupon_goods.goods_sku_id','LEFT')->where($condition)->count();

    }

}
