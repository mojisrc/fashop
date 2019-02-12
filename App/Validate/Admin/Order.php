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

use ezswoole\Validator;

class Order extends Validate
{
    protected $rule
        = [
            'id'                 => 'require',
            'shipper_id'         => 'require',
            'express_id'         => 'require',
            'tracking_no'        => 'require',
            'deliver_name'       => 'require',
            'deliver_phone'      => 'require',
            'deliver_address'    => 'require',
            'need_express'       => 'require',
            'revise_goods'       => 'require|checkReviseGoods',
            'revise_freight_fee' => 'require|checkReviseFreightFee',

        ];
    protected $message
        = [
            'id.require'                 => "id必须",
            'shipper_id.require'         => "商家物流地址必须",
            'express_id.require'         => "物流公司ID必须",
            'tracking_no.require'        => "物流单号必须",
            'revise_goods.require'       => "订单商品必须",
            'revise_freight_fee.require' => "运费必须",
        ];
    protected $scene
        = [
            'info' => [
                'id',
            ],

            'setSend' => [
                'id',
                'deliver_name',
                'deliver_phone',
                'deliver_address',
                'need_express',
            ],

            'logisticsQuery' => [
                'express_id',
                'tracking_no',

            ],
            'groupInfo'      => [
                'id',
            ],
            'changePrice'      => [
                'revise_goods',
                'revise_freight_fee',
            ],
        ];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkReviseGoods($value, $rule, $data)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if (!array_key_exists('id', $v) || !isset($v['id']) || intval($v['id']) <= 0) {
                    return '参数错误';
                }
                if (!array_key_exists('difference_price', $v)) {
                    return '参数错误';
                }
            }
            $result = true;
        } else {
            $result = '参数错误';

        }
        return $result;
    }

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkReviseFreightFee($value, $rule, $data)
    {
        if (intval($value) < 0) {
            $result = '参数错误';
        } else {
            $result = true;
        }
        return $result;
    }

}