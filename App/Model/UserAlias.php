<?php
/**
 * 用户ID别名模型
 */
namespace App\Model;

use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class UserAlias extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
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
    public function getUserAliasList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
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
    public function getUserAliasCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getUserAliasMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
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
    public function getUserAliasMoreCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getWithTrashedUserAliasList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group=''){
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
    public function getWithTrashedUserAliasCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getWithTrashedUserAliasMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
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
    public function getWithTrashedUserAliasMoreCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getOnlyTrashedUserAliasList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group=''){
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
    public function getOnlyTrashedUserAliasCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getOnlyTrashedUserAliasMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
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
    public function getOnlyTrashedUserAliasMoreCount($condition = array(), $condition_str = '', $distinct = '') {
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
    public function getUserAliasInfo($condition = array(), $condition_str = '', $field = '*') {
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
    public function getUserAliasExcludeInfo($condition = array(), $condition_str = '', $exclude = '') {
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
    public function getUserAliasMoreInfo($condition = array(), $condition_str = '', $field = '*') {
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
    public function getUserAliasExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
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
    public function getWithTrashedUserAliasInfo($condition = array(), $condition_str = '', $field = '*'){
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
    public function getWithTrashedUserAliasMoreInfo($condition = array(), $condition_str = '', $field = '*') {
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
    public function getWithTrashedUserAliasExcludeInfo($condition = array(), $condition_str = '', $exclude = '*'){
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
    public function getWithTrashedUserAliasExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
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
    public function getOnlyTrashedUserAliasInfo($condition = array(), $condition_str = '', $field = '*'){
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
    public function getOnlyTrashedUserAliasMoreInfo($condition = array(), $condition_str = '', $field = '*') {
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
    public function getOnlyTrashedUserAliasExcludeInfo($condition = array(), $condition_str = '', $exclude = '*'){
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
    public function getOnlyTrashedUserAliasExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*') {
      $data = $this->alias('xxx1')->join('__XXX2__ xxx2','xxx1.xxx2_id = xxx2.id','LEFT')->onlyTrashed()->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获取的id
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getUserAliasId($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->value('id');
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getUserAliasValue($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getUserAliasColumn($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->column($field);
    }

    /**
     * 某个字段+1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function setIncUserAlias($condition = array(), $condition_str = '', $field, $num = 1) {
        return $this->where($condition)->where($condition_str)->setInc($field, $num);
    }

    /**
     * 某个字段-1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function setDecUserAlias($condition = array(), $condition_str = '', $field, $num = 1) {
        return $this->where($condition)->where($condition_str)->setDec($field, $num);
    }

    /**
     * 添加单条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertUserAlias($insert = array()) {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 添加多条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertAllUserAlias($insert = array()) {
        return $this->saveAll($insert);
    }

    /**
     * 修改信息
     * @param  [type] $update           [更新数据]
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function updateUserAlias($condition = array(),$update = array()) {
        return $this->save($update,$condition);
    }
    /**
     * 修改多条数据
     * @param  [type] $update           [更新数据]
     */
    public function updateAllUserAlias($update = array()) {
        return $this->saveAll($update);
    }

    /**
     * 删除
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     */
    public function delUserAlias($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->delete();
    }

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelUserAlias($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->find()->delete();
    }

}
