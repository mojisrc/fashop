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
	const goods_type      = 'goods';
	const goods_list_type = 'goods';
	const goods_search_type = 'goods_search';
	function filterGoods( array $bodys )
	{

        foreach ($bodys as $key => $value) {
            if($value['type'] == 'goods'){
                $goods_key[]      = $key;
            }

            if($value['type'] == 'goods_list'){
                $goods_list_key[] = $key;
            }
        }

        $goods_model = model('Goods');

        if(isset($goods_key) && is_array($goods_key)){
            foreach ($goods_key as $key => $value) {
                $goods_ids = $bodys[$value]['data'] ? array_column($bodys[$value]['data'], 'id') : [];
                if($goods_ids){
                    $goods_list = $goods_model->getGoodsList(['is_on_sale' => 1, 'id' => ['in', $goods_ids]], '*', 'sale_time desc', '1,10000');
                    $bodys[$value]['data'] = $goods_list;
                }else{
                    $bodys[$value]['data'] = [];
                }
            }
        }

        if(isset($goods_list_key) && is_array($goods_list_key)){
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
                $goods_list            = $goods_model->getGoodsList(['is_on_sale' => 1], '*', $goods_list_order, '1,' . $bodys[$value]['options']['goods_display_num']);
                $bodys[$value]['data'] = $goods_list;
            }

        }

        return $bodys;
	}


}