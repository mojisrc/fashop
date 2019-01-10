<?php
/**
 * 拼团活动模型
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

class Group extends Model {
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
    public function getGroupList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
            $data = $this->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();
        }

        if(!$data ){
            return [];
        }else{
            $data = $data->toArray();

            foreach ($data as $key => $value) {
                $data[$key] = $this->stateDesc($value);
            }

        }
        return $data;

    }

    /**
     * 获得数量
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $distinct         [去重]
     * @return [type]                   [数据]
     */
    public function getGroupCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getGroupMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getGroupMoreCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->where($condition)->where($condition_str)->count();

        }else{
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);
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
    public function getWithTrashedGroupList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group=''){
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
    public function getWithTrashedGroupCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getWithTrashedGroupMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->withTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->withTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getWithTrashedGroupMoreCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->withTrashed()->where($condition)->where($condition_str)->count();

        }else{
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->withTrashed()->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);
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
    public function getOnlyTrashedGroupList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group=''){
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
    public function getOnlyTrashedGroupCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getOnlyTrashedGroupMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getOnlyTrashedGroupMoreCount($condition = array(), $condition_str = '', $distinct = '') {
        if($distinct == ''){
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->count();

        }else{
            return $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->count("DISTINCT ".$distinct);
        }
    }

    /**
     * 获得信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getGroupInfo($condition = array(), $condition_str = '', $field = '*') {
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
    public function getGroupExcludeInfo($condition = array(), $condition_str = '', $exclude = '') {
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
    public function getGroupMoreInfo($condition = array(), $condition_str = '', $field = '*') {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得排除字段的信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getGroupExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getWithTrashedGroupInfo($condition = array(), $condition_str = '', $field = '*'){
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
    public function getWithTrashedGroupMoreInfo($condition = array(), $condition_str = '', $field = '*') {
      $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->withTrashed()->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的排除字段数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getWithTrashedGroupExcludeInfo($condition = array(), $condition_str = '', $exclude = '*'){
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
    public function getWithTrashedGroupExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
      $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->withTrashed()->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedGroupInfo($condition = array(), $condition_str = '', $field = '*'){
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
    public function getOnlyTrashedGroupMoreInfo($condition = array(), $condition_str = '', $field = '*') {
      $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的排除字段数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedGroupExcludeInfo($condition = array(), $condition_str = '', $exclude = '*'){
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
    public function getOnlyTrashedGroupExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
      $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获取的id
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGroupId($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->value('id');
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGroupValue($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGroupColumn($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->column($field);
    }

    /**
     * 某个字段+1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function setIncGroup($condition = array(), $condition_str = '', $field, $num = 1) {
        return $this->where($condition)->where($condition_str)->setInc($field, $num);
    }

    /**
     * 某个字段-1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function setDecGroup($condition = array(), $condition_str = '', $field, $num = 1) {
        return $this->where($condition)->where($condition_str)->setDec($field, $num);
    }

    /**
     * 添加单条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertGroup($insert = array()) {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 添加多条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertAllGroup($insert = array()) {
        return $this->saveAll($insert);
    }

    /**
     * 修改信息
     * @param  [type] $update           [更新数据]
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function updateGroup($condition = array(),$update = array()) {
        return $this->save($update,$condition);
    }
    /**
     * 修改多条数据
     * @param  [type] $update           [更新数据]
     */
    public function updateAllGroup($update = array()) {
        return $this->saveAll($update);
    }

    /**
     * 删除
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     */
    public function delGroup($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->delete();
    }

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelGroup($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->find()->delete();
    }

    /**
     * 状态描述
     * @param  [type] $update           [更新数据]
     */
    public function stateDesc($data) {

        if ( time() >= $data['start_time'] && time() <= $data['end_time'] ) {
            $state_desc   = '进行中';
        } elseif ( time() < $data['start_time'] ) {
            $state_desc = '未开始';

        } elseif ( time() > $data['end_time'] ) {
            $state_desc = '已结束';
        }

        if($data['is_show']==0){
            $state_desc = '已失效';
        }
        $data['state_desc']   = $state_desc;
        return $data;
    }

}
