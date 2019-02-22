<?php
/**
 * 数据流量统计
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2016 WenShuaiKeJi Inc. (http://www.wenshuai.cn)
 * @license    http://www.wenshuai.cn
 * @link       http://www.wenshuai.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 流量统计
 * Class Order
 * @package App\HttpController\Admin
 */
class Analysis extends Admin
{

    public $create_time;
    public $start_date;
    public $end_date;
    public $date_arr;//用于曲线数组合并
    public $front_time;//当前时间的之前时间

    public function _initialize() {
        parent::_initialize();

        $param = !empty( $this->post ) ? $this->post : $this->get;
        if( isset( $param['create_time'] ) ){
            //当前时间条件
            $this->create_time = [
                'between',
                $param['create_time'],
            ];
            $this->start_date = strtotime($param[0]);
            $this->end_date = strtotime($param[1]);
        }else{
            $this->end_date = time();
            $this->start_date = strtotime("-6days",strtotime(date('Y-m-d', $this->end_date)));
            //当前时间条件
            $this->create_time = [
                'between',
                [$this->start_date, $this->end_date],
            ];
        }

        // 计算日期段内有多少天
        $days = intval(($this->end_date - $this->start_date)  / 86400) + 1;
        // 保存每天日期
        for($i = 0; $i < $days; $i++){
            $this->date_arr[]['date_time'] = date('Y-m-d', $this->start_date + (86400 * $i));
        }
        //当前时间之前的时间条件
        $this->front_time = [
            'between',
            [$this->start_date - ( $days * 86400 ), $this->start_date],
        ];
    }


	/**
	 * 流量概览(访客数，分享访问人数，商品访客数，浏览量，分享访问次数，商品浏览量)
	 * @method GET | POST
	 * @param array  $create_time      [开始时间,结束时间]
	 */
	public function list()
	{
        $analysisModel = new \App\Model\Analysis;
        //访客数
        $visitor_num['create_time'] = $this->create_time;
		$visitor_num = $analysisModel->where( $visitor_num )->count( 'DISTINCT user_id' );

        //分享访问人数
        $share_visit_people_where['relation_user_id'] = ['>', 0];
        $share_visit_people_where['create_time'] = $this->create_time;
        $share_visit_people_num = $analysisModel->where( $share_visit_people_where )->count( 'DISTINCT relation_user_id' );

        //商品访客数
        $goods_visitor_where['create_time'] = $this->create_time;
        $goods_visitor_where['link_id'] = 1;
        $goods_visitor_num = $analysisModel->where( $goods_visitor_where )->count( 'DISTINCT user_id' );

        //商品曝光数
        $goods_exposure_where['create_time'] = $this->create_time;
        $goods_exposure_where['page_type'] = 2;
        $goods_exposure_num = $analysisModel->where( $goods_exposure_where )->count();

        //浏览量
        $view_where['create_time'] = $this->create_time;
        $view_num = $analysisModel->where( $view_where )->count();

        //分享的访问次数
        $share_visit_where['create_time'] = $this->create_time;
        $share_visit_where['relation_user_id'] = ['>', 0];
        $share_visit_num = $analysisModel->where( $share_visit_where )->count();

        //商品浏览量
        $goods_view_where['create_time'] = $this->create_time;
        $goods_view_where['link_id'] = 1;
        $goods_view_num = $analysisModel->where( $goods_view_where )->count();

        $this->send( Code::success, [
            'visitor_num' => $visitor_num,
            'share_visit_people_num' => $share_visit_people_num,
            'goods_visitor_num' => $goods_visitor_num,
            'goods_exposure_num' => $goods_exposure_num,
            'view_num' => $view_num,
            'share_visit_num' => $share_visit_num,
            'goods_view_num' => $goods_view_num,
        ] );
	}


