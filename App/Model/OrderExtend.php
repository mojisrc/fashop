<?php
/**
 * 订单模型
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

class OrderExtend extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

    protected $type = [
         'reciver_info'      =>  'json',
         'invoice_info'      =>  'json',

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
    public function getOrderExtendList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
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
    public function getOrderExtendCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->where($condition)->where($condition_str)->count();

        }else{
            return $this->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);

        }
    }

    /**
     * 列表更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @param  [type] $order            [排序]
     * @param  [type] $page             [分页]
     * @param  [type] $group            [分组]
     * @return [type]                   [数据]
     */
    public function getOrderExtendMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getOrderExtendMoreCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->where($condition)->where($condition_str)->count();

        }else{
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);
        }
    }

    /**
     * 查询普通的数据和软删除的数据
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @param  [type] $order            [排序]
     * @param  [type] $page             [分页]
     * @param  [type] $group            [分组]
     * @return [type]                   [数据]
     */
    public function getWithTrashedOrderExtendList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group=''){
        $data = $this->withTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的数据的数量
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $distinct         [去重]
     * @return [type]                   [数据]
     */
    public function getWithTrashedOrderExtendCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->withTrashed()->where($condition)->where($condition_str)->count();

        }else{
            return $this->withTrashed()->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);

        }
    }

    /**
     * 查询普通的数据和软删除的数据更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @param  [type] $order            [排序]
     * @param  [type] $page             [分页]
     * @param  [type] $group            [分组]
     * @return [type]                   [数据]
     */
    public function getWithTrashedOrderExtendMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->withTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->withTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

        }
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的数据的数量
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $distinct         [去重]
     * @return [type]                   [数据]
     */
    public function getWithTrashedOrderExtendMoreCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->withTrashed()->where($condition)->where($condition_str)->count();

        }else{
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->withTrashed()->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);
        }
    }

    /**
     * 只查询软删除的数据
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @param  [type] $order            [排序]
     * @param  [type] $page             [分页]
     * @param  [type] $group            [分组]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedOrderExtendList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group=''){
        $data = $this->onlyTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的数据的数量
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $distinct         [去重]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedOrderExtendCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->onlyTrashed()->where($condition)->where($condition_str)->count();

        }else{
            return $this->onlyTrashed()->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);

        }
    }

    /**
     * 只查询软删除的数据更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @param  [type] $order            [排序]
     * @param  [type] $page             [分页]
     * @param  [type] $group            [分组]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedOrderExtendMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

        }
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的数据的数量
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $distinct         [去重]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedOrderExtendMoreCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->count();

        }else{
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);
        }
    }

    /**
     * 获得信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getOrderExtendInfo($condition = array(), $condition_str = '', $field = '*') {
        $data = $this->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得排除字段的信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getOrderExtendExcludeInfo($condition = array(), $condition_str = '', $exclude = '') {
        $data = $this->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getOrderExtendMoreInfo($condition = array(), $condition_str = '', $field = '*') {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得排除字段的信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getOrderExtendExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getWithTrashedOrderExtendInfo($condition = array(), $condition_str = '', $field = '*'){
        $data = $this->withTrashed()->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的数据信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getWithTrashedOrderExtendMoreInfo($condition = array(), $condition_str = '', $field = '*') {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->withTrashed()->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的排除字段数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getWithTrashedOrderExtendExcludeInfo($condition = array(), $condition_str = '', $exclude = '*'){
        $data = $this->withTrashed()->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }


    /**
     * 查询普通的数据和软删除的排除字段数据信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getWithTrashedOrderExtendExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->withTrashed()->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedOrderExtendInfo($condition = array(), $condition_str = '', $field = '*'){
        $data = $this->onlyTrashed()->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的数据信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedOrderExtendMoreInfo($condition = array(), $condition_str = '', $field = '*') {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的排除字段数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedOrderExtendExcludeInfo($condition = array(), $condition_str = '', $exclude = '*'){
        $data = $this->onlyTrashed()->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }


    /**
     * 只查询软删除的排除字段数据信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedOrderExtendExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.id = xxx2.xxx1_id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获取的id
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getOrderExtendId($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->value('id');
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getOrderExtendValue($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getOrderExtendColumn($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->column($field);
    }

    /**
     * 某个字段+1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function setIncOrderExtend($condition = array(), $condition_str = '', $field, $num = 1) {
        return $this->where($condition)->where($condition_str)->setInc($field, $num);
    }

    /**
     * 某个字段-1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function setDecOrderExtend($condition = array(), $condition_str = '', $field, $num = 1) {
        return $this->where($condition)->where($condition_str)->setDec($field, $num);
    }

    /**
     * 添加单条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertOrderExtend($insert = array()) {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 添加多条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertAllOrderExtend($insert = array()) {
        return $this->saveAll($insert);
    }

    /**
     * 修改信息
     * @param  [type] $update           [更新数据]
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function updateOrderExtend($condition = array(),$update = array()) {
        return $this->save($update,$condition);
    }
    /**
     * 修改多条数据
     * @param  [type] $update           [更新数据]
     */
    public function updateAllOrderExtend($update = array()) {
        return $this->saveAll($update);
    }

    /**
     * 删除
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     */
    public function delOrderExtend($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->delete();
    }

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelOrderExtend($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->find()->delete();
    }

}
