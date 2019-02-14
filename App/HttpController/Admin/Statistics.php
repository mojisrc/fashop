<?php
/**
 * 数据统计
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use App\Utils\Time;

/**
 * 数据统计
 * Class Statistics
 * @package App\HttpController\Admin
 */
class Statistics extends Admin
{
	/**
	 * 数量统计
	 */
	public function quantity()
	{
		$no_send_count            = $this->noSendCount();                //未发货订单数量
		$day_total                = $this->dayTotal();                    //当日销售额
		$cost_average             = $this->costAverage();                //平均客单价
		$yesterday_new_user       = $this->yesterdayNewUserCount();    //昨日新增客户
		$all_user                 = $this->allUserCount();                //累计客户
		$positive_count           = $this->allPositiveCount();            //累计好评度
		$yesterday_positive_count = $this->yesterdayPositiveCount();    //昨日好评数
		$yesterday_moderate_count = $this->yesterdayModerateCount();    //昨日中评数
		$yesterday_negative_count = $this->yesterdayNegativeCount();    //昨日差评数
		//		$yesterday_advice_count   = $this->yesterdayAdviceCount();        //昨日建议反馈

		$result['info']['no_send_count']            = $no_send_count;
		$result['info']['day_total']                = $day_total;
		$result['info']['cost_average']             = $cost_average;
		$result['info']['yesterday_new_user']       = $yesterday_new_user;
		$result['info']['all_user']                 = $all_user;
		$result['info']['positive_count']           = $positive_count;
		$result['info']['yesterday_positive_count'] = $yesterday_positive_count;
		$result['info']['yesterday_moderate_count'] = $yesterday_moderate_count;
		$result['info']['yesterday_negative_count'] = $yesterday_negative_count;
		//		$result['info']['yesterday_advice_count']   = $yesterday_advice_count;
		$this->send( Code::success, $result );
	}


	/**
	 * 柱状图-月销售额
	 * @method GET
	 * @param string date 日期 格式：2017-07
	 */
	public function monthSalesHistogram()
	{
		$get  = (array )$this->get;
		$date = date( 'Y-m-d', time() );
		if( isset( $get['date'] ) ){
			$date = $get['date'];
		}
		$beginMonth = date( 'Y-m-01', strtotime( $date ) ); //月初
		$endMonth   = date( 'Y-m-d', strtotime( "$beginMonth +1 month -1 day" ) ); //月末
		$daysSet    = $this->daysNumber( $beginMonth );

		$condition                           = [];
		$condition['order.state']            = ['>=', 20];
		$condition['order_goods.lock_state'] = 0;

		$group = 'days';
		$field = "sum(order_goods.goods_pay_price) as sales,date_format(FROM_UNIXTIME(order.payment_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m-%d') as days";

		$data = \App\Model\Order::init()->where( $condition )->where( [
			'order.payment_time' => ['BETWEEN', [$beginMonth, $endMonth]],
		] )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->field( $field )->order( 'order.payment_time asc' )->group( $group )->select();

		$list = [];
		foreach( $daysSet['list'] as $k => $v ){
			$list[$k]['day']         = date( 'j', strtotime( $v ) );
			$list[$k]['sale_number'] = 0;

			if( $data ){
				foreach( $data as $k1 => $v1 ){
					if( $v1['days'] == $v ){
						$list[$k]['sale_number'] = intval( $v1['sales'] );
					}
				}
			}
		}
		$this->send( Code::success, ['list' => $list] );
	}

