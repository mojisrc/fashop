<?php
/**
 * 分销商品
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

class DistributionGoods extends Model
{
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
    public function getDistributionGoodsList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
        if ($page == '') {
            $data = $this->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        } else {
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
    public function getDistributionGoodsCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->where($condition)->where($condition_str)->count();

        } else {
            return $this->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);

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
    public function getDistributionGoodsMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
        if ($page == '') {
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2', 'xxx1.xxx2_id = xxx2.id', 'LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        } else {
            $data = $this->alias('xxx1')->join('__XXX2__ xxx2', 'xxx1.xxx2_id = xxx2.id', 'LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getDistributionGoodsMoreCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->alias('xxx1')->join('__XXX2__ xxx2', 'xxx1.xxx2_id = xxx2.id', 'LEFT')->where($condition)->where($condition_str)->count();

        } else {
            return $this->alias('xxx1')->join('__XXX2__ xxx2', 'xxx1.xxx2_id = xxx2.id', 'LEFT')->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);
        }
    }

    /**
     * 获得信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getDistributionGoodsInfo($condition = array(), $condition_str = '', $field = '*')
    {
        $data = $this->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getDistributionGoodsMoreInfo($condition = array(), $condition_str = '', $field = '*')
    {
        $data = $this->alias('xxx1')->join('__XXX2__ xxx2', 'xxx1.xxx2_id = xxx2.id', 'LEFT')->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获取的id
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getDistributionGoodsId($condition = array(), $condition_str = '')
    {
        return $this->where($condition)->where($condition_str)->value('id');
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getDistributionGoodsValue($condition = array(), $condition_str = '', $field = 'id')
    {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getDistributionGoodsColumn($condition = array(), $condition_str = '', $field = 'id')
    {
        return $this->where($condition)->where($condition_str)->column($field);
    }

    /**
     * 获取某个字段列 以$indexes为索引
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getDistributionGoodsColumnField($condition = array(), $condition_str = '', $field = 'id', $indexes = 'id')
    {
        return $this->where($condition)->where($condition_str)->column($field, $indexes);
    }

    /**
     * 某个字段+1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public
    function setIncDistributionGoods($condition = array(), $condition_str = '', $field, $num = 1)
    {
        return $this->where($condition)->where($condition_str)->setInc($field, $num);
    }

    /**
     * 某个字段-1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public
    function setDecDistributionGoods($condition = array(), $condition_str = '', $field, $num = 1)
    {
        return $this->where($condition)->where($condition_str)->setDec($field, $num);
    }

    /**
     * 添加单条数据
     * @param  [type] $insert           [添加数据]
     */
    public
    function insertDistributionGoods($insert = array())
    {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 添加多条数据
     * @param  [type] $insert           [添加数据]
     */
    public
    function insertAllDistributionGoods($insert = array())
    {
        return $this->saveAll($insert);
    }

    /**
     * 修改信息
     * @param  [type] $update           [更新数据]
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public
    function updateDistributionGoods($condition = array(), $update = array())
    {
        return $this->save($update, $condition);
    }

    /**
     * 修改多条数据
     * @param  [type] $update           [更新数据]
     */
    public
    function updateAllDistributionGoods($update = array())
    {
        return $this->saveAll($update);
    }

    /**
     * 删除
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     */
    public
    function delDistributionGoods($condition = array(), $condition_str = '')
    {
        return $this->where($condition)->where($condition_str)->delete();
    }

    /**
     * 软删除
     * @param    array $condition
     */
    public
    function softDelDistributionGoods($condition = array())
    {
        return $this->save(['delete_time' => time()], $condition);
    }

}
