<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/28
 * Time: 上午9:45
 *
 */

namespace App\Logic;
use EasySwoole\Core\Component\Spl\SplString;
class OrderRefundSearch
{
	/**
	 * @var array
	 */
	private $condition;
	/**
	 * @var string
	 */
	private $keywordsType;
	/**
	 * @var mixed
	 */
	private $keywords;
	/**
	 * @var string
	 */
	private $order = 'id desc';
	/**
	 * @var string
	 */
	private $field = '*';

	/**
	 * @var string
	 */
	private $page;
	/**
	 * @var array
	 */
	private $createTime;
	/**
	 * @var \App\Model\OrderRefund
	 */
	private $make = null;
	/**
	 * @var int
	 */
	private $refundType;
	/**
	 * @var int
	 */
	private $refundState;

	/**
	 * @var int
	 */
	private $orderType;

	/**
	 * @return int
	 */
	public function getOrderType() : int
	{
		return $this->orderType;
	}

	/**
	 * @param int $orderType
	 */
	public function setOrderType( int $orderType ) : void
	{
		$this->orderType = $orderType;
	}


	/**
	 * @return int
	 */
	public function getRefundState() : int
	{
		return $this->refundState;
	}

	/**
	 * @param int $refundState
	 */
	public function setRefundState( int $refundState ) : void
	{
		$this->refundState = $refundState;
	}

	/**
	 * @return array
	 */
	public function getCondition() : array
	{
		return $this->condition;
	}

	/**
	 * @param array $condition
	 */
	public function setCondition( array $condition ) : void
	{
		$this->condition = $condition;
	}

	/**
	 * @return string
	 */
	public function getKeywordsType() : string
	{
		return $this->keywordsType;
	}

	/**
	 * @param string $keywordsType
	 */
	public function setKeywordsType( string $keywordsType ) : void
	{
		$this->keywordsType = $keywordsType;
	}

	/**
	 * @return mixed
	 */
	public function getKeywords()
	{
		return $this->keywords;
	}

	/**
	 * @param mixed $keywords
	 */
	public function setKeywords( $keywords ) : void
	{
		$this->keywords = $keywords;
	}

	/**
	 * @return string
	 */
	public function getOrder() : string
	{
		return $this->order;
	}

	/**
	 * @param string $order
	 */
	public function setOrder( string $order ) : void
	{
		$this->order = $order;
	}

	/**
	 * @return string
	 */
	public function getField() : string
	{
		return $this->field;
	}

	/**
	 * @param string $field
	 */
	public function setField( string $field ) : void
	{
		$this->field = $field;
	}


	/**
	 * @return string
	 */
	public function getPage() : string
	{
		return $this->page;
	}

	/**
	 * @param string $page
	 */
	public function setPage( string $page ) : void
	{
		$this->page = $page;
	}

	/**
	 * @return array
	 */
	public function getCreateTime() : array
	{
		return $this->createTime;
	}

	/**
	 * @param array $createTime
	 */
	public function setCreateTime( array $createTime ) : void
	{
		$this->createTime = $createTime;
	}

	/**
	 * @return \App\Model\OrderRefund
	 */
	public function getMake() : \App\Model\OrderRefund
	{
		return $this->make;
	}