	/**
	 * 柱状图-月订单量
	 * @method GET
	 * @param string date 日期 格式：2017-07
	 */
	public function monthOrderCountHistogram()
	{
		$get  = (array )$this->get;
		$date = date( 'Y-m-d', time() );
		if( isset( $get['date'] ) ){
			$date = $get['date'];
		}

		$beginMonth                          = date( 'Y-m-01', strtotime( $date ) ); //月初
		$endMonth                            = date( 'Y-m-d', strtotime( "$beginMonth +1 month -1 day" ) ); //月末
		$daysSet                             = $this->daysNumber( $beginMonth );
		$condition                           = [];
		$condition['order.state']            = ['>=', 20];
		$condition['order_goods.lock_state'] = 0;
		$condition['order.payment_time']     = ['BETWEEN', [$beginMonth, $endMonth]];
		$field                               = "count(order_goods.order_id) as number,date_format(FROM_UNIXTIME(order.payment_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m-%d') as days";
		$group                               = 'days,order_goods.order_id';
		$data                                = \App\Model\OrderGoods::init()->where( $condition )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->field( $field )->order( 'order.payment_time asc' )->group( $group )->select();
		$list                                = [];
		foreach( $daysSet['list'] as $k => $v ){
			$list[$k]['day']          = date( 'j', strtotime( $v ) );
			$list[$k]['order_number'] = 0;

			if( $data ){
				foreach( $data as $k1 => $v1 ){
					if( $v1['days'] == $v ){
						$list[$k]['order_number'] = intval( $v1['number'] );
					}
				}
			}
		}
		$this->send( Code::success, ['list' => $list] );
	}

	/**
	 * 柱状图-客户增量
	 * @method GET
	 * @param string date 日期 格式：2017-07
	 */
	public function monthUserAddCountHistogram()
	{
		$get  = (array )$this->get;
		$date = date( 'Y-m-d', time() );
		if( isset( $get['date'] ) ){
			$date = $get['date'];
		}

		$beginMonth = date( 'Y-m-01', strtotime( $date ) ); //月初
		$endMonth   = date( 'Y-m-d', strtotime( "$beginMonth +1 month -1 day" ) ); //月末
		$daysSet    = $this->daysNumber( $beginMonth );

		$condition['state']       = 1;//默认1 0禁止 1正常
		$condition['is_discard']  = 0;//被丢弃 默认0否 1是[用于绑定后的失效的占位行]
		$condition['id']          = ['>', 1];//超级管理员 临时解决后台用户问题
		$condition['create_time'] = ['BETWEEN'=>[$beginMonth, $endMonth]];
		$group                    = 'days';
		$field                    = "count(id) as number,date_format(FROM_UNIXTIME(create_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m-%d') as days";

		$data = \App\Model\User::init()->where( $condition )->field( $field )->order( 'create_time asc' )->group( $group )->select();

		$list = [];
		foreach( $daysSet['list'] as $k => $v ){
			$list[$k]['day']             = date( 'j', strtotime( $v ) );
			$list[$k]['customer_number'] = 0;

			if( $data ){
				foreach( $data as $k1 => $v1 ){
					if( $v1['days'] == $v ){
						$list[$k]['customer_number'] = intval( $v1['number'] );
					}
				}
			}
		}

		$this->send( Code::success, ['list' => $list] );
	}


	/**
	 * 柱状图-新客户消费
	 * @method GET
	 * @param string date 日期 格式：2017-07
	 */
	public function monthNewUserSalesHistogram()
	{
		$get = (array )$this->get;

		$date = date( 'Y-m-d', time() );
		if( isset( $get['date'] ) ){
			$date = $get['date'];
		}

		$beginMonth = date( 'Y-m-01', strtotime( $date ) ); //月初
		$endMonth   = date( 'Y-m-d', strtotime( "$beginMonth +1 month -1 day" ) ); //月末
		$daysSet    = $this->daysNumber( $beginMonth );

		$condition                           = [];
		$condition['order.state']            = ['>=', 20];
		$condition['order_goods.lock_state'] = 0;

		$group = 'days';
		$field = "sum(order_goods.goods_pay_price) as sales,date_format(FROM_UNIXTIME(order.payment_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m-%d') as days";

		$data = \App\Model\OrderGoods::init()->where( $condition )->where( [
			'order.payment_time' => ['BETWEEN', [$beginMonth, $endMonth]],
		] )->where( 'user.create_time', 'between time', [
			$beginMonth,
			$endMonth,
		] )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->join( 'user', 'order.user_id = user.id', 'LEFT' )->field( $field )->order( 'order.payment_time asc' )->group( $group )->select();

		$list = [];
		foreach( $daysSet['list'] as $k => $v ){
			$list[$k]['day']  = date( 'j', strtotime( $v ) );
			$list[$k]['cost'] = 0;

			if( $data ){
				foreach( $data as $k1 => $v1 ){
					if( $v1['days'] == $v ){
						$list[$k]['cost'] = intval( $v1['sales'] );
					}
				}
			}
		}
		$this->send( Code::success, ['list' => $list] );
	}

