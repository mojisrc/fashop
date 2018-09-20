<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/27
 * Time: 下午1:46
 *
 */

namespace App\Logic;



class UserSearch
{
	/**
	 * @var string
	 */
	private $keywordsType;
	/**
	 * @var string
	 */
	private $keywords;
	/**
	 * @var int
	 */
	private $buyTimes;
	/**
	 * @var float
	 */
	private $costTotal;
	/**
	 * @var float
	 */
	private $costAverage;
	/**
	 * @var array
	 */
	private $registerTime;
	/**
	 * @var array
	 */
	private $lastCostTime;

	/**
	 * @var array
	 */
	private $condition;
	/**
	 * @var string
	 */
	private $page;
	/**
	 * @var \App\Model\User
	 */
	private $make;
	/**
	 * @var string
	 */
	private $field;

	/**
	 * 1购次多到少 2购次少到多 3累计消费多到少 4累计消费少到多 5客单价多到少 6客单价少到多 7最后消费早到晚 8最后消费晚到早
	 * buy_times购买次数  cost_total累计消费  cost_average客单价(平均消费)  last_cost_time最后消费时间
	 * @var int
	 */
	private $orderType;
	/*
	 * 默认排序
	 * @var string
	 */
	private $order = 'id desc';

	public function __construct( array $data = null )
	{
		if( isset( $data['keywords_type'] ) ){
			$this->keywordsType = $data['keywords_type'];
		}
		if( isset( $data['keywords'] ) ){
			$this->keywords = $data['keywords'];
		}
		if( isset( $data['buy_times'] ) ){
			$this->buyTimes = $data['buy_times'];
		}
		if( isset( $data['cost_total'] ) ){
			$this->costTotal = $data['cost_total'];
		}
		if( isset( $data['cost_average'] ) ){
			$this->costAverage = $data['cost_average'];
		}
		if( isset( $data['register_time'] ) ){
			$this->registerTime = $data['register_time'];
		}
		if( isset( $data['last_cost_time'] ) ){
			$this->lastCostTime = $data['last_cost_time'];
		}
		if( isset( $data['order_type'] ) ){
			$this->orderType = $data['order_type'];
		}

		if( isset( $data['last_cost_time'] ) ){
			$this->lastCostTime = $data['last_cost_time'];
		}
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
	 * @return \App\Model\User
	 */
	public function getMake() : \App\Model\User
	{
		return $this->make;
	}

	/**
	 * @param \App\Model\User $make
	 */
	public function setMake( \App\Model\User $make ) : void
	{
		$this->make = $make;
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
	 * @return array
	 */
	public function getCondition() : array
	{
		return $this->condition;
	}

	/**
	 * @param array $this ->condition
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
	 * @return string
	 */
	public function getKeywords() : string
	{
		return $this->keywords;
	}

	/**
	 * @param string $keywords
	 */
	public function setKeywords( string $keywords ) : void
	{
		$this->keywords = $keywords;
	}

	/**
	 * @return int
	 */
	public function getBuyTimes() : int
	{
		return $this->buyTimes;
	}

	/**
	 * @param int $buyTimes
	 */
	public function setBuyTimes( int $buyTimes ) : void
	{
		$this->buyTimes = $buyTimes;
	}

	/**
	 * @return float
	 */
	public function getCostTotal() : float
	{
		return $this->costTotal;
	}

	/**
	 * @param float $costTotal
	 */
	public function setCostTotal( float $costTotal ) : void
	{
		$this->costTotal = $costTotal;
	}

	/**
	 * @return float
	 */
	public function getCostAverage() : float
	{
		return $this->costAverage;
	}

	/**
	 * @param float $costAverage
	 */
	public function setCostAverage( float $costAverage ) : void
	{
		$this->costAverage = $costAverage;
	}

	/**
	 * @return array
	 */
	public function getRegisterTime() : array
	{
		return $this->registerTime;
	}

	/**
	 * @param array $registerTime
	 */
	public function setRegisterTime( array $registerTime ) : void
	{
		$this->registerTime = $registerTime;
	}

	/**
	 * @return array
	 */
	public function getLastCostTime() : array
	{
		return $this->lastCostTime;
	}

	/**
	 * @param array $lastCostTime
	 */
	public function setLastCostTime( array $lastCostTime ) : void
	{
		$this->lastCostTime = $lastCostTime;
	}

	public function buildCondition() : void
	{
        $this->condition               = [];
        $this->condition['is_discard'] = 0;         //被丢弃 默认0否 1是[用于绑定后的失效的占位行]
        $this->condition['id']         = ['gt', 1]; //临时解决后台超级管理员账号问题[不显示后台超级管理员]

        $table_prefix                  = config('database.prefix');
        $table_user                    = $table_prefix . 'user';
        $table_order                   = $table_prefix . 'order';
        $table_order_goods             = $table_prefix . 'order_goods';
        $table_user_profile            = $table_prefix . 'user_profile';
        $table_user_open               = $table_prefix . 'user_open';

		// 搜索条件：姓名name 昵称nickname 手机号phone
		if( $this->keywordsType && $this->keywords ){
			switch( $this->keywordsType ){
			case 'name':
                $condition["(SELECT name FROM ".$table_user_profile." WHERE user_id=".$table_user.".user_id)"] = [
                    'like',
                    '%'.$this->keywords.'%',
                ];			break;
			case 'nickname':
                $condition["(SELECT nickname FROM ".$table_user_profile." WHERE user_id=".$table_user.".user_id)"] = [
                    'like',
                    '%'.$this->keywords.'%',
                ];
			break;
			case 'phone':
				$this->condition['phone'] = ['like', '%'.$this->keywords.'%'];
			break;
			}
		}

        $common_string = "SELECT GROUP_CONCAT(distinct user_id SEPARATOR '_') FROM ".$table_user_open." WHERE user_id=".$table_user.".id";

        //buy_times购买次数  cost_total累计消费  cost_average客单价(平均消费)  last_cost_time最后消费时间
		$buy_times_string = "(SELECT COUNT(*) FROM $table_order WHERE state>=20 AND user_id IN ($common_string))";//计算总订单的所有的已付款的购买次数

		$cost_total_string = "(SELECT IFNULL(SUM(goods_pay_price),0) FROM $table_order_goods WHERE lock_state=0 AND user_id=$table_user.id AND order_id IN (SELECT id FROM $table_order WHERE user_id IN ($common_string) AND state>=20))"; //计算子订单的未退款的累计订单金额

		$cost_average_string = "(SELECT TRUNCATE(IFNULL(AVG(goods_pay_price),0),2) FROM $table_order_goods WHERE lock_state=0 AND user_id=$table_user.id AND order_id IN (SELECT id FROM $table_order WHERE user_id IN ($common_string) AND state>=20))";//计算子订单的未退款的平均消费

		$last_cost_time_string = "(SELECT IFNULL(MAX(create_time),0) FROM $table_order WHERE  state>=20 AND user_id IN ($common_string))";//计算总订单的已付款的最后消费时间

        $profile_string = "(SELECT name FROM {$table_user_profile} WHERE user_id={$table_user}.id) AS name,(SELECT nickname FROM {$table_user_profile} WHERE user_id={$table_user}.id) AS nickname,(SELECT avatar FROM {$table_user_profile} WHERE user_id={$table_user}.id) AS avatar";

		//购买次数
		if( (int)$this->buyTimes > 0 ){
			$this->condition["$buy_times_string"] = ['egt', (int)$this->buyTimes];
		}

		//累计消费
		if( (int)$this->costTotal > 0 ){
			$this->condition["$cost_total_string"] = ['egt', (int)$this->costTotal];
		}

		//客单价(平均消费)
		if( (int)$this->costAverage > 0 ){
			$this->condition["$cost_average_string"] = ['egt', (int)$this->costAverage];
		}


		if( !empty( $get['create_time'] ) ){
			$this->condition['create_time'] = [
				'between',
				[$this->registerTime],
			];
		}

		if( !empty( $this->lastCostTime ) ){
			$this->condition['last_cost_time'] = [
				'between',
				[$this->lastCostTime],
			];
		}

		//1购次多到少 2购次少到多 3累计消费多到少 4累计消费少到多 5客单价多到少 6客单价少到多 7最后消费早到晚 8最后消费晚到早
		//buy_times购买次数  cost_total累计消费  cost_average客单价(平均消费)  last_cost_time最后消费时间
		if( !empty( $this->orderType ) ){
			switch( $this->orderType ){
			case 1:
				$this->order = 'buy_times desc';
			break;

			case 2:
				$this->order = 'buy_times asc';
			break;

			case 3:
				$this->order = 'cost_total desc';
			break;

			case 4:
				$this->order = 'cost_total asc';
			break;

			case 5:
				$this->order = 'cost_average desc';
			break;

			case 6:
				$this->order = 'cost_average asc';
			break;

			case 7:
				$this->order = 'last_cost_time asc';
			break;

			case 8:
				$this->order = 'last_cost_time desc';
			break;

			}
		}
		$this->field = "*,$profile_string,$buy_times_string AS buy_times,$cost_total_string AS cost_total,$cost_average_string AS cost_average,$last_cost_time_string AS last_cost_time";

	}

	public function make() : \App\Model\User
	{
		if( empty( $this->make ) ){
			$this->buildCondition();
			$this->make = model( 'User' );
		}
		return $this->make;
	}

	public function count() : int
	{
		return $this->make()->where( $this->condition )->count();
	}

	public function list() : ? array
	{
		return $this->make()->getUserList( $this->condition, $this->field, $this->order, $this->page );
	}
}