	/**
	 * @param \App\Model\OrderRefund $make
	 */
	public function setMake( \App\Model\OrderRefund $make ) : void
	{
		$this->make = $make;
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

	public function __construct( array $data = [] )
	{
		// todo 获得所有私有变量 ， 不存在不赋值
		if( !empty( $data ) ){
			$string = new SplString();
			foreach( $data as $key => $val ){
				$propertyName          = $string->setString( $key )->camel()->__toString();
				$this->$propertyName = $val;
			}
		}

        if( isset( $options['page'] ) ){
            $this->setPage( $options['page'] );
        }
	}

	public function buildCondition() : void
	{

		$table_prefix       = config( 'database.prefix' );
		$table_order_extend = $table_prefix.'order_extend';

		// 搜索条件：商品名称goods_name 、订单号order_no、收货人姓名 receiver_name、收货人电话 receiver_phone、 退款编号refund_sn
		if( $this->keywordsType && $this->keywords ){
			switch( $this->keywordsType ){
			case 'goods_name':
				$this->condition['goods_title'] = ['like', '%'.$this->keywords.'%'];
			break;
			case 'order_no':
				$this->condition['order_sn'] = ['like', '%'.$this->keywords.'%'];
			break;
			case 'receiver_name':
				$this->condition["order_id"] = [
					'exp',
					"in (SELECT GROUP_CONCAT(id) FROM $table_order_extend WHERE reciver_name LIKE '%".$this->keywords."%' GROUP BY id)",
				];
			break;
			case 'receiver_phone':
				$this->condition["order_id"] = [
					'exp',
					"in (SELECT GROUP_CONCAT(id) FROM $table_order_extend WHERE receiver_phone LIKE '%".$this->keywords."%' GROUP BY id)",
				];
			break;
			case 'refund_sn':
				$this->condition['refund_sn'] = ['like', '%'.$this->keywords.'%'];
			break;
			}
		}

		//refund_type 申请类型:1为仅退款,2为退货退款,默认为1
		if( !empty( $this->refundType ) ){
			$this->condition['refund_type'] = $this->refundType;

		}
		if( !empty( $this->createTime ) ){
			$this->condition['create_time'] = [
				'between',
				$this->createTime,
			];
		}

		// 1 申请退款，等待商家确认 2同意申请，等待买家退货 3买家已发货，等待收货  4已收货，确认退款 5退款成功 6退款关闭
		// 退款关闭状态中应包含商家拒绝的申请，买家主动撤销的申请等

		if( !empty( $this->refundState ) ){
			switch( $this->refundState ){
			case 1:
				$this->condition['handle_state'] = 0; //平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成)
			break;
			case 2:
				$this->condition['handle_state']  = 20; //平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成)
				$this->condition['refund_type']   = 2;  //申请类型:1为仅退款,2为退货退款)
				$this->condition['tracking_no'] = ['EXP', 'IS NULL']; //退款退货物 买家发货流单号
				$this->condition['tracking_time'] = ['eq', '0']; //退款退货物 买家发货时间,默认为0
			break;
			case 3:
				$this->condition['handle_state']  = 20; //平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成)
				$this->condition['refund_type']   = 2;  //申请类型:1为仅退款,2为退货退款)
				$this->condition['tracking_no'] = ['EXP', 'IS NOT NULL']; //退款退货物 买家发货流单号
				$this->condition['tracking_time'] = ['gt', '0']; //退款退货物 买家发货时间,默认为0
				$this->condition['receive'] = 1; //平台是否收到买家退货退款货物 1未收到货 2已收到货
			break;
			case 4:
				$this->condition['handle_state']  = 20; //平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成)
				$this->condition['refund_type']   = 2;  //申请类型:1为仅退款,2为退货退款)
				$this->condition['tracking_no'] = ['EXP', 'IS NOT NULL']; //退款退货物 买家发货流单号
				$this->condition['tracking_time'] = ['gt', '0']; //退款退货物 买家发货时间,默认为0
				$this->condition['receive'] = 2; //平台是否收到买家退货退款货物 1未收到货 2已收到货
			break;
			case 5:
				$this->condition['handle_state'] = 30; //平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成)
			break;
			case 6:
				$this->condition['is_close'] = 1; //默认0未关闭 1已关闭(退款关闭)
			break;
			}
		}
		//order_type 1申请时间早到晚  2申请时间晚到早
		if( !empty( $this->orderType ) ){
			switch( $this->orderType ){
			case 1:
				$this->order = 'id asc';
			break;

			case 2:
				$this->order = 'id desc';
			break;
			}
		}
		$this->field = "*,(SELECT reciver_name FROM {$table_order_extend} WHERE id=order_id) as reciver_name,(SELECT receiver_phone FROM {$table_order_extend} WHERE id=order_id) as receiver_phone";
	}


	public function page( string $page ) : OrderRefundSearch
	{
		$this->page = $page;
		return $this;
	}

	public function field( string $field ) : OrderRefundSearch
	{
		$this->field = $field;
		return $this;
	}

	public function extend( array $extend ) : OrderRefundSearch
	{
		$this->extend = $extend;
		return $this;
	}

	public function order( string $order ) : OrderRefundSearch
	{
		$this->order = $order;
		return $this;
	}

	private function make() : \App\Model\OrderRefund
	{
		if( $this->make ){
			return $this->make;
		} else{
			$this->buildCondition();
			$model = model( 'OrderRefund' );
			return $model;
		}
	}

	public function count() : int
	{
		return $this->make()->where( $this->condition )->count();
	}

	public function list() : array
	{
		return $this->make()->getOrderRefundList( $this->condition, $this->field, $this->order, $this->page );
	}
}