	/**
	 * 销售累计
	 * @method GET
	 * @param string date 日期 格式：2017-07
	 */
	public function saleAccumulativeAmount()
	{
		$get = (array )$this->get;

		$date = date( 'Y-m-d', time() );
		if( isset( $get['date'] ) ){
			$date = $get['date'];
		}

		$beginMonth = date( 'Y-m-01', strtotime( $date ) ); //月初
		$endMonth   = date( 'Y-m-d', strtotime( "$beginMonth +1 month -1 day" ) ); //月末

		$condition                           = [];
		$condition['order.state']            = ['>=', 20];
		$condition['order_goods.lock_state'] = 0;

		$accumulative_amount = \App\Model\OrderGoods::init()->where( $condition )->where( [
			'order.payment_time' => ['BETWEEN', [$beginMonth, $endMonth]],
		] )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );

		$this->send( Code::success, ['accumulative_amount' => $accumulative_amount] );


	}

	/**
	 * 销售日均
	 * @method GET
	 * @param string  日期 格式：2017-07
	 */
	public function dayAverage()
	{
		$get = (array )$this->get;

		$date = date( 'Y-m-d', time() );
		if( isset( $get['date'] ) ){
			$date = $get['date'];
		}

		$year  = substr( $date, 0, 4 );
		$month = substr( $date, - 2, 2 );
		$days  = cal_days_in_month( CAL_GREGORIAN, $month, $year ); //计算每月有多少天

		$condition                           = [];
		$condition['order.state']            = ['>=', 20];
		$condition['order_goods.lock_state'] = 0;
		$where                               = "date_format(FROM_UNIXTIME(order.payment_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m')=".'\''.$date.'\'';

		// 获取本月
		$month_amount = \App\Model\OrderGoods::init()->where( $condition )->where( $where )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );

		//认为这种写法也是对的1
		// $beginMonth = date('Y-m-01', strtotime($date)); //月初
		// $endMonth   = date('Y-m-d', strtotime("$beginMonth +1 month -1 day")); //月末
		// $daysSet = $this->daysNumber($beginMonth);
		// $month_amount = \App\Model\OrderGoods::alias('order_goods')->where($condition)->where('order.payment_time', 'between time', [$beginMonth, $endMonth])->join('order', 'order_goods.order_id = order.id', 'LEFT')->sum('order_goods.goods_pay_price');

		if( $month_amount == null ){
			$month_amount = 0;
		}

		// 获取本月日均销售额
		if( $month_amount > 0 ){
			$day_average = sprintf( "%.2f", $month_amount / $days );
		} else{
			$day_average = 0;
		}
		$this->send( Code::success, ['day_average' => $day_average] );
	}


	/**
	 * 天数
	 * @param   string  date    2017-07-27
	 */
	private function daysNumber( $beginMonth )
	{
		$start_time = strtotime( $beginMonth ); //获取本月第一天时间戳
		$days       = date( 't', $start_time ); //获取当前月份天数
		$array      = [];
		for( $i = 0 ; $i < $days ; $i ++ ){
			$array[] = date( 'Y-m-d', $start_time + $i * 86400 ); //每隔一天赋值给数组
		}
		$data['list']  = $array;
		$data['total'] = $days;
		return $data;
	}

	/**
	 * 未发货订单数量
	 */
	private function noSendCount()
	{
		$condition                 = [];
		$condition['state']        = 20;
		$condition['refund_state'] = 0;
		$condition['lock_state']   = 0;
		$no_send_count             = \App\Model\Order::init()->where( $condition )->count();
		return $no_send_count;
	}

	/**
	 * 当日销售额
	 */
	private function dayTotal()
	{
		$condition                           = [];
		$condition['order.state']            = ['>=', 20];
		$condition['order_goods.lock_state'] = 0;

		$day_total = \App\Model\OrderGoods::init()->where( $condition )->where( [
			'order.create_time' => ['BETWEEN', Time::today()],
		] )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );
		return $day_total;
	}

	/**
	 * 平均客单价
	 */
	private function costAverage()
	{
		$condition                           = [];
		$condition['order.state']            = ['>=', 20];
		$condition['order_goods.lock_state'] = 0;

		$all_cost = \App\Model\OrderGoods::init()->where( $condition )->where( [
			'order.create_time' => ['BETWEEN', Time::today()],
		] )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );

		$all_count = \App\Model\OrderGoods::init()->where( $condition )->where( [
			'order.create_time' => ['BETWEEN', Time::today()],
		] )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->count();

		$cost_average = ($all_cost > 0 && $all_count > 0) ? sprintf( "%.2f", ($all_cost / $all_count) ) : 0;

		return $cost_average ? $cost_average : 0;
	}

	/**
	 * 昨日新增客户
	 */
	private function yesterdayNewUserCount()
	{
		$condition               = [];
		$condition['state']      = 1;//默认1 0禁止 1正常
		$condition['is_discard'] = 0;//被丢弃 默认0否 1是[用于绑定后的失效的占位行]
		$condition['id']         = ['>', 1];//超级管理员 临时解决后台用户问题
		$yesterday_new_user      = \App\Model\User::init()->where( $condition )->where( [
			'create_time' => ['BETWEEN', Time::yesterday()],
		] )->count();
		return $yesterday_new_user;
	}

	/**
	 * 累计客户
	 */
	private function allUserCount()
	{
		$condition               = [];
		$condition['state']      = 1;//默认1 0禁止 1正常
		$condition['is_discard'] = 0;//被丢弃 默认0否 1是[用于绑定后的失效的占位行]
		$condition['id']         = ['>', 1];//超级管理员 临时解决后台用户问题
		$all_user                = \App\Model\User::init()->where( $condition )->count();
		return $all_user;
	}

	/**
	 * 累计好评度
	 */
	private function allPositiveCount()
	{
		$positive_count = \App\Model\GoodsEvaluate::init()->where( 'score', 5 )->count();
		return $positive_count;
	}

	/**
	 * 昨日好评数
	 */
	private function yesterdayPositiveCount()
	{
		$yesterday_positive_count = \App\Model\GoodsEvaluate::init()->where( [
			'score'       => 5,
			'create_time' => ['BETWEEN', Time::yesterday()],
		] )->count();
		return $yesterday_positive_count;
	}

	/**
	 * 昨日中评数
	 */
	private function yesterdayModerateCount()
	{
		$yesterday_moderate_count = \App\Model\GoodsEvaluate::init()->where( [
			'score'       => ['IN', [3, 4]],
			'create_time' => ['BETWEEN', Time::yesterday()],
		] )->count();
		return $yesterday_moderate_count;
	}

	/**
	 * 昨日差评数
	 */
	private function yesterdayNegativeCount()
	{
		$yesterday_negative_count = \App\Model\GoodsEvaluate::init()->where( [
			'score'       => ['IN', [1, 2]],
			'create_time' => ['BETWEEN', Time::yesterday()],
		] )->count();
		return $yesterday_negative_count;
	}

	/**
	 * 昨日建议反馈
	 */
	private function yesterdayAdviceCount()
	{
		$yesterday_advice_count = \App\Model\UserAdvice::init()->where( [
			'create_time' => ['BETWEEN', Time::yesterday()],
		] )->count();
		return $yesterday_advice_count;
	}
}

?>