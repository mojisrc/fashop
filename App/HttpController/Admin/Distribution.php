<?php
/**
 *
 * 分销相关
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Logic\Order as OrderLogic;
use App\Utils\Code;

/**
 * 分销相关
 * Class Distributor
 * @package App\HttpController\Admin
 */
class Distribution extends Admin
{

    /**
     * 推广效果
     * @method GET
     * @param string distributor_phone  分销员手机号
     * @param string  sn                订单编号
     */
    public function promotion()
    {
        $get                                     = $this->get;
        $prefix                                  = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
        $table_distributor                       = $prefix . "distributor";
        $table_user                              = $prefix . "user";
        $condition['order.distribution_user_id'] = ['>', 0];

        if (isset($get['distributor_phone'])) {
            $condition["(SELECT phone FROM $table_user WHERE id=order.distribution_user_id)"] = $get['distributor_phone'];
        }

        if (isset($get['sn'])) {
            $condition['order.sn'] = $get['sn'];
        }

        $field = 'order.*';
        $field = $field . ",
        (CASE WHEN order.refund_state=0 THEN CASE WHEN order.revise_amount>0 THEN SUM(order.revise_amount-order.revise_freight_fee) ELSE SUM(order.amount-order.freight_fee) END WHEN order.refund_state=1 THEN CASE WHEN order.revise_amount>0 THEN CASE WHEN SUM(order.revise_amount-order.revise_freight_fee-order.refund_amount)>0 THEN SUM(order.revise_amount-order.revise_freight_fee-order.refund_amount) ELSE 0 END ELSE CASE WHEN SUM(order.amount-order.freight_fee-order.refund_amount)>0 THEN SUM(order.amount-order.freight_fee-order.refund_amount) ELSE 0 END END ELSE 0 END) AS total_deal_amount,
        
        (SELECT phone FROM $table_user WHERE id=order.distribution_user_id) AS distributor_phone,
        
        (SELECT nickname FROM $table_distributor WHERE user_id=order.distribution_user_id) AS distributor_nickname";

        $orderLogic = new OrderLogic($condition);
        $orderLogic->page($this->getPageLimit())->extend([
                                                             'order_goods',
                                                         ]);
        $count = $orderLogic->count();
        if ($count > 0) {
            $orderLogic->field($field);
        }
        $list = $orderLogic->list();

        if ($list) {
            $list = \App\Model\Order::distributionPromotionDesc($list);
        }

        $this->send(Code::success, [
            'total_number' => $count,
            'list'         => $list,
        ]);

    }

    /**
     * 业绩统计 没有人工功能
     * @method GET
     * @param string phone          分销员手机号
     * @param array  create_time    申请时间[开始时间,结束时间]
     * 清退的分销员不在这里显示
     * 自动结算订单 = 累计成交笔数
     * 自动结算订单金额 = 累计成交金额
     */
    public function achievement()
    {
        $get                                 = $this->get;
        $prefix                              = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
        $table_order                         = $prefix . "order";
        $table_order_goods                   = $prefix . "order_goods";
        $condition['distributor.state']      = 1; //默认0 待审核 1审核通过 2审核拒绝
        $condition['distributor.is_retreat'] = 0; //默认0有效 1无效（被清退）

        if (isset($get['phone'])) {
            $condition['user.phone'] = $get['phone'];
        }

        if ($get['create_time'] != '' && is_array($get['create_time'])) {
            $condition['distributor.create_time'] = ['between', $get['create_time']];
        }

        $distributor_model = new \App\Model\Distributor;
        $count             = $distributor_model->getDistributorMoreCount($condition);
        $field             = 'distributor.*,user.phone';

        //total_deal_num        订单数   = 累计成交笔数
        //total_deal_amount     订单金额  = 累计成交金额
        $field = $field . ",
        (SELECT COUNT(id) FROM $table_order WHERE (distribution_user_id=distributor.user_id AND state>=20) OR (user_id=distributor.user_id AND state>=20)) AS total_deal_num,
        
        (SELECT CASE WHEN refund_state=0 THEN CASE WHEN revise_amount>0 THEN SUM(revise_amount-revise_freight_fee) ELSE SUM(amount-freight_fee) END WHEN refund_state=1 THEN CASE WHEN revise_amount>0 THEN CASE WHEN SUM(revise_amount-revise_freight_fee-refund_amount)>0 THEN SUM(revise_amount-revise_freight_fee-refund_amount) ELSE 0 END ELSE CASE WHEN SUM(amount-freight_fee-refund_amount)>0 THEN SUM(amount-freight_fee-refund_amount) ELSE 0 END END ELSE 0 END FROM $table_order WHERE (distribution_user_id=distributor.user_id AND state>=20) OR (user_id=distributor.user_id AND state>=20)) AS total_deal_amount,
        
        (SELECT CASE WHEN goods_revise_price>0 THEN TRUNCATE((goods_revise_price-refund_amount)*distribution_ratio/100,2) ELSE TRUNCATE((goods_pay_price-refund_amount)*distribution_ratio/100,2) END FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_user_id=distributor.user_id AND state>=20 AND pay_name='online'
    AND distribution_settlement=0 AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)) AS unsettlement_amount,
    