    /**
     * 页面类型
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function pageType()
    {
        $analysisModel = new \App\Model\Analysis;
        //访客数
        $condition['create_time'] = $this->create_time;
        $condition['page_type'] = ['>', 0];
        $field = 'page_type,count(page_type) as total';
        $order = 'total desc';
        $group = 'page_type';
        $list = $analysisModel->getList($condition, $field, $order, $group);
        $this->send( Code::success, [
            'list' => $list,
        ] );
    }



    /**
     * 访问来源
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function source()
    {
        $analysisModel = new \App\Model\Analysis;
        //访客数
        $condition['create_time'] = $this->create_time;
        $condition['source'] = ['>=', 0];
        $field = 'source,count(source) as total';
        $order = 'total desc';
        $group = 'source';
        $list = $analysisModel->getList($condition, $field, $order, $group);
        $this->send( Code::success, [
            'list' => $list,
        ] );
    }



    /**
     * 单页面流量数据（待定，没想好查询写法）
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function flow()
    {
        $analysisModel = new \App\Model\Analysis;
        //访客数
        $condition['create_time'] = $this->create_time;

        $list = $analysisModel->field( 'page_name' )->where( $condition )->group( 'page_name' )->select();
        $this->send( Code::success, [
            'list' => $list,
        ] );
    }



    /**
     * 访问深度
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function depth()
    {
        $analysisModel = new \App\Model\Analysis;
        //访客数
        $condition['create_time'] = $this->create_time;
        $condition['page_depth'] = ['>', 0];
        $field = 'page_depth,count(page_depth) as visitor_num';
        $order = 'total desc';
        $group = 'page_depth';
        $list = $analysisModel->getList($condition, $field, $order, $group);
        $this->send( Code::success, [
            'list' => $list,
        ] );
    }





    /**
     * 访客地域分布
     * 注意：排序时间段必须都一样或者都是默认的排序日期从小到达
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function region()
    {
        $analysisModel = new \App\Model\Analysis;

        //浏览量
        $condition['create_time'] = $this->create_time;
        $condition = 'city is not null';
        $list = $analysisModel->field( "count(id) as view_num, city" )->where( $condition )->group( 'city' )->select();

        //访客数
        $visitor_num = $analysisModel->field('count(distinct(user_id)) as visitor_num,city')->where($condition)->group('city')->select();
        $list = \App\Utils\Analysis::conver($list, $visitor_num, 'visitor_num', 'city');


        $where['create_time'] = $this->create_time;
        $where['link_id'] = 1;
        $where = 'city is not null';
        //商品浏览量
        $goods_view_num = $analysisModel->field( "count(id) as goods_view_num,city" )->where( $where )->group( 'city' )->select();
        $list = \App\Utils\Analysis::conver($list, $goods_view_num, 'goods_view_num', 'city');

        //商品访客数
        $goods_visitor_num = $analysisModel->field('count(distinct(user_id)) as goods_visitor_num,city')->where($where)->group('city')->select();
        $list = \App\Utils\Analysis::conver($list, $goods_visitor_num, 'goods_visitor_num', 'city');

        return $this->send( Code::success, [
            'list' => $list,
        ] );
    }





    /*以下是每日流量*/
    /**
     * 按天流量查看
     * 注意：排序时间段必须都一样或者都是默认的排序日期从小到达
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function dailyDischarge()
    {
        $analysisModel = new \App\Model\Analysis;
        $condition['create_time'] = $this->create_time;
        //浏览量
        $list = $analysisModel->field( "count(id) as view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $condition )->group( 'date_time' )->select();

        //访客数
        $visitor_num = $analysisModel->field("count(distinct(user_id)) as visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time")->where($condition)->group('date_time')->select();
        $list = \App\Utils\Analysis::conver($list, $visitor_num, 'visitor_num', 'date_time');


        //商品浏览量
        $where['create_time'] = $this->create_time;
        $where['link_id'] = 1;
        $goods_view_num = $analysisModel->field( "count(id) as goods_view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $where )->group( 'date_time' )->select();
        $list = \App\Utils\Analysis::conver($list, $goods_view_num, 'goods_view_num', 'date_time');

        //商品访客数
        $goods_visitor_num = $analysisModel->field('count(distinct(user_id)) as goods_visitor_num,city')->where($where)->group('date_time')->select();
        $list = \App\Utils\Analysis::conver($list, $goods_visitor_num, 'goods_visitor_num', 'date_time');

        $this->send( Code::success, [
            'list' => $list,
        ] );
    }



    /**
     * 详细数据
     * 注意：排序时间段必须都一样或者都是默认的排序日期从小到达
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function detailedData()
    {
        $analysisModel = new \App\Model\Analysis;
        $condition['create_time'] = $this->create_time;
        //浏览量
        $list = $analysisModel->field( "count(id) as view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $condition )->group( 'date_time' )->select();

        //访客数
        $visitor_num = $analysisModel->field("count(distinct(user_id)) as visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time")->where($condition)->group('date_time')->select();
        $list = \App\Utils\Analysis::conver($list, $visitor_num, 'visitor_num', 'date_time');


        //商品浏览量
        $where['create_time'] = $this->create_time;
        $where['link_id'] = 1;
        $goods_view_num = $analysisModel->field( "count(id) as goods_view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $where )->group( 'date_time' )->select();
        $list = \App\Utils\Analysis::conver($list, $goods_view_num, 'goods_view_num', 'date_time');

        //商品访客数
        $goods_visitor_num = $analysisModel->field('count(distinct(user_id)) as goods_visitor_num,city')->where($where)->group('date_time')->select();
        $list = \App\Utils\Analysis::conver($list, $goods_visitor_num, 'goods_visitor_num', 'date_time');


        //分享访问次数
        $share_where['create_time'] = $this->create_time;
        $share_where['relation_user_id'] = ['>', 0];
        $share_num = $analysisModel->field( "count(id) as share_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $share_where )->group( 'date_time' )->select();
        $list = \App\Utils\Analysis::conver($list, $share_num, 'share_num', 'date_time');

        //分享访问人数
        $goods_visitor_num = $analysisModel->field('count(distinct(user_id)) as goods_visitor_num,city')->where($share_where)->group('date_time')->select();
        $list = \App\Utils\Analysis::conver($list, $goods_visitor_num, 'goods_visitor_num', 'date_time');


        $this->send( Code::success, [
            'list' => $list,
        ] );
    }


    /* 商品分析 */

