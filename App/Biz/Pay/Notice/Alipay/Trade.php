<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/6
 * Time: 下午8:40
 *
 */

namespace App\Biz\Pay\Notice\Alipay;

use Yansongda\Pay\Log;

class Trade extends Notice
{
    final public function __construct(array $config)
    {
        parent::__construct($config);
    }

    final public function check(): bool
    {
        try {
            $data = $this->pay->verify();
            $this->setData($data);
            // 通知触发条件一种有四种 TRADE_FINISHED TRADE_SUCCESS WAIT_BUYER_PAY TRADE_CLOSED  文档地址：https://docs.open.alipay.com/59/103666
            // 在支付宝的业务通知中，只有交易通知状态 trade_status 为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            if (($this->data->trade_status === 'TRADE_SUCCESS' || $this->data->trade_status === 'TRADE_FINISHED')) {
                // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
                // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
                $order_model = model('Order');
                $this->order = \App\Model\Order::getOrderCommonInfo([
                                                                    'pay_sn'       => $this->data->out_trade_no,
                                                                    'payment_time' => 0,
                                                                ], '', '*');

                // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
                // 4、验证app_id是否为该商户本身。
                if ($this->data->app_id !== $this->config['app_id']) {
                    trace("app_id 错误", 'debug');
                    return false;
                }
                if ($this->order['id'] > 0) {
                    return true;
                } else {
                    trace("没有该订单", 'debug');
                    return false;
                }
            } else {
                trace("alipay check data trade_status fail");
                return false;
            }
        } catch (\Exception $e) {
            trace($e->getMessage(), 'debug');
            return false;
        }

    }

    final public function handle(): bool
    {
        if ($this->check() === true) {
            return true;
        } else {
            trace("验证 失败", 'debug');
            return false;
        }
        Log::debug('Alipay notify', $this->data->all());
        return true;
    }
}