        ((SELECT CASE WHEN goods_revise_price>0 THEN TRUNCATE((goods_revise_price-refund_amount)*distribution_ratio/100,2) ELSE TRUNCATE((goods_pay_price-refund_amount)*distribution_ratio/100,2) END FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_user_id=distributor.user_id AND state>=20 AND pay_name='online'
    AND distribution_settlement=1 AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END))) AS settlement_amount";

        $order = 'distributor.id desc';
        $list  = $distributor_model->getDistributorMoreList($condition, $field, $order, $this->getPageLimit(), '');
        if ($list) {
            foreach ($list as $key => $value) {
                if (!floatval($value['unsettlement_amount'])) {
                    $list[$key]['unsettlement_amount'] = 0;
                }
                if (!floatval($value['unsettlement_amount'])) {
                    $list[$key]['settlement_amount'] = 0;
                }
            }
        }
        return $this->send(Code::success, [
            'total_number' => $count,
            'list'         => $list,
        ]);
    }

    /**
     * 关系查询
     * @method GET
     * @param string sn 订单编号
     * @author 孙泉
     */
    public function relationship()
    {
        $get       = $this->get;

        if (!isset($get['sn'])) {
            return $this->send(Code::success, [
                'total_number' => 0,
                'list'         => [],
            ]);
        }

        $condition['sn']                   = $get['sn'];
        $condition['distribution_user_id'] = ['>', 0];
        $order_info                        = \App\Model\Order::init()->getOrderInfo($condition, '*', []);

        if (!$order_info) {
            return $this->send(Code::success, [
                'total_number' => 0,
                'list'         => [],
            ]);
        }

        $field = 'distributor_customer.*,distributor_user.phone AS distributor_phone,user,nickname AS user_nickname';
        $order = 'distributor_customer.create_time desc';

        $top_condition['distributor_customer.distributor_user_id'] = $order_info['distribution_user_id'];
        $top_condition['distributor_customer.user_id']             = $order_info['user_id'];
        $top_condition['distributor_customer.create_time']         = ['<', $order_info['create_time']];

        $top_data          = \App\Model\DistributorCustomer::init()->getDistributorCustomerMoreSortInfo($top_condition, $field, $order);
        if (!$top_data) {
            return $this->send(Code::success, [
                'total_number' => 0,
                'list'         => [],
            ]);
        }

        $top_data['state_desc'] = '有效';
        $top_data['reason']     = '';

        $other_condition['distributor_user_id'] = $top_data['distributor_user_id'];
        $other_condition['user_id']             = $top_data['user_id'];
        $other_condition['create_time']         = ['<', $top_data['create_time']];

        $other_count = \App\Model\DistributorCustomer::init()->getDistributorCustomerMoreCount($other_condition);
        if ($other_count) {
            $other_list = \App\Model\DistributorCustomer::init()->getDistributorCustomerMoreList($other_condition, $field, $order, '', '');
            $count      = 1 + $other_count;
            $list       = [0 => $top_data];
            foreach ($other_list as $key => $value) {
                $value['state_desc'] = '失效';
                $value['reason']     = '客户关系变更';
                $list[$key + 1]      = $value;
            }
        } else {
            $count = 1;
            $list  = [0 => $top_data];
        }

        return $this->send(Code::success, [
            'total_number' => $count,
            'list'         => $list,
        ]);
    }

    /**
     * 招募计划详情
     * @method GET
     * @author 孙泉
     */
    public function recruitInfo()
    {
        $distribution_recruit_model = new \App\Model\DistributionRecruit;
        $field                      = '*';
        $info                       = $distribution_recruit_model->getDistributionRecruitInfo([], $field);
        return $this->send(Code::success, ['info' => $info]);
    }

    /**
     * 招募计划编辑
     * @method POST
     * @param string title          名称
     * @param string url            链接地址
     * @param string content        内容
     */
    public function recruitEdit()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/DistributionRecruit.edit');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distribution_recruit_model = new \App\Model\DistributionRecruit;
            $info                       = $distribution_recruit_model->getDistributionRecruitInfo([], '*');

            if (!$info) {
                $insert_data['title']   = $post['title'];
                $insert_data['url']     = $post['url'];
                $insert_data['content'] = $post['content'];
                $result                 = $distribution_recruit_model->insertDistributionRecruit($insert_data);

            } else {
                $update_data['title']   = $post['title'];
                $update_data['url']     = $post['url'];
                $update_data['content'] = $post['content'];
                $result                 = $distribution_recruit_model->updateDistributionRecruit(['title' => $info['title']], $update_data);
            }
            if ($result) {
                return $this->send(Code::success);
            } else {
                return $this->send(Code::error);
            }
        }
    }

    /**
     * 配置信息设置
     * @method POST
     * @param string config     参数名称
     * @param string value      参数信息
     * name和remark已经在数据库中标注好了 无需更改
     * 数据库表已经初始化了content的值，此处是作为修改功能使用
     */
    public function configSet()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/DistributionConfig.edit');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $update_data = [];
            foreach ($post['config'] as $k => $v) {
                $update_data[$k]['sign'] = $v['sign'];

                //邀请奖励 state:0关闭  1开启
                if ($v['sign'] == 'invite_reward') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //分销员招募 state:0关闭  1开启
                if ($v['sign'] == 'distributor_recruit') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //有效期设置 days:15十五天  32000永久
                if ($v['sign'] == 'valid_term') {
                    $update_data[$k]['content']['days'] = $v['content']['days'];
                }

                //保护期设置 state:0关闭  1开启[days:15十五天  32000永久]
                if ($v['sign'] == 'protect_term') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                    $update_data[$k]['content']['days']  = $v['content']['days'];
                }

                //分销员审核 state:0关闭  1开启
                if ($v['sign'] == 'distributor_review') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //分销员加入门槛 type:1购买商品 2消费金额大于 XXX元 3消费笔数大于 XXX笔
                //[cost_amount:消费金额]  [cost_num:消费笔数]
                if ($v['sign'] == 'distributor_join_threshold') {
                    $update_data[$k]['content']['type']        = $v['content']['type'];
                    $update_data[$k]['content']['cost_amount'] = $v['content']['cost_amount'];
                    $update_data[$k]['content']['cost_num']    = $v['content']['cost_num'];
                }

                //审核方式 state:0 automatic自动审核  1 artificial人工审核
                if ($v['sign'] == 'distributor_review_mode') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //分销员填写信息 state:0关闭  1开启
                if ($v['sign'] == 'distributor_write_message') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //分销员自购分佣 state:0关闭  1开启
                if ($v['sign'] == 'distributor_purchase_commission') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //分销员建立客户关系  state:0不允许  1允许
                if ($v['sign'] == 'distributor_establish_customer_relation') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //结算方式  state:0 automatic自动结算(只有自动结算)
                //[distribution_ratio:佣金比例] [distribution_invite_ratio:邀请奖励佣金比例]
                if ($v['sign'] == 'settlement_mode') {
                    $update_data[$k]['content']['state']                     = $v['content']['state'];
                    $update_data[$k]['content']['distribution_ratio']        = $v['content']['distribution_ratio'];
                    $update_data[$k]['content']['distribution_invite_ratio'] = $v['content']['distribution_invite_ratio'];
                }

                //会员价购买无佣金 state:0关闭  1开启
                if ($v['sign'] == 'member_price_no_commission') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //佣金结算时间 state:0交易完成结算  1售后维权期结束结算
                if ($v['sign'] == 'commission_settlement_time') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //商品设置 state:0创建商品后默认不参与推广  1创建商品后默认参与推广
                if ($v['sign'] == 'goods_set') {
                    $update_data[$k]['content']['state'] = $v['content']['state'];
                }

                //佣金显示方式 mode:1显示佣金 2显示佣金比例 [数组格式 多选]
                if ($v['sign'] == 'commission_display_mode') {
                    $update_data[$k]['content']['mode'] = $v['content']['mode'];
                }

                // 商品默认排序 sort:1商品佣金越高越靠前 2商品价格越高越靠前 3商品销量越高越靠前 4商品上架越晚越靠前
                if ($v['sign'] == 'goods_default_sort') {
                    $update_data[$k]['content']['sort'] = $v['content']['sort'];
                }

                //分销员名称
                if ($v['sign'] == 'distributor_name') {
                    $update_data[$k]['content']['title'] = $v['content']['title'];
                }

                //分享图标
                if ($v['sign'] == 'share_icon') {
                    $update_data[$k]['content']['share_icon'] = $v['content']['share_icon'];
                }
                $update_data[$k]['content'] = json_encode($update_data[$k]['content']);
            }
            $result = \App\Model\DistributionConfig::init()->editMultiDistributionConfig($update_data);
            if ($result) {
                return $this->send(Code::success);
            } else {
                return $this->send(Code::error);
            }
        }
    }


}