    /**
     * 商品整体情况（有逻辑需问：在家商品数如何根据给的时间条件计算呢）
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */





    /**
     * 商品趋势分析图（有逻辑需问：在家商品数如何根据给的时间条件计算呢）
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */




    /**
     * 商品支付金额top
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function goodsPriceRank(){
        $goodsModel = new \App\Model\Order;
        $condition['payment_time'] = ['>', 0];
        $field = 'sum(goods_price) as total_price,goods_title,goods_img,goods_id';
        $order = 'total_price desc';
        $group = 'goods_id';
        $list = $goodsModel->field( $field )->join('order_goods', 'order.id = order_goods.order_id', 'LEFT')->where($condition)->group( $group )->select();
        return $this->send( Code::success, [
            'list' => $list,
        ] );
    }

    /**
     * 访客数TOP
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function visitorRank(){
        $analysisModel = new \App\Model\Analysis;
        $condition['analysis.create_time'] = $this->create_time;
        $condition['link_id'] = 1;
        $condition['link_pk'] = ['>', 0];
        $field = 'count(distinct(user_id)) as visitor_total,title,images,goods.id';
        $order = 'visitor_total desc';
        $group = 'link_pk';
        $list = $analysisModel->field( $field )->join('goods', 'analysis.link_pk = goods.id', 'LEFT')->where( $condition )->order( $order )->group( $group )->select();


        //获取商品id
        $goods_id = [];
        foreach($list as $key => $val){
            $goods_id[] = $val['id'];
        }
        $ordergoodsModel = new \App\Model\OrderGoods;
        $where['goods_id'] = ['in', $goods_id];
        $where['order.payment_time'] = ['>', 0];
        $field = 'count(order_goods.id) as payment_num,order_goods.goods_id';
        $order = 'payment_num desc';
        $group = 'goods_id';
        $result = $ordergoodsModel->field( $field )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->where( $where )->order( $order )->group( $group )->select();

        foreach($list as $list_key => $list_val){
            $list[$list_key]['images'] = json_decode($list_val['images']);
            foreach($result as $key => $val){
                if($list_val['id'] == $val['goods_id']){
                    $list[$list_key]['conversion'] = (round($val['payment_num'] / $list_val['visitor_total'],2) * 100) . '%';
                }else{
                    if(!isset($list_val['conversion']) || empty($list_val['conversion'])){
                        $list[$list_key]['conversion'] = 0;
                    }
                }
            }
        }

        return $this->send( Code::success, [
            'list' => $list,
        ] );
    }



    /* 交易概括 */

