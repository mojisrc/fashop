<?php
/**
 * 订单列表逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2016 WenShuaiKeJi Inc. (http://www.wenshuai.cn)
 * @license    http://www.wenshuai.cn
 * @link       http://www.wenshuai.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;
class Order extends Logic
{
    // 取消订单
    const state_cancel = 0;
    // 未支付订单
    const state_new = 10;
    // 已支付
    const state_pay = 20;
    // 已发货
    const state_send = 30;
    // 已收货，交易成功
    const state_success = 40;
    // 未评价
    const state_unevaluate = 40;
    // 已评价
    const ORDER_EVALUATE = 40; // todo
    //订单结束后可评论时间，15天，60*60*24*15
    const ORDER_EVALUATE_TIME = 1296000; // todo 需要可修改

    const allowed_order_states
        = [
            'state_close',
            'state_new',
            'state_pay',
            'state_send',
            'state_success',
            'state_cancel',
            'state_refund',
            'state_unevaluate',
        ];
    /**
     * @var array
     */
    private $condition;
    /**
     * @var array
     */
    private $userIds;
    /**
     * @var int
     */
    private $print;
    /**
     * @var string
     */
    private $stateType;
    /**
     * @var string
     */
    private $keywordsType;
    /**
     * @var mixed
     */
    private $keywords;
    /**
     * @var array
     */
    private $createTime;
    /**
     * @var string
     */
    private $page;
    /**
     * @var string
     */
    private $order = 'order.id desc';
    /**
     * @var string
     */
    private $field = 'order.*';

    /**
     * @var array
     */
    private $alias
        = [
            'order' => 'order',
        ];
    /**
     * @var array
     */
    private $extend
        = [
            'order_goods',
            'order_extend',
            'user',
        ];

    private $make = null;

    public function createTime( array $create_time ) : Order
    {
        if( count( $create_time ) != 2 ){
            throw new \InvalidArgumentException( "create_time error" );
        } else{
            $this->createTime = $create_time;
            return $this;
        }
    }

    public function stateType( string $state_type ) : Order
    {
        if( !in_array( $state_type, self::allowed_order_states ) ){
            throw new \InvalidArgumentException( "state error" );
        } else{
            $this->stateType = $state_type;
            return $this;
        }
    }

    public function users( string $type, array $params ) : Order
    {
        if( !in_array( $type, ['id'] ) ){
            throw new \InvalidArgumentException( "users error" );
        } else{
            $this->userIds = $params;
            return $this;
        }
    }

    public function keywords( string $type, $keywords ) : Order
    {
        if( !in_array( $type, ['goods_name', 'order_no', 'receiver_name', 'receiver_phone', 'courier_number'] ) ){
            throw new \InvalidArgumentException( "keywords error" );
        } else{
            $this->keywordsType = $type;
            $this->keywords     = $keywords;
            return $this;
        }
    }

    public function print( int $stateCode ) : Order
    {
        if( !in_array( $stateCode, [0, 1] ) ){
            throw new \InvalidArgumentException( "print error" );
        } else{
            $this->print = $stateCode;
            return $this;
        }
    }

    public function feedback( string $type ) : Order
    {
        if( !in_array( $type, ['todo', 'closed'] ) ){
            throw new \InvalidArgumentException( "feedback error" );
        } else{
            $this->feedback = $type;
            return $this;
        }
    }


    public function buildCondition() : void
    {
        $this->condition['order.all_agree_refound'] = 0;//默认为0，1是订单的全部商品都退了

        if( !empty( $this->stateType ) ){

            $this->condition['order.state']             = constant('self::' . $this->stateType);

//			if( $this->stateType === 'state_unevaluate' ){
//                $this->condition['order.evaluate_state'] = 0; // 评价状态 0未评价，1已评价
//            }
            if($this->stateType === 'state_cancel'){
                $this->condition['order.refund_state'] = 0;
            }

        }

        if( !empty( $this->print ) ){
            $this->condition['order.is_print'] = $this->print;
        }

        if( !empty( $this->createTime ) ){
            $this->condition['order.create_time'] = [
                'between',
                $this->createTime,
            ];
        }

        if( !empty( $this->userIds ) ){
            $this->condition['order.user_id'] = ['in', $this->userIds];
        }
        $prefix             = config( 'database.prefix' );
        $table_order_extend = $prefix."order_extend";
        $table_order_goods  = $prefix."order_goods";
        if( !empty( $this->keywords ) && !empty( $this->keywordsType ) ){
            switch( $this->keywordsType ){
                case 'goods_name':
                    $this->condition["order.id"] = [
                        'exp',
                        "in (SELECT GROUP_CONCAT(order_id) FROM $table_order_goods WHERE goods_title LIKE '%".$this->keywords."%' GROUP BY order_id)",
                    ];
                    break;
                case 'order_no':
                    $this->condition['order.sn'] = ['like', '%'.$this->keywords.'%'];
                    break;

                case 'receiver_name':
                    $this->condition["order.id"] = [
                        'exp',
                        "in (SELECT GROUP_CONCAT(id) FROM $table_order_extend WHERE reciver_name LIKE '%".$this->keywords."%' GROUP BY id)",
                    ];
                    break;

                case 'receiver_phone':
                    $this->condition["order.id"] = [
                        'exp',
                        "in (SELECT GROUP_CONCAT(id) FROM $table_order_extend WHERE receiver_phone LIKE '%".$this->keywords."%' GROUP BY id)",
                    ];
                    break;

                case 'courier_number':
                    $this->condition['order.trade_no'] = ['like', '%'.$this->keywords.'%'];
                    break;
            }
        }

        $table_order_refund = $prefix."order_refund";

        if( !empty( $this->feedback ) ){
            //维权状态：退款处理中 todo、退款结束 closed
            $this->condition['order.refund_state'] = ['gt', 0]; // 退款状态:0是无退款,1是部分退款,2是全部退款
            $this->condition['order.lock_state']   = ['gt', 0];   // 锁定状态:0是正常,大于0是锁定,默认是0
            switch( $this->feedback ){
                case 'todo':
                    $this->condition["id"] = [
                        'exp',
                        "in (SELECT GROUP_CONCAT(id) FROM $table_order_refund WHERE handle_state in(0,20))",
                    ];
                    break;
                case 'closed':
                    $this->condition["id"] = [
                        'exp',
                        "in (SELECT GROUP_CONCAT(id) FROM $table_order_refund WHERE handle_state in(10,30))",
                    ];
                    break;
            }
        }

    }

    public function alias( string $table_name, string $alias_name ) : Order
    {
        $this->alias[$table_name] = $alias_name;
        return $this;
    }

    public function page( string $page ) : Order
    {
        $this->page = $page;
        return $this;
    }

    public function field( string $field ) : Order
    {
        $this->field = $field;
        return $this;
    }

    public function extend( array $extend ) : Order
    {
        $this->extend = $extend;
        return $this;
    }

    public function order( string $order ) : Order
    {
        $this->order = $order;
        return $this;
    }

    private function make() : \App\Model\Order
    {
        if( $this->make ){
            return $this->make;
        } else{
            $this->buildCondition();
            $model = model( 'Order' );
            $model->alias( $this->alias['order'] );
            return $model;
        }
    }

    public function count() : int
    {
        return $this->make()->where( $this->condition )->count();
    }

    public function list() : array
    {
        return $this->make()->getOrderList( $this->condition, $this->field, $this->order, $this->page, $this->extend );
    }

    /**
     * 支付订单
     * @author   韩文博
     * @param    string $pay_sn
     * @param    string $payment_code
     * @param    string $trade_no
     * @throws \Exception
     * @return   array
     */
    public function pay( string $pay_sn, string $payment_code, string $trade_no ) : bool
    {
        $order_model     = model( 'Order' );
        $order_pay_model = model( 'OrderPay' );
        $order_model->startTrans();
        try{
            // 修改支付状态
            $order_pay_info = $order_pay_model->getOrderPayInfo( ['pay_sn' => $pay_sn, 'pay_state' => 0] );
            if( empty( $order_pay_info ) ){
                throw new \Exception( '订单支付信息不存在' );
            }
            $order_info = $order_model->getOrderInfo( [
                                                          'pay_sn' => $pay_sn,
                                                          'state'  => self::state_new,
                                                      ] );
            if( empty( $order_info ) ){
                throw new \Exception( '订单不存在' );
            }
            $update = $order_pay_model->editOrderPay( ['pay_sn' => $pay_sn], ['pay_state' => 1] );
            if( !$update ){
                $order_model->rollback();
                throw new \Exception( '更新订单支付状态失败' );
            }
            // 修改订单
            $update = $order_model->editOrder( [
                                                   'pay_sn' => $pay_sn,
                                                   'state'  => self::state_new,
                                               ], [
                                                   'state'        => self::state_pay,
                                                   'payment_time' => time(),
                                                   'payment_code' => $payment_code,
                                                   'trade_no'     => $trade_no, //支付宝交易号
                                               ] );
            if( !$update ){
                $order_model->rollback();
                throw new \Exception( '更新订单状态失败' );
            }
            //记录订单日志
            $insert = model( 'OrderLog' )->addOrderLog( [
                                                            'order_id'    => $order_info['id'],
                                                            'role'        => 'buyer',
                                                            'msg'         => "支付成功，支付平台交易号 : {$trade_no}",
                                                            'order_state' => self::state_pay,
                                                        ] );
            if( !$insert ){
                $order_model->rollback();
                throw new \Exception( '记录订单日志出现错误' );
            }
            $order_model->commit();
            return true;
        } catch( \Exception $e ){
            $order_model->rollback();
            \ezswoole\Log::write( "第三方支付通知成功后，更改订单状态失败：".$e->getMessage() );
            return false;
        }
    }
}