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
        $prefix                                  = config('database.prefix');
        $table_distributor                       = $prefix . "distributor";
        $table_user                              = $prefix . "user";
        $condition                               = [];
        $condition['order.distribution_user_id'] = ['gt', 0];

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
        $prefix                              = config('database.prefix');
        $table_order                         = $prefix . "order";
        $table_order_goods                   = $prefix . "order_goods";
        $condition                           = [];
        $condition['distributor.state']      = 1; //默认0 待审核 1审核通过 2审核拒绝
        $condition['distributor.is_retreat'] = 0; //默认0有效 1无效（被清退）

        if (isset($get['phone'])) {
            $condition['user.phone'] = $get['phone'];
        }

        if ($get['create_time'] != '' && is_array($get['create_time'])) {
            $condition['distributor.create_time'] = ['between', $get['create_time']];
        }

        $distributor_model = model('Distributor');
        $count             = $distributor_model->getDistributorMoreCount($condition, '');
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
        $list  = $distributor_model->getDistributorMoreList($condition, '', $field, $order, $this->getPageLimit(), '');
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
     * 招募计划详情
     * @method GET
     * @author 孙泉
     */
    public function recruitInfo()
    {
        $distribution_recruit_model = model('DistributionRecruit');
        $field                      = '*';
        $info                       = $distribution_recruit_model->getDistributionRecruitInfo([], '', $field);
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
        $error = $this->validate($post, 'Admin/DistributionRecruit.edit');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distribution_recruit_model = model('DistributionRecruit');
            $info                       = $distribution_recruit_model->getDistributionRecruitInfo([], '', '*');
            if (!$info) {
                $insert_data            = [];
                $insert_data['title']   = $post['title'];
                $insert_data['url']     = $post['url'];
                $insert_data['content'] = $post['content'];
                $result                 = $distribution_recruit_model->insertDistributionRecruit($insert_data);

            } else {
                $update_data            = [];
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
     * @param string config    参数名称
     * @param string value  参数信息
     */
    public function configSet()
    {
        $post           = $this->post;
        //测试参数
        $post['config'] = [['key' => 'invite_reward', 'value' => ['state' => 0]], ['key' => 'distributor_recruit', 'value' => ['state' => 1]]];
        $error          = $this->validate($post, 'Admin/DistributionConfig.edit');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distribution_config_model = model('DistributionConfig');
            var_dump('验证ok!');
            return $this->send(Code::success);

        }
    }


}