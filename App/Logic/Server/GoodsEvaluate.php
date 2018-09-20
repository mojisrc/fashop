<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/28
 * Time: 下午5:52
 *
 */

namespace App\Logic\Server;


class GoodsEvaluate
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
	private $score;
	/**
	 * @var array
	 */
	private $images;
	/**
	 * @var int
	 */
	private $isAnonymous;
	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var array
	 */
	private $options;

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
	 * @return array
	 */
	public function getOptions() : array
	{
		return $this->options;
	}

	/**
	 * @param array $options
	 */
	public function setOptions( array $options ) : void
	{
		$this->options = $options;
	}

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
	public function getScore() : int
	{
		return $this->score;
	}

	/**
	 * @param int $score
	 */
	public function setScore( int $score ) : void
	{
		$this->score = $score;
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
	public function getisAnonymous() : int
	{
		return $this->isAnonymous;
	}

	/**
	 * @param int $isAnonymous
	 */
	public function setIsAnonymous( int $isAnonymous ) : void
	{
		$this->isAnonymous = $isAnonymous;
	}

	/**
	 * @return string
	 */
	public function getContent() : string
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 */
	public function setContent( string $content ) : void
	{
		$this->content = $content;
	}

	public function __construct( array $options = [] )
	{
		$this->setOptions( $options );
	}

	/**
	 * 对订单商品进行评价
	 * @param int order_goods_id 订单商品表的id
	 * @param int score 分数
	 * @param array images 评价图片 数组
	 * @param int is_anonymous 是否匿名 1是0否
	 * @param string content 评价内容
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function create()
	{
		// todo 严格验证
		$options = $this->getOptions();
		$this->setOrderGoodsId( $options['order_goods_id'] );
		$this->setScore( $options['score'] );
		$this->setUserId( $options['user_id'] );
		if( isset( $options['images'] ) ){
			$this->setImages( $options['images'] );
		}else{
            $this->setImages( [] );
        }

		if( isset( $options['is_anonymous'] ) ){
			$this->setIsAnonymous( $options['is_anonymous'] );
		}
		if( isset( $options['content'] ) ){
			$this->setContent( $options['content'] );
		}
		/**
		 * @var $order_model \App\Model\Order
		 */
		$order_model          = model( 'Order' );
		$order_goods_model    = model( 'OrderGoods' );
		$goods_evaluate_model = model( 'GoodsEvaluate' );
		// 获取订单商品
		$order_goods_info = $order_goods_model->getOrderGoodsInfo( [
			'id'      => $this->getOrderGoodsId(),
			'user_id' => $this->getUserId(),
		] );
        if( empty( $order_goods_info ) ){
            throw new \Exception( "订单不存在该商品" );
        }
		$this->setOrderId($order_goods_info['order_id']);
		//获取订单信息
		$order_info = $order_model->getOrderInfo( [
			'id'      => $this->getOrderId(),
			'user_id' => $this->getUserId(),
		] );

		$order_info['evaluate_goods_able'] = $order_model->getOrderOperateState( 'evaluate_goods', $order_info );
		// 验证是否可评价
		if( empty( $order_info ) || !$order_info['evaluate_goods_able'] ){
			throw new \Exception( "不能存在该订单" );
		}

		// 判断是否已经评价过了
		$evaluate_find = $goods_evaluate_model->where( 'order_goods_id', '=', $this->getOrderGoodsId() )->find();
		if( $evaluate_find ){
			throw new \Exception( "已经评价了" );
		}
		// 如果未评分，默认为5分
		$evaluate_score = intval( $this->getScore() );
		if( $evaluate_score <= 0 || $evaluate_score > 5 ){
			$evaluate_score = 5;
		}
		$goods_evaluate_model->startTrans();
		try{
			$add_state  = $goods_evaluate_model->addGoodsEvaluate( [
				'order_id'       => $this->getOrderId(),
				'order_no'       => $order_info['sn'],
				'goods_id'       => $order_goods_info['goods_id'],
				'goods_sku_id'   => $order_goods_info['goods_sku_id'],
				'goods_title'    => $order_goods_info['goods_title'],
				'goods_price'    => $order_goods_info['goods_price'],
				'goods_img'      => $order_goods_info['goods_img'],
				'order_goods_id' => $this->getOrderGoodsId(),
				'images'         => $this->getImages(),
				'score'          => $evaluate_score,
				'content'        => $this->getContent() ? $this->getContent() : '不错哦',
				'is_anonymous'   => $this->getisAnonymous() ? 1 : 0,
				'user_id'        => $this->getUserId(),
			] );
			$edit_state = $order_goods_model->editOrderGoods( ['id' => $order_goods_info['id']], [
				'evaluate_state' => 1,
				'evaluate_time'  => time(),
			] );

			$order_state = 1;
            $no_evaluate_order_goods_id = $order_goods_model->getOrderGoodsId( ['order_id'=>$order_info['id'],'evaluate_state'=>0,'id'=>['neq',$order_goods_info['id']]] );
            if( !($no_evaluate_order_goods_id >0) ){
                $order_state = $order_model->editOrder( ['id'=>$order_info['id']], ['evaluate_state'=>1] );
            }

			$log_state  = model( 'OrderLog' )->addOrderLog( [
				'order_id' => $this->getOrderId(),
				'role'     => '买家',
				'msg'      => '买家评价了',
			] );
			if( $add_state && $edit_state && $log_state && $order_state){
				$goods_evaluate_model->commit();
				return true;
			} else{
				$goods_evaluate_model->rollback();
				return false;
			}
		} catch( \Exception $e ){
			throw new $e;
		}
	}

	/**
	 * 对订单商品进行追加评价
	 * @param int order_goods_id 订单商品表的id
	 * @param array additional_images 评价图片 数组
	 * @param string additional_content 评价内容
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function append()
	{
		// todo 严格验证
		$options = $this->getOptions();
		$this->setOrderGoodsId( $options['order_goods_id'] );
		$this->setUserId( $options['user_id'] );
		if( isset( $options['additional_images'] ) ){
			$this->setImages( $options['additional_images'] );
		}else{
            $this->setImages( [] );
        }

		if( isset( $options['additional_content'] ) ){
			$this->setContent( $options['additional_content'] );
		}

		$order_model          = model( 'Order' );
		$goods_evaluate_model = model( 'GoodsEvaluate' );

		//获取订单信息
        $order_goods_info = $order_model->getOrderGoodsInfo( [
			'id'             => $this->getOrderGoodsId(),
			'user_id'        => $this->getUserId(),
			'evaluate_state' => 1,
		] );

		if( empty( $order_goods_info ) ){
			throw new \Exception( "订单不存在该商品" );
		}
		// 判断是否已经评价过了
		$evaluate_find = $goods_evaluate_model->where( ['order_goods_id' => $this->getOrderGoodsId()] )->find();
		if( !$evaluate_find ){
			throw new \Exception( "评价信息错误" );
		}

		$goods_evaluate_model->startTrans();
		try{
			$edit_state = $goods_evaluate_model->editGoodsEvaluate( ['id' => $evaluate_find['id']], [
				'additional_images'  => $this->getImages(),
				'additional_content' => $this->getContent(),
				'additional_time'    => time(),
			] );

			$order_goods_state = model( 'OrderGoods' )->editOrderGoods( ['id' => $order_goods_info['id']], [
				'evaluate_state' => 2,
			] );
			$log_state         = model( 'Order' )->addOrderLog( [
				'order_id' => $order_goods_info['order_id'],
				'role'     => '买家',
				'msg'      => '买家追加评价了',
			] );
			if( $edit_state && $order_goods_state && $log_state ){
				$goods_evaluate_model->commit();
				return true;
			} else{
				$goods_evaluate_model->rollback();
				return false;
			}
		} catch( \Exception $e ){
			throw new $e;
		}
	}

}