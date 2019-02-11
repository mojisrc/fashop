<?php
/**
 * 分销配置
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Model;

use ezswoole\Model;


class DistributionConfig extends Model {
    protected $softDelete = true;

    protected $type = [
        // ''      =>  'json',
    ];

    /**
     * 列表
     * @param   $condition
     * @param   $condition_str
     * @param   $field
     * @param   $order
     * @param   $page
     * @param   $group
     * @return
     */
    public function getDistributionConfigList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group='') {
        if($page == ''){
            $data = $this->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        }else{
            $data = $this->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();
        }
        return $data;
    }

    /**
     * 获得信息
     * @param   $condition
     * @param   $condition_str
     * @param   $field
     * @return
     */
    public function getDistributionConfigInfo($condition = array(), $condition_str = '', $field = '*') {
        $data = $this->where($condition)->where($condition_str)->field($field)->find();
        return $data;
    }

    /**
     * 获取某个字段
     * @param   $condition
     * @param   $condition_str
     * @return
     */
    public function getDistributionConfigValue($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param   $condition
     * @param   $condition_str
     * @return
     */
    public function getDistributionConfigColumn($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->column($field);
    }


    /**
     * 添加单条数据
     * @param   $insert
     */
    public function insertDistributionConfig($insert = array()) {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 添加多条数据
     * @param   $insert
     */
    public function insertAllDistributionConfig($insert = array()) {
        return $this->saveAll($insert);
    }

    /**
     * 修改信息
     * @param   $update
     * @param   $condition
     * @param   $condition_str
     * @return
     */
    public function updateDistributionConfig($condition = array(),$update = array()) {
        return $this->save($update,$condition);
    }
    /**
     * 修改多条数据
     * @param   $update
     */
    public function updateAllDistributionConfig($update = array()) {
        return $this->saveAll($update);
    }

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelDistributionConfig($condition = array()) {
        return $this->save(['delete_time'=>time()],$condition);
    }

}
