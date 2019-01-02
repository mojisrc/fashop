<?php
/**
 * 拼团活动商品模型
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

class GroupGoods extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

    protected $type = [
        'spec' => 'json',
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
    public function getGroupGoodsList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
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
    public function getGroupGoodsCount($condition = array(), $condition_str = '', $distinct = '')
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
    public function getGroupGoodsMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
        if ($page == '') {
            $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        } else {
            $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getGroupGoodsMoreCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->where($condition)->where($condition_str)->count();

        } else {
            return $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);
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
    public function getWithTrashedGroupGoodsList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
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
    public function getWithTrashedGroupGoodsCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->withTrashed()->where($condition)->where($condition_str)->count();

        } else {
            return $this->withTrashed()->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);

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
    public function getWithTrashedGroupGoodsMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
        if ($page == '') {
            $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->withTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        } else {
            $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->withTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getWithTrashedGroupGoodsMoreCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->withTrashed()->where($condition)->where($condition_str)->count();

        } else {
            return $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->withTrashed()->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);
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
    public function getOnlyTrashedGroupGoodsList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
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
    public function getOnlyTrashedGroupGoodsCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->onlyTrashed()->where($condition)->where($condition_str)->count();

        } else {
            return $this->onlyTrashed()->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);

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
    public function getOnlyTrashedGroupGoodsMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
        if ($page == '') {
            $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->onlyTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        } else {
            $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->onlyTrashed()->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getOnlyTrashedGroupGoodsMoreCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->onlyTrashed()->where($condition)->where($condition_str)->count();

        } else {
            return $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->onlyTrashed()->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);
        }
    }

    /**
     * 获得信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getGroupGoodsInfo($condition = array(), $condition_str = '', $field = '*')
    {
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
    public function getGroupGoodsExcludeInfo($condition = array(), $condition_str = '', $exclude = '')
    {
        $data = $this->where($condition)->where($condition_str)->field($exclude, true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getGroupGoodsMoreInfo($condition = array(), $condition_str = '', $field = '*')
    {
        $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得排除字段的信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getGroupGoodsExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*')
    {
        $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->where($condition)->where($condition_str)->field($exclude, true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getWithTrashedGroupGoodsInfo($condition = array(), $condition_str = '', $field = '*')
    {
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
    public function getWithTrashedGroupGoodsMoreInfo($condition = array(), $condition_str = '', $field = '*')
    {
        $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->withTrashed()->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 查询普通的数据和软删除的排除字段数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getWithTrashedGroupGoodsExcludeInfo($condition = array(), $condition_str = '', $exclude = '*')
    {
        $data = $this->withTrashed()->where($condition)->where($condition_str)->field($exclude, true)->find();
        return $data ? $data->toArray() : array();
    }


    /**
     * 查询普通的数据和软删除的排除字段数据信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getWithTrashedGroupGoodsExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*')
    {
        $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->withTrashed()->where($condition)->where($condition_str)->field($exclude, true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedGroupGoodsInfo($condition = array(), $condition_str = '', $field = '*')
    {
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
    public function getOnlyTrashedGroupGoodsMoreInfo($condition = array(), $condition_str = '', $field = '*')
    {
        $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->onlyTrashed()->where($condition)->where($condition_str)->field($field)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 只查询软删除的排除字段数据信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedGroupGoodsExcludeInfo($condition = array(), $condition_str = '', $exclude = '*')
    {
        $data = $this->onlyTrashed()->where($condition)->where($condition_str)->field($exclude, true)->find();
        return $data ? $data->toArray() : array();
    }


    /**
     * 只查询软删除的排除字段数据信息更多
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getOnlyTrashedGroupGoodsExcludeMoreInfo($condition = array(), $condition_str = '', $exclude = '*')
    {
        $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->onlyTrashed()->where($condition)->where($condition_str)->field($exclude, true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获取的id
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGroupGoodsId($condition = array(), $condition_str = '')
    {
        return $this->where($condition)->where($condition_str)->value('id');
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGroupGoodsValue($condition = array(), $condition_str = '', $field = 'id')
    {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGroupGoodsColumn($condition = array(), $condition_str = '', $field = 'id')
    {
        return $this->where($condition)->where($condition_str)->column($field);
    }

    /**
     * 获取某个字段列[指定索引]
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGroupGoodsIndexesColumn($condition = array(), $condition_str = '', $field = 'id', $indexes = 'id')
    {
        return $this->where($condition)->where($condition_str)->column($field, $indexes);
    }

    /**
     * 某个字段+1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function setIncGroupGoods($condition = array(), $condition_str = '', $field, $num = 1)
    {
        return $this->where($condition)->where($condition_str)->setInc($field, $num);
    }

    /**
     * 某个字段-1
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function setDecGroupGoods($condition = array(), $condition_str = '', $field, $num = 1)
    {
        return $this->where($condition)->where($condition_str)->setDec($field, $num);
    }

    /**
     * 添加单条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertGroupGoods($insert = array())
    {
        return $this->save($insert) ? $this->id : false;
    }

    /**
     * 添加多条数据
     * @param  [type] $insert           [添加数据]
     */
    public function insertAllGroupGoods($insert = array())
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
    public function updateGroupGoods($condition = array(), $update = array())
    {
        return $this->save($update, $condition);
    }

    /**
     * 修改多条数据
     * @param  [type] $update           [更新数据]
     */
    public function updateAllGroupGoods($update = array())
    {
        return $this->saveAll($update);
    }

    /**
     * 删除
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     */
    public function delGroupGoods($condition = array(), $condition_str = '')
    {
        return $this->where($condition)->where($condition_str)->delete();
    }

    /**
     * 软删除
     * @param    array $condition
     */
    public function softDelGroupGoods($condition = array(), $condition_str = '')
    {
        return $this->where($condition)->where($condition_str)->find()->delete();
    }

    /**
     * 获得商品sku数量
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $distinct         [去重]
     * @return [type]                   [数据]
     */
    public function getGoodsSkuMoreCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->alias('group_goods')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($condition)->where($condition_str)->count();

        } else {
            return $this->alias('group_goods')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);
        }
    }

    /**
     * 获得商品sku列表
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $field            [字段]
     * @param  [type] $order            [排序]
     * @param  [type] $page             [分页]
     * @param  [type] $group            [分组]
     * @return [type]                   [数据]
     */
    public function getGoodsSkuMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
        if ($page == '') {
            $data = $this->alias('group_goods')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        } else {
            $data = $this->alias('group_goods')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();
        }
        return $data ? $data->toArray() : array();
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
    public function getGroupGoodsSkuMoreList($condition = array(), $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '')
    {
        if ($page == '') {
            $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->group($group)->select();

        } else {
            $data = $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($condition)->where($condition_str)->order($order)->field($field)->page($page)->group($group)->select();

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
    public function getGroupGoodsSkuMoreCount($condition = array(), $condition_str = '', $distinct = '')
    {
        if ($distinct == '') {
            return $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($condition)->where($condition_str)->count();

        } else {
            return $this->alias('group_goods')->join('__GROUP__ group', 'group_goods.group_id = group.id', 'LEFT')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($condition)->where($condition_str)->count("DISTINCT " . $distinct);
        }
    }

    /**
     * 检查拼团商品
     * @param  [type] $group_id        [拼团活动id]
     * @return [type]                  [数据]
     */
    public function checkGoods($group_id = 0, $condition = [])
    {
        $goods_model = model('Goods');
        $goods_ids   = $this->getGroupGoodsColumn($condition, '', 'goods_id');
        if ($goods_ids) {
            $online_goods_ids = $goods_model->getGoodsColumn(['id' => ['in', $goods_ids], 'is_on_sale' => 1], 'id');

            //返回出现在第一个数组中但其他数组中没有的值 [将要删除的商品]
            $difference_goods_del_ids = array_diff($goods_ids, $online_goods_ids);

            if ($difference_goods_del_ids) {
                //删除活动下失效商品
                $group_goods_result = $this->delGroupGoods(['group_id' => $group_id, 'goods_id' => array('in', $difference_goods_del_ids)]);
                if (!$group_goods_result) {
                    return '删除活动下失效商品失败';
                }
            }
        }
        return true;
    }

    /**
     * 检查拼团商品sku
     * @param  [type] $group_id        [拼团活动id]
     * @return [type]                  [数据]
     */
    public function checkGoodsSku($group_id = 0, $condition = [])
    {
        $goods_sku_model = model('GoodsSku');
        $goods_sku_ids   = $this->getGroupGoodsColumn($condition, '', 'goods_sku_id');

        if ($goods_sku_ids) {
            $online_goods_sku_ids = $goods_sku_model->getGoodsSkuColumn(['id' => ['in', $goods_sku_ids]], 'id');

            //返回出现在第一个数组中但其他数组中没有的值 [将要删除的sku]
            $difference_goods_sku_del_ids = array_diff($goods_sku_ids, $online_goods_sku_ids);

            if ($difference_goods_sku_del_ids) {
                //删除活动下失效商品sku
                $group_goods_result = $this->delGroupGoods(['group_id' => $group_id, 'goods_sku_id' => array('in', $difference_goods_sku_del_ids)]);
                if (!$group_goods_result) {
                    return '删除活动下失效商品sku失败';
                }
            }
        }
        return true;
    }


}
