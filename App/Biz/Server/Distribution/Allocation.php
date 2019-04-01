<?php
/**
 * 分销
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Biz\Server\Distribution;

class Allocation
{
    public function getOrderDetail(array $data)
    {
        $user_id  = $data['user_id'];
        $goods_id = $data['goods_id'];

        $distribution_goods_model = new \App\Model\DistributionGoods;
        $distribution_goods       = $distribution_goods_model->getDistributionGoodsInfo(['goods_id' => $goods_id, 'is_show' => 1], '*');
        if (!$distribution_goods) {
            return [];
        }

        $distribution_config_model = new \App\Model\DistributionConfig;
        //关闭后 订单无法给与分销员邀请奖励。 下线分销员的底下客户下单我没邀请奖励 订单里能看见邀请人但邀请奖励是0
        $invite_reward = $distribution_config_model->getDistributionConfigInfo(['sign' => 'invite_reward'], '*');

        //有效期设置
        $valid_term = $distribution_config_model->getDistributionConfigInfo(['sign' => 'valid_term'], '*');

        $distributor_customer_model = new \App\Model\DistributorCustomer;
        $distributor_customer       = $distributor_customer_model->where(['user_id' => $user_id])->field('*')->order('id desc')->find();
        if (!$distributor_customer) {
            return [];
        } else {
            //是否失效判断
            if ($distributor_customer['state'] == 1) {
                if ($valid_term['content']['days'] == 15 && ($valid_term['content']['days'] - sprintf("%.2f", (time() - $distributor_customer['create_time']) / 86400)) <= 0) {//invalid_type 1
                    //有效期已过 动态显示客户失效
                    $distributor_customer['state']          = 0;
                    $distributor_customer['invalid_time']   = $distributor_customer['create_time'] + 86400 * 15;
                    $distributor_customer['invalid_reason'] = '推广有效期已过期';
                    $distributor_customer['invalid_type']   = 1;
                }
            }

            if ($distributor_customer['state'] == 0) {
                return [];
            }

            //存在有效分销员
            $distributor_model = new \App\Model\Distributor;
            $distributor       = $distributor_model->getDistributorInfo(['user_id' => $distributor_customer['distributor_user_id'], 'state' => 1, 'is_retreat' => 0], '*');
            if (!$distributor) {
                return [];
            }

            //order表字段
            $result['distribution_user_id']        = $distributor['user_id'];
            $result['distribution_invite_user_id'] = $distributor['inviter_id'];
            $result['distribution_settlement']     = 0;

            //order_goods表字段
            $result['distribution_ratio']        = $distribution_goods['ratio'];
            $result['distribution_invite_ratio'] = $distribution_goods['invite_ratio'];

            if ($invite_reward['content']['state'] == 0) {
                $result['distribution_invite_ratio'] = 0;
            }
        }
        return $result;
    }
}
