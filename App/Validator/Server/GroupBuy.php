<?php

namespace App\Validator\Server;

use ezswoole\Validator;


/**
 * 拼团商品购买管理验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class GroupBuy extends Validator
{
    //验证
    protected $rule
        = [
            'goods_sku_id' => 'require|integer',
            'goods_id'     => 'require|integer',
            'group_id'     => 'require|integer',
            'goods_number' => 'require|checkGoodsNumber',
            'buy_way'      => 'require|checkBuyWay',
            'order_id'     => 'require|integer',
            'address_id'   => 'require|integer',

        ];
    //提示
    protected $message
        = [
            'goods_sku_id.require' => '商品sku id必填',
            'goods_id.require'     => '商品id必填',
            'group_id.require'     => '拼团活动id必须',
            'goods_number.require' => '商品数量必须',
            'buy_way.require'      => '购买方式量必须',
            'order_id.require'     => '订单id必填',
            'address_id.require'   => '地址id必填',

        ];
    //场景
    protected $scene
        = [
            'calculate' => [
                'goods_sku_id',
                'goods_id',
                'group_id',
                'goods_number',
                'buy_way',
                'address_id'

            ],
            'create' => [
                'goods_sku_id',
                'goods_id',
                'group_id',
                'goods_number',
                'buy_way',
                'address_id'

            ],
        ];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkGoodsNumber($value, $rule, $data)
    {
        if ($value <= 0) {
            $result = '参数错误';

        } else {
            $result = true;

        }
        return $result;
    }

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkBuyWay($value, $rule, $data)
    {

        if (in_array($value, ['single_buy', 'open_group', 'join_group'])) {
            $result = true;
            if (trim($value) == 'join_group') {
                if (intval($data['order_id']) <= 0) {
                    $result = '购买方式错误，缺少参数';
                }
            }
            if (trim($value) == 'single_buy') {
                $result = '目前单独购买走之前的商品直接购买接口 不走此团购接口';//这个永不会报错 因为永远不会等于single_buy
            }

        } else {
            $result = '购买方式错误';

        }
        return $result;
    }


}