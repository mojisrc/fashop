<?php
/**
 *
 * 分销相关
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
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
            $list = model('Order')->distributionPromotionDesc($list);
        }

        $this->send(Code::success, [
            'total_number' => $count,
            'list'         => $list,
        ]);

    }

    /**
     * 业绩统计
     * @method GET
     * @param string distributor_phone  分销员手机号
     */
    public function achievement()
    {

    }

}