<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/28
 * Time: 下午4:20
 *
 */

namespace App\Logic\Server;


class OrderRefund
{
    /**
     * @var int
     */
    private $orderId;
    /**
     * @var int
     */
    private $orderGoodsId;
    /**
     * @var int
     */
    private $refundType;
    /**
     * @var string
     */
    private $reason;
    /**
     * @var float
     */
    private $refundAmount;
    /**
     * @var string
     */
    private $buyerExplain;
    /**
     * @var array
     */
    private $images;
    /**
     * @var int
     */
    private $reciveState;
    /**
     * @var int
     */
    private $userId;

    /**
     * @return int
     */
    public function getOrderId() : int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId( int $orderId ) : void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return int
     */
    public function getOrderGoodsId() : int
    {
        return $this->orderGoodsId;
    }

    /**
     * @param int $orderGoodsId
     */
    public function setOrderGoodsId( int $orderGoodsId ) : void
    {
        $this->orderGoodsId = $orderGoodsId;
    }

    /**
     * @return int
     */
    public function getRefundType() : int
    {
        return $this->refundType;
    }

    /**
     * @param int $refundType
     */
    public function setRefundType( int $refundType ) : void
    {
        $this->refundType = $refundType;
    }

    /**
     * @return string
     */
    public function getReason() : string
    {
        return $this->reason;
    }

    /**
     * @param string $reson
     */
    public function setReason( string $reason ) : void
    {
        $this->reason = $reason;
    }

    /**
     * @return float
     */
    public function getRefundAmount() : float
    {
        return $this->refundAmount;
    }

    /**
     * @param float $refundAmount
     */
    public function setRefundAmount( float $refundAmount ) : void
    {
        $this->refundAmount = $refundAmount;
    }

    /**
     * @return string
     */
    public function getUserExplain() : string
    {
        return $this->buyerExplain;
    }

    /**
     * @param string $buyerExplain
     */
    public function setUserExplain( string $buyerExplain ) : void
    {
        $this->buyerExplain = $buyerExplain;
    }

    /**
     * @return array
     */
    public function getImages() : array
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages( array $images ) : void
    {
        $this->images = $images;
    }

    /**
     * @return int
     */
    public function getReceiveState() : int
    {
        return $this->reciveState;
    }

    /**
     * @param int $reciveState
     * @throws \Exception
     */
    public function setReceiveState( int $reciveState ) : void
    {
        if( !in_array( $reciveState, [0, 1, 2] ) ){
            throw new \Exception( "recive state error" );
        }
        $this->reciveState = $reciveState;
    }

    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId( int $userId ) : void
    {
        $this->userId = $userId;
    }

    /**
     * @var int
     */
    private $refundId;

    /**
     * @return int
     */
    public function getRefundId() : int
    {
        return $this->refundId;
    }

    /**
     * @param int $refundId
     */
    public function setRefundId( int $refundId ) : void
    {
        $this->refundId = $refundId;
    }


    /**
     * OrderRefund constructor.
     * @param $options
     * @throws \Exception
     */
    public function __construct( $options )
    {
        $this->setUserId( $options['user_id'] );
        $this->setOrderGoodsId( $options['order_goods_id'] );
        $this->setRefundType( $options['refund_type'] );
        $this->setRefundAmount( $options['refund_amount'] );
        $this->setReason( $options['reason'] );
        if( isset( $options['images'] ) ){
            $this->setImages( $options['images'] );
        }
        if( isset( $options['user_explain'] ) ){
            $this->setUserExplain( $options['user_explain'] );
        }
        if( isset( $options['user_receive'] ) && in_array($options['user_receive'],[1,2]) ){
            $this->setReceiveState( $options['user_receive'] );

        }else{
            $this->setReceiveState( 0 );

        }
    }

