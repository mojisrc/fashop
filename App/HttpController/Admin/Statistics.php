<?php
/**
 * 数据统计
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

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

        $result['info']                             = [];
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

        $order_goods_db = db( 'OrderGoods' );

        $condition                           = [];
        $condition['order.state']            = ['egt', 20];
        $condition['order_goods.lock_state'] = 0;

        $group = 'days';
        $field = "sum(order_goods.goods_pay_price) as sales,date_format(FROM_UNIXTIME(order.payment_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m-%d') as days";

        $data = $order_goods_db->alias( 'order_goods' )->where( $condition )->where( 'order.payment_time', 'between time', [
            $beginMonth,
            $endMonth,
        ] )->join( 'order order', 'order_goods.order_id = order.id', 'LEFT' )->field( $field )->order( 'order.payment_time asc' )->group( $group )->select();

        $list = [];
        foreach( $daysSet['list'] as $k => $v ){
            $list[$k]['day']         = date('j',strtotime($v));
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
        $get = (array )$this->get;

        $date = date( 'Y-m-d', time() );
        if( isset( $get['date'] ) ){
            $date = $get['date'];
        }

        $beginMonth = date( 'Y-m-01', strtotime( $date ) ); //月初
        $endMonth   = date( 'Y-m-d', strtotime( "$beginMonth +1 month -1 day" ) ); //月末
        $daysSet    = $this->daysNumber( $beginMonth );


        $order_goods_db = db( 'OrderGoods' );

        $condition                           = [];
        $condition['order.state']            = ['egt', 20];
        $condition['order_goods.lock_state'] = 0;

        $group = 'days';
        $group = $group.',order_goods.order_id';
        $field = "count(order_goods.order_id) as number,date_format(FROM_UNIXTIME(order.payment_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m-%d') as days";

        $data = $order_goods_db->alias( 'order_goods' )->where( $condition )->where( 'order.payment_time', 'between time', [
            $beginMonth,
            $endMonth,
        ] )->join( 'order order', 'order_goods.order_id = order.id', 'LEFT' )->field( $field )->order( 'order.payment_time asc' )->group( $group )->select();

        $list = [];
        foreach( $daysSet['list'] as $k => $v ){
            $list[$k]['day']          = date('j', strtotime($v));
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

        $user_db                 = db('User');
        $condition['state']      = 1;//默认1 0禁止 1正常
        $condition['is_discard'] = 0;//被丢弃 默认0否 1是[用于绑定后的失效的占位行]
        $condition['id']         = ['gt', 1];//超级管理员 临时解决后台用户问题

        $group = 'days';
        $field = "count(id) as number,date_format(FROM_UNIXTIME(create_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m-%d') as days";

        $data = $user_db->where( $condition )->where( 'create_time', 'between time', [
            $beginMonth,
            $endMonth,
        ] )->field( $field )->order( 'create_time asc' )->group( $group )->select();

        $list = [];
        foreach( $daysSet['list'] as $k => $v ){
            $list[$k]['day']             = date('j', strtotime($v));
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

        $order_goods_db = db( 'OrderGoods' );

        $condition                           = [];
        $condition['order.state']            = ['egt', 20];
        $condition['order_goods.lock_state'] = 0;

        $group = 'days';
        $field = "sum(order_goods.goods_pay_price) as sales,date_format(FROM_UNIXTIME(order.payment_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m-%d') as days";

        $data = $order_goods_db->alias( 'order_goods' )->where( $condition )->where( 'order.payment_time', 'between time', [
            $beginMonth,
            $endMonth,
        ] )->where( 'user.create_time', 'between time', [
            $beginMonth,
            $endMonth,
        ] )->join( '__ORDER__ order', 'order_goods.order_id = order.id', 'LEFT' )->join( '__USER__ user', 'order.user_id = user.id', 'LEFT' )->field( $field )->order( 'order.payment_time asc' )->group( $group )->select();

        $list = [];
        foreach( $daysSet['list'] as $k => $v ){
            $list[$k]['day']  = date('j', strtotime($v));
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

        $order_goods_db = db( 'OrderGoods' );

        $condition                           = [];
        $condition['order.state']            = ['egt', 20];
        $condition['order_goods.lock_state'] = 0;

        $accumulative_amount = $order_goods_db->alias( 'order_goods' )->where( $condition )->where( 'order.payment_time', 'between time', [
            $beginMonth,
            $endMonth,
        ] )->join( '__ORDER__ order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );

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

        $order_goods_db = db( 'OrderGoods' );

        $condition                           = [];
        $condition['order.state']            = ['egt', 20];
        $condition['order_goods.lock_state'] = 0;
        $where                               = "date_format(FROM_UNIXTIME(order.payment_time, '%Y-%m-%d %H:%i:%S'),'%Y-%m')=".'\''.$date.'\'';

        // 获取本月
        $month_amount = $order_goods_db->alias( 'order_goods' )->where( $condition )->where( $where )->join( '__ORDER__ order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );

        //认为这种写法也是对的1
        // $beginMonth = date('Y-m-01', strtotime($date)); //月初
        // $endMonth   = date('Y-m-d', strtotime("$beginMonth +1 month -1 day")); //月末
        // $daysSet = $this->daysNumber($beginMonth);
        // $month_amount = $order_goods_db->alias('order_goods')->where($condition)->where('order.payment_time', 'between time', [$beginMonth, $endMonth])->join('__ORDER__ order', 'order_goods.order_id = order.id', 'LEFT')->sum('order_goods.goods_pay_price');

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
     * 获取去年的时间戳
     */
    private function getLastYear()
    {
        $mytime = date( "Ymd", strtotime( "-1 year" ) ); //获取格式为2017-06-05
        return $mytime;
    }

    /**
     * 获取指定日期段内每一天的日期
     * @param  string $startdate 开始日期
     * @param  string $enddate   结束日期
     */
    private function getDateFromRange( $startdate, $enddate )
    {
        $stimestamp = strtotime( $startdate );
        $etimestamp = strtotime( $enddate );

        // 计算日期段内有多少天
        $days = ($etimestamp - $stimestamp) / 86400 + 1;
        // 保存每天日期
        $date = [];
        for( $i = 0 ; $i < $days ; $i ++ ){
            $date[] = date( 'Ymd', $stimestamp + (86400 * $i) );
        }
        return $date;
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
        $order_db                  = db( 'Order' );
        $condition                 = [];
        $condition['state']        = 20;
        $condition['refund_state'] = 0;
        $condition['lock_state']   = 0;
        $no_send_count             = $order_db->where( $condition )->count();
        return $no_send_count;
    }

    /**
     * 当日销售额
     */
    private function dayTotal()
    {
        $order_goods_db = db( 'OrderGoods' );

        $condition                           = [];
        $condition['order.state']            = ['egt', 20];
        $condition['order_goods.lock_state'] = 0;

        $day_total = $order_goods_db->alias( 'order_goods' )->where( $condition )->whereTime( 'order.create_time', 'd' )->join( '__ORDER__ order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );
        return $day_total;
    }

    /**
     * 平均客单价
     */
    private function costAverage()
    {
        $order_goods_db                      = db('OrderGoods');
        $condition                           = [];
        $condition['order.state']            = ['egt', 20];
        $condition['order_goods.lock_state'] = 0;

        $all_cost = $order_goods_db->alias( 'order_goods' )->where( $condition )->whereTime( 'order.create_time', 'today' )->join( '__ORDER__ order', 'order_goods.order_id = order.id', 'LEFT' )->sum( 'order_goods.goods_pay_price' );

        $all_count = $order_goods_db->alias( 'order_goods' )->where( $condition )->whereTime( 'order.create_time', 'today' )->join( '__ORDER__ order', 'order_goods.order_id = order.id', 'LEFT' )->count();

        $cost_average = ($all_cost>0 && $all_count>0) ? sprintf( "%.2f", ($all_cost / $all_count) ) : 0;

        return $cost_average ? $cost_average : 0;
    }

    /**
     * 昨日新增客户
     */
    private function yesterdayNewUserCount()
    {
        $user_db                 = db('User');
        $condition               = [];
        $condition['state']      = 1;//默认1 0禁止 1正常
        $condition['is_discard'] = 0;//被丢弃 默认0否 1是[用于绑定后的失效的占位行]
        $condition['id']         = ['gt', 1];//超级管理员 临时解决后台用户问题
        $yesterday_new_user      = $user_db->where($condition)->whereTime('create_time', 'yesterday')->count();
        return $yesterday_new_user;
    }

    /**
     * 累计客户
     */
    private function allUserCount()
    {
        $user_db                 = db('User');
        $condition               = [];
        $condition['state']      = 1;//默认1 0禁止 1正常
        $condition['is_discard'] = 0;//被丢弃 默认0否 1是[用于绑定后的失效的占位行]
        $condition['id']         = ['gt', 1];//超级管理员 临时解决后台用户问题
        $all_user                = $user_db->where($condition)->count();
        return $all_user;
    }
    /**
     * 累计好评度
     */
    private function allPositiveCount()
    {
        $positive_count = model( 'GoodsEvaluate' )->where( 'score', 5 )->count();
        return $positive_count;
    }

    /**
     * 昨日好评数
     */
    private function yesterdayPositiveCount()
    {
        $yesterday_positive_count = model( 'GoodsEvaluate' )->where( 'score', 5 )->whereTime( 'create_time', 'yesterday' )->count();
        return $yesterday_positive_count;
    }

    /**
     * 昨日中评数
     */
    private function yesterdayModerateCount()
    {
        $yesterday_moderate_count = model( 'GoodsEvaluate' )->where( 'score', '3,4' )->whereTime( 'create_time', 'yesterday' )->count();
        return $yesterday_moderate_count;
    }

    /**
     * 昨日差评数
     */
    private function yesterdayNegativeCount()
    {
        $yesterday_negative_count = model( 'GoodsEvaluate' )->where( 'score', '1,2' )->whereTime( 'create_time', 'yesterday' )->count();
        return $yesterday_negative_count;
    }

    /**
     * 昨日建议反馈
     */
    private function yesterdayAdviceCount()
    {
        $yesterday_advice_count = model( 'UserAdvice' )->whereTime( 'create_time', 'yesterday' )->count();
        return $yesterday_advice_count;
    }
}

?>