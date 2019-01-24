<?php
/**
 * 商品业务逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

use Yansongda\Pay\Pay;

class OrderRefund
{
    const order_no_need_lock = 1;
    const order_need_lock = 2;
    const close = 1;
    const unclose = 0;
    const refuse = 10;
    const agree = 20;
    const complete = 30;

    /**
     * 获取退款列表后
     * @date        2017-05-15
     * @Author      作者
     * @param       [数组]     $get  [传递的参数]
     * @return      [数组]     $data [返回的参数]
     */
    public function getOrderRefundList($get)
    {
        $refund_model = model('OrderRefund');
        $data         = [];
        $condition    = [];
        $keyword_type = ['order_sn', 'refund_sn', 'user_name', 'user_phone'];

        if (trim($get['key']) != '' && in_array($get['type'], $keyword_type)) {
            $type             = $get['type'];
            $condition[$type] = ['like', '%' . $get['key'] . '%'];
        }
        if (trim($get['create_time_from']) != '' || trim($get['create_time_to']) != '') {
            $create_time_from = strtotime(trim($get['create_time_from']));
            $create_time_to   = strtotime(trim($get['create_time_to']));
            if ($create_time_from !== false || $create_time_to !== false) {
                $condition['create_time'] = ['time', [$create_time_from, $create_time_to]];
            }
        }

        if ($get['handle_state'] != '') {
            $condition['handle_state'] = intval($get['handle_state']);
        }

        $order_lock = intval($get['lock']);
        if ($order_lock != 1) {
            $order_lock = 2;
        }

        $order = 'create_time desc';
        if (isset($get['order_type'])) {
            switch ($order) {
                case 1:
                    $order = 'create_time asc'; //申请时间早到晚
                    break;
                case 2:
                    $order = 'create_time desc';//申请时间晚到早
                    break;
            }
        }

        $condition['order_lock'] = $order_lock;
        // 分页
        $condition['refund_type'] = 1; //申请类型:1为仅退款,2为退货退款
        $count                    = $refund_model->where($condition)->count();

        $Page = new Page($count, 10);
        $page = $get['page'] ? $get['page'] . ',10' : '1,10';

        $data['list'] = $refund_model->getOrderRefundList($condition, '*', $order, $page);
        // $data['state_array'] = $refund_model->getOrderRefundStateArray('all');
        $data['page'] = $Page->show();
        return $data;
    }


    /**
     * 只处理退款订单 并未进行退款操作
     * @param array $refund
     * @param array $data
     * @throws \Exception
     */
    public function handle(array $refund, array $data)
    {
        $refund_model      = model('OrderRefund');
        $order_goods_model = model('OrderGoods');
        $order_model       = model('Order');
        $refund_model->startTrans();

        $condition                 = [];
        $condition['handle_state'] = [['eq', 0], ['eq', 20], ['eq', 30], 'or'];
        $condition['is_close']     = 0;
        $condition['id']           = ['neq', $refund['id']];
        $condition['order_id']     = $refund['order_id'];

        //退款状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成) 50取消(用户主动撤销) 51取消(用户主动收货)
        $total_refund_amount = $refund_model->getOrderRefundSum($condition, '', 'refund_amount');

        // 订单总金额
        $order_amount = $order_model->getOrderValue(['id' => $refund['order_id'], 'lock_state' => ['neq', 0]], 'amount');
        if (floatval($order_amount) <= 0) {
            throw new \Exception('参数错误');
        }

        //同一个总订单中：当前子订单退款金额加上其他有效的历史子订单退款金额不能大于总订单金额
        if ((floatval($data['refund_amount']) + floatval($total_refund_amount)) > floatval($order_amount)) {
            throw new \Exception('退款金额不能超过可退金额');
        }

        switch ($data['handle_state']) {
            case  self::refuse :
                // 更改退款状态
                $result = $refund_model->editOrderRefund(['id' => $data['id']], [
                    'handle_state'   => self::refuse,
                    'handle_time'    => time(),
                    'handle_message' => isset($data['handle_message']) ? $data['handle_message'] : null,
                    'is_close'       => self::close,
                ]);
                if (!$result) {
                    $refund_model->rollback();
                    throw new \Exception('参数错误');

                }
                // 拒绝 ：恢复 商品的锁定状态，判断是否还需要锁定订单
                $order_goods_res = $order_goods_model->editOrderGoods([
                                                                          'id'         => $refund['order_goods_id'],
                                                                          'lock_state' => 1,
                                                                      ], [
                                                                          'lock_state'          => 0,
                                                                          'refund_handle_state' => self::refuse,
                                                                          'refund_id'           => 0,
                                                                      ]);
                // 子订单解锁
                if (!$order_goods_res) {
                    $refund_model->rollback();
                    throw new \Exception('退款订单商品的状态错误');
                }
                // 该总订单下已锁定未关闭的退款记录，用处：判断是否解锁主订单状态
                $exist_lock = $refund_model->where([
                                                       'order_id' => $refund['order_id'],
                                                       'is_close' => self::unclose,
                                                   ])->find();
                if (!$exist_lock) {
                    // 解锁总订单
                    $order_res = $order_model->editOrder([
                                                             'id'         => $refund['order_id'],
                                                             'lock_state' => ['neq', 0],
                                                         ], [
                                                             'lock_state'   => 0,
                                                             'delay_time'   => time(),
                                                             'refund_state' => 0 // 退款状态:0是无退款,1是部分退款,2是全部退款(2的状态v1没用到)
                                                         ]);
                    if (!$order_res) {
                        $refund_model->rollback();
                        throw new \Exception('退款的主订单退款状态错误');
                    }
                }
                $refund_model->commit();
                break;
            case self::agree :

                $refund_update_state = self::agree;

                // 判断金额是否大于 总商品价格 + 运费（统一运费或者运费模板））
                if ($refund['refund_amount'] > ($refund['goods_pay_price'] + $refund['goods_freight_fee'])) {
                    $refund_model->rollback();
                    throw new \Exception('退款金额不得大于可退金额');

                }

                // 更改退款状态
                $result = $refund_model->editOrderRefund(['id' => $data['id']], [
                    'refund_amount'  => floatval($data['refund_amount']),
                    'handle_state'   => $refund_update_state,
                    'handle_time'    => time(),
                    'handle_message' => isset($data['handle_message']) ? $data['handle_message'] : null,
                ]);

                if (!$result) {
                    $refund_model->rollback();
                    throw new \Exception('参数错误');

                }
                // 同意 ： 设置 refund_handle_state = 30 是因为我们v1版本采用用户自行去支付平台退款的方式，这儿的退款同意，仅为标记作用
                $order_goods_res = $order_goods_model->editOrderGoods([
                                                                          'lock_state' => 1,
                                                                          'id'         => $refund['order_goods_id'],
                                                                      ], [
                                                                          'refund_handle_state' => $refund_update_state,
                                                                      ]);
                if (!$order_goods_res) {
                    $refund_model->rollback();
                    throw new \Exception('退款订单商品的状态错误');
                }
                // 查询所有的子订单都是退款同意的，设置订单为all_agree_refound
                $order_goods_ids    = $order_goods_model->where(['order_id' => $refund['order_id']])->column('id');
                $refund_goods_count = $order_goods_model->where([
                                                                    'id'                  => ['in', $order_goods_ids],
                                                                    'order_id'            => $refund['order_id'],
                                                                    'refund_handle_state' => self::agree,
                                                                    'lock_state'          => 1,
                                                                ])->count("DISTINCT id");
                if (count($order_goods_ids) === $refund_goods_count) {
                    $order_res = $order_model->editOrder(['id' => $refund['order_id']], ['all_agree_refound' => 1]);
                    if (!$order_res) {
                        $refund_model->rollback();
                        throw new \Exception('修改订单全退状态失败');

                    }
                }

                $order_refund_amount  = $order_model->getOrderValue(['id' => $refund['order_id']], 'refund_amount');
                $update_refund_amount = $order_refund_amount + floatval($data['refund_amount']);
                $order_result         = $order_model->editOrder(['id' => $refund['order_id']], ['refund_amount' => $update_refund_amount]);
                if (!$order_result) {
                    $refund_model->rollback();
                    throw new \Exception('修改订单退款金额失败');

                }

                $refund_model->commit();
                break;
            default :
                $refund_model->rollback();
                throw new \Exception('未知handle_state');
                break;

        }

        return true;

    }


    /**
     * 进行退款操作 原路返回
     * @param array $refund
     * @throws \Exception
     */
    public function refund(array $refund)
    {
        $refund_model          = model('OrderRefund');
        $order_model           = model('Order');
        $condition             = [];
        $condition['order_id'] = $refund['order_id'];
        $payment_code          = $order_model->getOrderValue(['id' => $refund['order_id']], 'payment_code');
        if (!$payment_code) {
            throw new \Exception('获取订单支付方式名称失败');
        }

        if (in_array($payment_code, ['wechat', 'wechat_mini', 'wechat_app'])) {
            $setting_key = 'wechat';
        }

        if (in_array($payment_code, ['alipay_web', 'alipay_wap', 'alipay_app'])) {
            $setting_key = 'alipay';
        }

        if (!$setting_key) {
            throw new \Exception('不支持的支付方式');
        }

        $setting_info = model('Setting')->getSettingInfo(['key' => $setting_key]);
        if (!$setting_info) {
            throw new \Exception('获取支付配置失败');
        }

        $config = $setting_info['config'];
        if ($setting_info['key'] == 'wechat') {
            $pay_config = [
                'appid'         => $config['appid'], // APP APPID
                'app_id'        => $config['app_id'], // 公众号 APPID
                'miniapp_id'    => $config['mini_app_id'], // 小程序 APPID
                'mch_id'        => $config['mch_id'],
                'key'           => $config['key'],
                'notify_url'    => '',
                'cert_client'   => EASYSWOOLE_ROOT . "/" . $config['apiclient_cert'], // optional，退款等情况时用到
                'cert_key'      => EASYSWOOLE_ROOT . "/" . $config['apiclient_key'],// optional，退款等情况时用到
                'log'           => [ // optional
                    'file'     => EASYSWOOLE_ROOT . '/Runtime/Log/wechat.log',
                    'level'    => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
                    'type'     => 'single', // optional, 可选 daily.
                    'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
                ],
                'http'          => [ // optional
                    'timeout'         => 5.0,
                    'connect_timeout' => 5.0,
                    // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
                ],
                'response_type' => 'array',
                //            'mode'          => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
            ];

            //退款参数准备
            $order = [
                'transaction_id' => $refund['trade_no'], //transaction_id
                'out_refund_no'  => time(),
                'total_fee'      => $refund['order_amount'] * 100,
                'refund_fee'     => $refund['refund_amount'] * 100,
                'refund_desc'    => '订单' . $refund['order_sn'] . '退款',
            ];

            //如果您需要退 APP/小程序 的订单，请传入参数：['type' => 'app']/['type' => 'miniapp']
            switch ($payment_code) {
                case 'wechat':
                    # code...
                    break;
                case 'wechat_mini':
                    $order['type'] = 'miniapp';
                    break;
                case 'wechat_app':
                    $order['type'] = 'app';
                    break;
            }

            $result = Pay::wechat($pay_config)->refund($order);

            if ($result) {
                if ($result->result_code == 'SUCCESS' && $result->return_code == 'SUCCESS') {
                    $updata['refund_no']    = $result->transaction_id;
                    $updata['handle_state'] = 30;
                    $updata['success_time'] = time();//退款回调完成时间
                    $result                 = $refund_model->updateOrderRefund(['id' => $refund['id']], $updata);
                    if (!$result) {
                        throw new \Exception('退款失败');
                    }
                } else {
                    throw new \Exception('退款失败');
                }

            } else {
                throw new \Exception('退款失败');
            }

        } elseif ($setting_info['key'] == 'alipay') {
            $notify_url = (isset($config['callback_domain']) ? $config['callback_domain'] : $this->request->domain()) . "/Server/Buy/alipayAppNotify";

            $pay_config = [
                'app_id'         => $config['app_id'],// APP APPID,
                'notify_url'     => '',
                'return_url'     => '',
                'ali_public_key' => $config['alipay_public_key'], //加密方式： **RSA2**
                'private_key'    => $config['merchant_private_key'],
                'log'            => [ // optional
                    'file'     => EASYSWOOLE_ROOT . '/Runtime/Log/alipay.log',
                    'level'    => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
                    'type'     => 'single', // optional, 可选 daily.
                    'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
                ],
                'http'           => [ // optional
                    'timeout'         => 5.0,
                    'connect_timeout' => 5.0,
                    // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
                ],
                // 'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
            ];
            //退款参数准备
            $order  = [
                'trade_no'       => $refund['trade_no'],
                'refund_amount'  => $refund['refund_amount'],
                'out_request_no' => $refund['out_request_no'],
                'refund_reason'  => '订单' . $refund['order_sn'] . '退款',
            ];
            $result = Pay::alipay($pay_config)->refund($order);
            if ($result) {
                if ($result->code == 10000) {
                    $updata['refund_no']    = $result->trade_no;
                    $updata['handle_state'] = 30;
                    $updata['success_time'] = time();//退款回调完成时间
                    $result                 = $refund_model->updateOrderRefund(['id' => $refund['id']], $updata);
                    if (!$result) {
                        throw new \Exception('退款失败');
                    }
                } else {
                    throw new \Exception('退款失败');
                }

            } else {
                throw new \Exception('退款失败');
            }

        } else {
            throw new \Exception('不支持的支付方式');

        }

        return true;
    }
}
