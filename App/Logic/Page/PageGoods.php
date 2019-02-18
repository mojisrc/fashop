<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: sunquan
 * Date: 2018/8/29
 * Time: 上午10:23
 *
 */

namespace App\Logic\Page;


class PageGoods
{
    const goods_type = 'goods';
    const goods_list_type = 'goods_list';
    const goods_search_type = 'goods_search';
    const separator_type = 'separator';
    const auxiliary_blank_type = 'auxiliary_blank';
    const image_ads_type = 'image_ads';
    const image_nav_type = 'image_nav';
    const shop_window_type = 'shop_window';
    const video_type = 'video';
    const top_menu_type = 'top_menu';
    const title_type = 'title';
    const text_nav_type = 'text_nav';
    const actionLinkTypes = ['portal', 'page', 'goods', 'goods_category'];
    const goods_group_type = 'goods_group';

    function filterGoods(array $bodys)
    {

        foreach ($bodys as $key => $value) {
            if ($value['type'] == self::goods_type) {
                $goods_key[] = $key;
            }

            if ($value['type'] == self::goods_list_type) {
                $goods_list_key[] = $key;
            }
            if ($value['type'] == self::goods_group_type) {
                $goods_group_key[] = $key;
            }
        }

        if (isset($goods_key) && is_array($goods_key)) {
            foreach ($goods_key as $key => $value) {
                $goods_ids = $bodys[$value]['data'] ? array_column($bodys[$value]['data'], 'id') : [];
                if ($goods_ids) {
                    $goods_list            = \App\Model\Goods::init()->getGoodsList(['is_on_sale' => 1, 'id' => ['in', $goods_ids]], '*', 'sale_time desc', [1,10000]);
                    $bodys[$value]['data'] = $goods_list;
                } else {
                    $bodys[$value]['data'] = [];
                }
            }
        }

        if (isset($goods_list_key) && is_array($goods_list_key)) {
            foreach ($goods_list_key as $key => $value) {
                switch ($bodys[$value]['options']['goods_sort']) {
                    case 1:
                        $goods_list_order = 'sale_time desc';
                        break;
                    case 2:
                        $goods_list_order = 'sale_num desc';
                        break;
                    default:
                        $goods_list_order = 'create_time desc';
                        break;
                }
                $goods_list            = \App\Model\Goods::init()->getGoodsList(['is_on_sale' => 1], '*', $goods_list_order,  [1,$bodys[$value]['options']['goods_display_num']]);
                $bodys[$value]['data'] = $goods_list;
            }
        }

        //拼团商品
        if (isset($goods_group_key) && is_array($goods_group_key)) {

            $condition                     = [];
            $map                           = [];
            $time                          = time();
            $condition['group.start_time'] = ['<=', $time];
            $condition['group.end_time']   = ['>=', $time];
            $condition['group.is_show']    = 1;


            foreach ($goods_group_key as $key => $value) {
                switch ($bodys[$value]['options']['goods_sort']) {
                    case 1:
                        $goods_group_order = 'sale_time desc';
                        break;
                    case 2:
                        $goods_group_order = 'sale_num desc';
                        break;
                    default:
                        $goods_group_order = 'create_time desc';
                        break;
                }

                $goods_ids             = $bodys[$value]['data'] ? array_column($bodys[$value]['data'], 'id') : [];
                $bodys[$value]['data'] = [];

                //手动
                if ($bodys[$value]['options']['source_type'] == 'choose') {
                    if ($goods_ids) {
                        $condition['group_goods.goods_id'] = ['in', $goods_ids];
                        $group_goods                       = \App\Model\GroupGoods::init()->getGroupGoodsSkuMoreList($condition, '', 'group_goods.*', 'group_goods.id desc', '', '');
                        if ($group_goods) {
                            $goods_ids  = array_unique(array_column($group_goods, 'goods_id'));
                            $goods_list = \App\Model\Goods::init()->getGoodsList(['is_on_sale' => 1, 'id' => ['in', $goods_ids]], '*', $goods_group_order, '1,' . $bodys[$value]['options']['goods_display_num']);
                            if ($goods_list) {
                                $map['id']       = ['in', array_unique(array_column($group_goods, 'id'))];
                                $map['goods_id'] = ['in', array_unique(array_column($goods_list, 'id'))];
                                $min_group_price = \App\Model\GroupGoods::init()->where($map)->group('goods_id')->column('goods_id,min(group_price)');
                                foreach ($goods_list as $k => $v) {
                                    $goods_list[$k]['group_price'] = $min_group_price[$v['id']];
                                }
                            }
                            $bodys[$value]['data'] = $goods_list;
                        }
                    }
                } else {//自动
                    $group_goods = \App\Model\GroupGoods::init()->getGroupGoodsSkuMoreList($condition, '', 'group_goods.*', 'group_goods.id desc', '', '');
                    if ($group_goods) {
                        $goods_ids  = array_unique(array_column($group_goods, 'goods_id'));
                        $goods_list = \App\Model\Goods::getGoodsList(['is_on_sale' => 1, 'id' => ['in', $goods_ids]], '*', $goods_group_order, [1,$bodys[$value]['options']['goods_display_num']]);
                        if ($goods_list) {
                            $map['id']       = ['in', array_unique(array_column($group_goods, 'id'))];
                            $map['goods_id'] = ['in', array_unique(array_column($goods_list, 'id'))];
                            $min_group_price = \App\Model\GroupGoods::init()->where($map)->group('goods_id')->column('goods_id,min(group_price)');
                            foreach ($goods_list as $k => $v) {
                                $goods_list[$k]['group_price'] = $min_group_price[$v['id']];
                            }
                        }
                        $bodys[$value]['data'] = $goods_list;
                    }
                }
            }
        }

        return $bodys;
    }


}