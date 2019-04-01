<?php
/**
 * 分销
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/29
 * Time: 下午11:19
 *
 */

namespace App\Cron;

class Distribution
{

    /**
     * 商品设置
     */
    public static function autoAddGoods(): void
    {
        //商品设置 state:0创建商品后默认不参与推广  1创建商品后默认参与推广
        $distribution_config_model = new \App\Model\DistributionConfig;
        $goods_set                 = $distribution_config_model->getDistributionConfigInfo(['sign' => 'goods_set'], '*');

        if ($goods_set['content']['state'] == 1) {
            $is_show = 1;
        } else {
            $is_show = 0;
        }

        //结算方式 [distribution_ratio:佣金比例] [distribution_invite_ratio:邀请奖励佣金比例]
        $distribution_config_model = new \App\Model\DistributionConfig;
        $settlement_mode           = $distribution_config_model->getDistributionConfigInfo(['sign' => 'settlement_mode'], '*');

        $distribution_goods_model  = new \App\Model\DistributionGoods;
        $goods_model               = new \App\Model\Goods;
        $condition['is_on_sale']   = 1;
        $condition['stock']        = ['>', 0]; //查询库存大于0
        $condition['id']           = ['not in', $distribution_goods_model->column('goods_id')];
        $goods_ids               = $goods_model->where($condition)->column('id');
        if ($goods_ids) {
            foreach ($goods_ids as $key => $value) {
                $insert_data['goods_id']     = $value['id'];
                $insert_data['ratio']        = $settlement_mode['distribution_ratio'];
                $insert_data['invite_ratio'] = $settlement_mode['distribution_invite_ratio'];
                $insert_data['is_show']      = $is_show;
                $insert_data['type']         = 0;
                $insert_data['create_time']  = time();
                $insert_data['update_time']  = time();
                $distribution_goods_model->insertDistributionGoods($insert_data);
            }
        }
    }

}