    /**
     * 创建退款记录
     * @return bool
     * @throws \Exception
     * @author 韩文博
     */
    public function create() : bool
    {
        $order_model      = model( 'Order' );
        $order_goods = $order_model->getOrderGoodsInfo( [
                                                            'id'      => $this->getOrderGoodsId(),
//                                                            'user_id' => $this->getUserId(),
                                                        ], '*' );
        if( !$order_goods ){
            throw new \Exception( "order goods error" );
        }
        if( $order_goods['lock_state'] > 0 ){
            throw new \Exception( "已存在订单退款信息" );
        }

        if( $this->getRefundAmount() > ($order_goods['goods_pay_price'] + $order_goods['goods_freight_fee']) ){
            throw new \Exception( "退款金额不得大于可退金额" );
        }
        $order = $order_model->getOrderInfo( [
                                                 'id'      => $order_goods['order_id'],
//                                                 'user_id' => $this->getUserId(),
                                             ] );
        if( $order['state'] < 20 ){
            throw new \Exception( "订单未支付" );
        }

        $refund_array = [];

        $refund_array['user_receive'] = $this->getReceiveState();

        if( $order['state'] == 20 && $refund_array['user_receive']!=0 ){
            throw new \Exception( "收货参数错误" );
        }

        $refund_model = model( 'OrderRefund' );
        //判断是否已经正在处理或被处理过的订单
        $refund = $refund_model->getOrderRefundInfo( [
                                                         'user_id'        => $order['user_id'],
                                                         'order_id'       => $order_goods['order_id'],
                                                         'order_goods_id' => $order_goods['id'],
                                                         'is_close'       => 0 //默认0 1已关闭(退款关闭)
                                                     ] );

        if( $refund ){
            throw new \Exception( "已经申请退款" );
        }
        // 根据订单状态判断是否可以退款退货
        if( $order['state'] == 20 && $this->getRefundType() == 2 ){
            //1为仅退款,2为退货退款,默认为1
            throw new \Exception( "订单未发货，不支持退款退货" );
        }
        // 拼接要退款信息
        $refund_amount                      = floatval( $this->getRefundAmount() ); // 退款金额
        $refund_array['order_lock']         = 2; //锁定类型:1为不用锁定,2为需要锁定
        $refund_array['refund_type']        = $this->getRefundType(); //1为仅退款,2为退货退款,
        $refund_array['refund_amount']      = \App\Utils\Price::format( $refund_amount );
        $refund_array['user_reason']        = $this->getReason();
        $refund_array['create_time']        = time();
        $refund_array['handle_expiry_time'] = time() + 86400;  //过期时间之管理员处理
        $refund_array['send_expiry_time']   = time() + 86400 * 3;//过期时间之用户发货

        // 退款说明 非必需
        if( $this->getUserExplain() ){
            $refund_array['user_explain'] = $this->getUserExplain();
        }
        // 照片凭证 非必须 最多6张
        if( !empty( $this->images ) ){
            if( count( $this->images ) > 6 ){
                throw new \Exception( "最多6张凭证" );
            } else{
                $refund_array['user_images'] = $this->getImages() ;
            }
        }

        try{
            $refund_model->startTrans();
            $refund_id              = $refund_model->addOrderRefund( $refund_array, $order, $order_goods );
            $refund_result          = $refund_model->editOrderRefund( ['id' => $refund_id], ['refund_sn' => $refund_model->getOrderRefundSn( $refund_id )] );
            $edit_lock_result       = $refund_model->editOrderLock( $order_goods['order_id'], 1 );
            $edit_goods_lock_result = $refund_model->editOrderGoodsLock( $order_goods['id'], $refund_id );

            if( $refund_id > 0 && $refund_result && $edit_lock_result && $edit_goods_lock_result ){
                $refund_model->commit();
                return true;
            } else{
                $refund_model->rollback();
                return false;
            }
        } catch( \Exception $e ){
            $refund_model->rollback();
            throw new \Exception( $e->getMessage() );
        }
    }

}