    /**
     * 交易概括
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function transactionSurvey(){
        $analysisModel = new \App\Model\Analysis;
        $orderModel = new \App\Model\Order;

        /*当前*/
        $condition['create_time'] = $this->create_time;
        //访客数
        $visitor_num = $analysisModel->where( $condition )->count( 'DISTINCT user_id' );

        //下单人数
        $people_num = $orderModel->where( $condition )->count( 'DISTINCT user_id' );

        //下单笔数
        $order_num = $orderModel->where( $condition )->count();

        //下单金额
        $order_total_price = $orderModel->where( $condition )->sum( 'amount' );

        //支付人数
        $condition['payment_time'] = ['>', 0];
        $payment_people_num = $orderModel->where( $condition )->count( 'DISTINCT user_id' );

        //支付订单数
        $payment_order_num = $orderModel->where( $condition )->count();

        //支付金额
        $payment_total_price = $orderModel->where( $condition )->count( 'amount' );

        //支付件数
        $payment_num = $orderModel->where( $condition )->count( 'goods_num' );

        //客单价
        $unit_price = ceil($order_total_price / $visitor_num);




        /*之前*/
        $where['create_time'] = $this->front_time;//当前时间的之前时间
        //访客数
        $front_visitor_num = $analysisModel->where( $where )->count( 'DISTINCT user_id' );
        $front_visitor_num = $front_visitor_num ? $front_visitor_num : 20;

        //下单人数
        $front_people_num = $orderModel->where( $where )->count( 'DISTINCT user_id' );

        //下单笔数
        $front_order_num = $orderModel->where( $where )->count();

        //下单金额
        $front_order_total_price = $orderModel->where( $where )->sum( 'amount' );

        //支付人数
        $where['payment_time'] = ['>', 0];
        $front_payment_people_num = $orderModel->where( $where )->count( 'DISTINCT user_id' );

        //支付订单数
        $front_payment_order_num = $orderModel->where( $where )->count();

        //支付金额
        $front_payment_total_price = $orderModel->where( $where )->count( 'amount' );

        //支付件数
        $front_payment_num = $orderModel->where( $where )->count( 'goods_num' );

        //客单价
        $front_unit_price = ceil($order_total_price / $visitor_num);

        //访客数和下单的转化率
        $people_visitor_current = round( $people_num / $visitor_num, 2);

        //下单和付款的转化率
        $payment_people_current = round(  $front_payment_people_num / $people_num, 2);

        //访客和付款的转化率
        $visitor_payment_people_current = round(  $front_payment_people_num / $visitor_num, 2);

