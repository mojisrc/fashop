<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Admin;

use ezswoole\Validate;

class DistributionConfig extends Validate
{
    protected $rule
        = [
            'config' => 'require|CheckConfig',

        ];

    protected $message
        = [
            'config.require' => "参数必须",
        ];

    protected $scene
        = [
            'edit' => [
                'config',
            ],
        ];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function CheckKey($value, $rule, $data)
    {

        return $result;
    }


    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function CheckConfig($value, $rule, $data)
    {
        foreach ($value as $k => $v) {
            if (!in_array($v['key'], ['invite_reward', 'distributor_recruit', 'valid_term', 'protect_term', 'distributor_review', 'distributor_join_threshold', 'distributor_review_mode', 'distributor_write_message', 'distributor_purchase_commission', 'distributor_establish_customer_relation', 'settlement_mode', 'member_price_no_commission', 'commission_settlement_time', 'goods_set', 'commission_display_mode', 'goods_default_sort', 'distributor_name', 'share_icon'])) {
                return '参数错误';
            }
//            var_dump($v['value']['state']);
//            var_dump($v);

            //邀请奖励 state:0关闭  1开启
            if ($v['key'] == ['invite_reward']) {
                if (!isset($v['value']['state']) || in_array(intval($v['value']['state']), [0, 1])) {
                    return '邀请奖励参数信息错误';
                }
            }

            //分销员招募 state:0关闭  1开启
            if ($v['key'] == ['distributor_recruit']) {
                if (!isset($v['value']['state']) || in_array(intval($v['value']['state']), [0, 1])) {
                    return '分销员招募参数信息错误';
                }
            }

            //有效期设置 days:15十五天  32000永久
            if ($v['key'] == ['valid_term']) {
                if (!isset($v['value']['days']) || in_array(intval($v['value']['days']), [15, 32000])) {
                    return '有效期设置参数信息错误';
                }
            }

            //保护期设置 state:0关闭  1开启[days:15十五天  32000永久]
            if ($v['key'] == ['protect_term']) {
                if (!isset($v['value']['state']) || in_array(intval($v['value']['state']), [0, 1])) {
                    return '保护期设置参数信息错误';
                }
                if ($v['value']['state'] == 1) {
                    if ($v['value']['days'] <= 0 || $v['value']['days'] > 32000) {
                        return '保护期设置天数错误';
                    }
                }
            }

            //分销员审核 state:0关闭  1开启
            if ($v['key'] == ['distributor_review']) {
                if (!isset($v['value']['state']) || in_array(intval($v['value']['state']), [0, 1])) {
                    return '分销员审核参数信息错误';
                }
            }

            //分销员加入门槛
            if ($v['key'] == ['distributor_join_threshold']) {

            }

            //审核方式 automatic自动审核 artificial人工审核
            if ($v['key'] == ['distributor_review_mode']) {

            }

            //分销员填写信息
            if ($v['key'] == ['distributor_write_message']) {

            }

            //分销员自购分佣
            if ($v['key'] == ['distributor_purchase_commission']) {

            }

            //分销员建立客户关系
            if ($v['key'] == ['distributor_establish_customer_relation']) {

            }

            //结算方式
            if ($v['key'] == ['settlement_mode']) {

            }

            //会员价购买无佣金
            if ($v['key'] == ['member_price_no_commission']) {

            }

            //佣金结算时间
            if ($v['key'] == ['commission_settlement_time']) {

            }

            //商品设置
            if ($v['key'] == ['goods_set']) {

            }

            //佣金显示方式
            if ($v['key'] == ['commission_display_mode']) {

            }

            // 商品默认排序
            if ($v['key'] == ['goods_default_sort']) {

            }

            //分销员名称
            if ($v['key'] == ['distributor_name']) {

            }

            //分享图标
            if ($v['key'] == ['share_icon']) {

            }
        }
        return true;
    }


}