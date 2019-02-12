<?php
/**
 * 拼团业务逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

class Group
{

    public function __construct(array $options)
    {
        if (isset($options['goods_id'])) {
            $this->goods_id = $options['goods_id'];
        }

        if (isset($options['goods_skus'])) {
            $this->goods_skus = $options['goods_skus'];
        }
    }

    /**
     * 筛选商品是否为拼团商品 是则过滤字段
     * @return bool
     */
    public function haveGoods()
    {
        $group_model           = model('Group');
        $group_goods_model     = model('GroupGoods');
        $condition             = [];
        $condition['goods_id'] = $this->goods_id;
        $group_ids             = \App\Model\GroupGoods::getGroupGoodsColumn($condition, '', 'group_id');

        if (!$group_ids) {
            return false;
        } else {
            $nonredundant_group_ids = array_unique($group_ids);//去掉重复
            $map                    = [];
            $map['id']              = ['in', $nonredundant_group_ids];
            $map['end_time']        = ['<', time()];
            $map['is_show']         = 0;
            $group_count            = \App\Model\Group::getGroupCount($map);
            if ($group_count == count($nonredundant_group_ids)) { //所有查出来的拼团都是无效的
                return false;
            }
        }
        return true;
    }


    /**
     * 筛选商品是否为拼团商品 是则过滤字段
     * @return bool
     */
    public function filteGoodsSku()
    {
        //过滤商品字段 goods_skus goods_sku表信息，sku_list goods表sku_list字段
        $sku_ids    = array_column($this->goods_skus, 'id');
        $goods_skus = \App\Model\GoodsSku::getGoodsSkuList(['id' => ['in', $sku_ids]], 'id,price,stock,code,spec,weight', 'id asc', [1,100]);
        if (count($sku_ids) != count($goods_skus)) {
            return false;
        }

        $update_skus = [];

        foreach ($this->goods_skus as $key => $value) {
            $update_skus['goods_skus'][$key]['id']    = $value['id'];
            $update_skus['goods_skus'][$key]['stock'] = $value['stock'];
            $update_skus['goods_skus'][$key]['code']  = $value['code'];

            foreach ($goods_skus as $k => $v) {
                if ($v['id'] == $value['id']) {
                    $goods_skus[$k]['stock'] = $value['stock'];
                    $goods_skus[$k]['code']  = $value['code'];
                }
            }

        }
        foreach ($goods_skus as $key => $value) {
            unset($goods_skus[$key]['id']);
        }
        $update_skus['sku_list'] = $goods_skus;
        return $update_skus;
    }

}