        //修改下：不在返回里面去计算转换率，让前端去转换。利于代码整洁
        return $this->send( Code::success, [
            'people_visitor_current' => $people_visitor_current,
            'payment_people_current' => $payment_people_current,
            'visitor_payment_people_current' => $visitor_payment_people_current,
            'visitor_num' => [
                'conversion' => round(($visitor_num - $front_visitor_num) / $front_visitor_num, 2) * 100,
                'before' => $visitor_num,
            ],
            'people_num' => [
                'conversion' => round(($people_num - $front_people_num) / $front_people_num, 2) * 100,
                'before' => $people_num,
            ],
            'order_num' => [
                'conversion' => round(($order_num - $front_order_num) / $front_order_num, 2) * 100,
                'before' => $order_num,
            ],
            'order_total_price' => [
                'conversion' => round(($order_total_price - $front_order_total_price) / $front_order_total_price, 2) * 100,
                'before' => $order_total_price,
            ],
            'payment_people_num' => [
                'conversion' => round(($payment_people_num - $front_payment_people_num) / $front_payment_people_num, 2) * 100,
                'before' => $payment_people_num,
            ],
            'payment_order_num' => [
                'conversion' => round(($payment_order_num - $front_payment_order_num) / $front_payment_order_num, 2) * 100,
                'before' => $payment_order_num,
                'current' => $front_payment_order_num,
            ],
            'payment_total_price' => [
                'conversion' => round(($payment_total_price - $front_payment_total_price) / $front_payment_total_price, 2) * 100,
                'before' => $payment_total_price,
            ],
            'payment_num' => [
                'conversion' => round(($payment_num - $front_payment_num) / $front_payment_num, 2) * 100,
                'before' => $payment_num,
            ],
            'unit_price' => [
                'conversion' => round(($unit_price - $front_unit_price) / $front_unit_price, 2) * 100,
                'before' => $unit_price,
            ],
        ] );
    }


    /**
     * 交易概括(曲线)
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function curveTransactionSurvey(){
        $orderModel = new \App\Model\Order;
        $analysisModel = new \App\Model\Analysis;

        $condition['create_time'] = $this->create_time;

        $list = $this->date_arr;

        $condition['payment_time'] = ['>', 0];

        //支付金额
        $payment_total_price = $orderModel->field( "sum(amount) as payment_total_price, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $condition )->group( 'date_time' )->select();
        $list = \App\Utils\Analysis::conver($list, $payment_total_price, 'payment_total_price', 'date_time');

        //支付人数
        $payment_people_num = $orderModel->field( "count(distinct(user_id)) as payment_people_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $condition )->group( 'date_time' )->select();
        $list = \App\Utils\Analysis::conver($list, $payment_people_num, 'payment_people_num', 'date_time');

        //支付件数
        $payment_piece_num = $orderModel->field( "sum(goods_num) as payment_piece_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $condition )->group( 'date_time' )->select();
        $list = \App\Utils\Analysis::conver($list, $payment_piece_num, 'payment_piece_num', 'date_time');

        //访问数
        $where['create_time'] = $this->create_time;
        $visitor_num = $analysisModel->field( "count(id) as visitor_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $where )->group('date_time')->select();
        $list = \App\Utils\Analysis::conver($list, $visitor_num, 'visitor_num', 'date_time');

        //下单笔数
        $order_num = $orderModel->field( "count(id) as order_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $where )->group('date_time')->select();
        $list = \App\Utils\Analysis::conver($list, $order_num, 'order_num', 'date_time');

        //支付数
        $where['payment_time'] = ['>', 0];
        $payment_num = $orderModel->field( "count(id) as payment_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $where )->group('date_time')->select();
        $list = \App\Utils\Analysis::conver($list, $payment_num, 'payment_num', 'date_time');


        return $this->send( Code::success, [
            'list' => $list,
        ] );
    }


    /**
     * 交易构成（如何界定为新老客户呢？）
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function constitute(){

    }



    /**
     * 地域分布（问了泉哥，用户貌似没有绑定城市这个功能，那么访客数就没法实现，商定是否需要去掉访问数和转换率问题）
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function distribution(){
        $orderextendModel = new \App\Model\OrderExtend;

    }


    /* 客户概览 */


    /**
     * 客户概括及趋势
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function trend(){
        $orderextendModel = new \App\Model\OrderExtend;

    }

}

?>