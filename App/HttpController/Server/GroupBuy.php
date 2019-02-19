<?php
/**
 * 拼团购买模块
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use App\Utils\Code;

class GroupBuy extends Server
{

    /**
     * 计算购买项
     * @method POST
     * @param int  goods_sku_id 商品sku id
     * @param int  goods_id     商品id
     * @param int  group_id     拼团活动id
     * @param int  goods_number 商品数量
     * @param int  buy_way      购买方式 single_buy[单独购买] open_group[自己开团] join_group[参与他人团]
     * 目前单独购买走之前的商品直接购买接口 不走此团购接口 所以不要传递single_buy给此接口
     * @param int  order_id     订单id 参与别人的团时使用 ，他人的团的订单id
     * @param int  address_id   地址id
     * @author 孙泉
     */
    public function calculate()
    {
        if ($this->verifyResourceRequest() !== true) {
            $this->send(Code::user_access_token_error);
        } else {
            $post = $this->post;
            if ($this->validator($post, 'Server/GroupBuy.calculate') !== true) {
                $this->send(Code::param_error, [], $this->getValidator()->getError());
            } else {
                try {
                    $user = $this->getRequestUser();
                    $data = [
                        'user_id'      => $user['id'],
                        'goods_sku_id' => $post['goods_sku_id'],
                        'goods_id'     => $post['goods_id'],
                        'group_id'     => $post['group_id'],
                        'goods_number' => $post['goods_number'],
                        'buy_way'      => $post['buy_way'],
                        'order_id'     => isset($post['order_id']) ? $post['order_id'] : 0,
                        'address_id'   => $post['address_id'],
                        'user_info'    => (array)$user,
                    ];

                    $model_buy       = new \App\Biz\Server\Group\Buy($data);
                    $calculateResult = $model_buy->calculate();

                    $this->send(Code::success, [
                        'goods_amount'         => $calculateResult->getGoodsAmount(),
                        'goods_group_amount'   => $calculateResult->getGoodsGroupAmount(),
                        'pay_amount'           => $calculateResult->getPayAmount(),
                        'goods_freight_list'   => $calculateResult->getGoodsFreightList(),
                        'freight_unified_fee'  => $calculateResult->getFreightUnifiedFee(),
                        'freight_template_fee' => $calculateResult->getFreightTemplateFee(),
                        'pay_freight_fee'      => $calculateResult->getPayFreightFee(),
                    ]);
                } catch (\Exception $e) {
                    $this->send(Code::server_error, [], $e->getMessage());
                }
            }
        }
    }

    /**
     * 创建购买订单
     * @method POST
     * @param int  goods_sku_id 商品sku id
     * @param int  goods_id     商品id
     * @param int  group_id     拼团活动id
     * @param int  goods_number 商品数量
     * @param int  buy_way      购买方式 single_buy[单独购买] open_group[自己开团] join_group[参与他人团]
     * 目前单独购买走之前的商品直接购买接口 不走此团购接口 所以不要传递single_buy给此接口
     * @param int  order_id     订单id 参与别人的团时使用 ，他人的团的订单id
     * @param int  address_id   地址id
     * @param string $message 买家留言
     *
     */
    public function create()
    {
        if ($this->verifyResourceRequest() !== true) {
            $this->send(Code::user_access_token_error);
        } else {
            $post = $this->post;
            if ($this->validator($post, 'Server/GroupBuy.create') !== true) {
                $this->send(Code::param_error, [], $this->getValidator()->getError());
            } else {
                try {
                    $user = $this->getRequestUser();
                    $data = [
                        'user_id'      => $user['id'],
                        'goods_sku_id' => $post['goods_sku_id'],
                        'goods_id'     => $post['goods_id'],
                        'group_id'     => $post['group_id'],
                        'goods_number' => $post['goods_number'],
                        'buy_way'      => $post['buy_way'],
                        'order_id'     => isset($post['order_id']) ? $post['order_id'] : 0,
                        'address_id'   => $post['address_id'],
                        'user_info'    => (array)$user,
                        'message'      => isset($post['message']) ? $post['message'] : null,
                    ];

                    $model_buy = new \App\Biz\Server\Group\Buy($data);
                    $result    = $model_buy->createOrder();
                    if ($model_buy->getOrderId()) {
                        $this->send(Code::success, [
                            'order_id' => $result->getOrderId(),
                            'pay_sn'   => $result->getPaySn(),
                        ]);
                    } else {
                        $this->send(Code::error);
                    }
                } catch (\Exception $e) {
                    $this->send(Code::server_error, [], $e->getMessage());
                }
            }
        }
    }


}
