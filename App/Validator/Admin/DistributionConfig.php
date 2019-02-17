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

namespace App\Validator\Admin;

use ezswoole\Validator;

class DistributionConfig extends Validator
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
    protected function CheckConfig($value, $rule, $data)
    {
        foreach ($value as $k => $v) {
            if (!in_array($v['sign'], ['invite_reward', 'distributor_recruit', 'valid_term', 'protect_term', 'distributor_review', 'distributor_join_threshold', 'distributor_review_mode', 'distributor_write_message', 'distributor_purchase_commission', 'distributor_establish_customer_relation', 'settlement_mode', 'member_price_no_commission', 'commission_settlement_time', 'goods_set', 'commission_display_mode', 'goods_default_sort', 'distributor_name', 'share_icon'])) {
                return '参数错误';
            }

            //邀请奖励 state:0关闭  1开启
            if ($v['sign'] == 'invite_reward') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '邀请奖励参数信息错误';
                }
            }

            //分销员招募 state:0关闭  1开启
            if ($v['sign'] == 'distributor_recruit') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '分销员招募参数信息错误';
                }
            }

            //有效期设置 days:15十五天  32000永久
            if ($v['sign'] == 'valid_term') {
                if (!isset($v['content']['days']) || !in_array(intval($v['content']['days']), [15, 32000])) {
                    return '有效期设置参数信息错误';
                }
            }

            //保护期设置 state:0关闭  1开启[days:15十五天  32000永久]
            if ($v['sign'] == 'protect_term') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '保护期设置参数信息错误';
                }
                if ($v['content']['state'] == 1) {
                    if ($v['content']['days'] <= 0 || $v['content']['days'] > 32000) {
                        return '保护期设置天数错误';
                    }
                }
            }

            //分销员审核 state:0关闭  1开启
            if ($v['sign'] == 'distributor_review') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '分销员审核参数信息错误';
                }
            }

            //分销员加入门槛 type:1购买商品 2消费金额大于 XXX元 3消费笔数大于 XXX笔 多选
            //[cost_amount:消费金额]  [cost_num:消费笔数]
            if ($v['sign'] == 'distributor_join_threshold') {
                if (isset($v['content']['type'])) {
                    if (!is_array($v['content']['type']) || array_diff($v['content']['type'], [1, 2, 3])) {
                        return '分销员加入门槛选择错误';
                    }
                    if (intval($v['content']['type']) == 2 && $v['content']['cost_amount'] < 0) {
                        return '消费金额错误';
                    }
                    if (intval($v['content']['type']) == 3 && $v['content']['cost_num'] < 0) {
                        return '消费笔数错误';
                    }
                }
            }

            //审核方式 state:0 automatic自动审核  1 artificial人工审核
            if ($v['sign'] == 'distributor_review_mode') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '分销员审核方式错误';
                }
            }

            //分销员填写信息 state:0关闭  1开启
            if ($v['sign'] == 'distributor_write_message') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '分销员填写信息错误';
                }
            }

            //分销员自购分佣 state:0关闭  1开启
            if ($v['sign'] == 'distributor_purchase_commission') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '分销员自购分佣错误';
                }
            }

            //分销员建立客户关系  state:0不允许  1允许
            if ($v['sign'] == 'distributor_establish_customer_relation') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '分销员自购分佣错误';
                }
            }

            //结算方式  state:0 automatic自动结算(只有自动结算)
            //[distribution_ratio:佣金比例] [distribution_invite_ratio:邀请奖励佣金比例]
            if ($v['sign'] == 'settlement_mode') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0])) {
                    return '结算方式错误';
                }
                if ($v['content']['distribution_ratio'] <= 0) {
                    return '佣金比例必须大于0';
                }
                if ($v['content']['distribution_invite_ratio'] <= 0) {
                    return '邀请奖励佣金比例必须大于0';
                }

            }

            //会员价购买无佣金 state:0关闭  1开启
            if ($v['sign'] == 'member_price_no_commission') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '会员价购买无佣金错误';
                }
            }

            //佣金结算时间 state:0交易完成结算  1售后维权期结束结算
            if ($v['sign'] == 'commission_settlement_time') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '佣金结算时间错误';
                }
            }

            //商品设置 state:0创建商品后默认不参与推广  1创建商品后默认参与推广
            if ($v['sign'] == 'goods_set') {
                if (!isset($v['content']['state']) || !in_array(intval($v['content']['state']), [0, 1])) {
                    return '商品设置错误';
                }
            }

            //佣金显示方式 mode:1显示佣金 2显示佣金比例 [数组格式 多选]
            if ($v['sign'] == 'commission_display_mode') {
                if (!is_array($v['content']['mode']) || array_diff($v['content']['mode'], [1, 2])) {
                    return '佣金显示方式错误';
                }
            }

            // 商品默认排序 sort:1商品佣金越高越靠前 2商品价格越高越靠前 3商品销量越高越靠前 4商品上架越晚越靠前
            if ($v['sign'] == 'goods_default_sort') {
                if (!isset($v['content']['sort']) || !in_array(intval($v['content']['sort']), [1, 2, 3, 4])) {
                    return '商品默认排序错误';
                }
            }

            //分销员名称
            if ($v['sign'] == 'distributor_name') {
                if (!isset($v['content']['title'])) {
                    return '分销员名称必须';
                }
            }

            //分享图标
            if ($v['sign'] == 'share_icon') {
                if (!isset($v['content']['share_icon'])) {
                    return '分享图标必须';
                }
            }
        }
        return true;
    }


}