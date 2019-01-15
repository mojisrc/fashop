<?php
/**
 * 商品所选分类
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

class GoodsCategoryIds extends Model {
    use SoftDelete;
    protected $deleteTime    = 'delete_time';
    protected $resultSetType = 'collection';

    protected $type = [
        // ''      =>  'json',
    ];

    /**
     * 列表
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @param  [type] $order            [排序]
     * @param  [type] $page             [分页]
     * @param  [type] $group            [分组]
     * @return [type]                   [数据]
     */
    public function getGoodsCategoryIdsList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
            $data = $this->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();
        }
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得数量
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $distinct         [去重]
     * @return [type]                   [数据]
     */
    public function getGoodsCategoryIdsCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->where($condition)->where($condition_str)->count();

        }else{
            return $this->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);

        }
    }

    /**
     * 获得信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getGoodsCategoryIdsInfo($condition = array(), $condition_str = '', $field = '*') {
        $data = $this->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获取的id
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGoodsCategoryIdsId($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->value('id');
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGoodsCategoryIdsValue($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGoodsCategoryIdsColumn($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->column($field);
    }

    /**
     * 添加单条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertGoodsCategoryIds($insert = array()) {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 添加多条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertAllGoodsCategoryIds($insert = array()) {
        return $this->saveAll($insert);
    }

    /**
     * 修改信息
     * @param  [type] $update           [更新数据]
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function updateGoodsCategoryIds($condition = array(),$update = array()) {
        return $this->save($update,$condition);
    }
    /**
     * 修改多条数据
     * @param  [type] $update           [更新数据]
     */
    public function updateAllGoodsCategoryIds($update = array()) {
        return $this->saveAll($update);
    }

    /**
     * 删除
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     */
    public function delGoodsCategoryIds($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->delete();
    }

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelGoodsCategoryIds($condition = array()) {
        return $this->save(['delete_time'=>time()],$condition);
    }

}
