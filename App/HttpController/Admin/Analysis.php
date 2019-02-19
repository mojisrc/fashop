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

    public function _initialize() {
        parent::_initialize();

        $param = !empty( $this->post ) ? $this->post : $this->get;
        if( isset( $param['create_time'] ) ){
            $this->create_time = [
                'between',
                $param['create_time'],
            ];
            $this->start_date = strtotime($param[0]);
            $this->end_date = strtotime($param[1]);
        }else{
            $this->start_date = time();
            $this->end_date = strtotime("-7days",strtotime(date('Y-m-d', $this->start_date)));
            $this->create_time = [
                'between',
                [$this->end_date, $this->start_date],
            ];
        }
    }


	/**
	 * 流量概览(访客数，分享访问人数，商品访客数，浏览量，分享访问次数，商品浏览量)
	 * @method GET | POST
	 * @param array  $create_time      [开始时间,结束时间]
	 */
	public function list()
	{
        $analysisModel = \App\Model\Analysis;
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
        $analysisModel = \App\Model\Analysis;
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
        $analysisModel = \App\Model\Analysis;
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
        $analysisModel = \App\Model\Analysis;
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
        $analysisModel = \App\Model\Analysis;
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
        $analysisModel = \App\Model\Analysis;
        //浏览量
        $condition['create_time'] = $this->create_time;
        $condition = 'city is not null';
        $view_num = $analysisModel->field( "count(id) as view_num, city" )
                                                ->where( $condition )
                                                ->group( 'city' )
                                                ->select();

        //访客数
        $condition_str = 'city is not null AND create_time between ' . $this->end_date . ' AND ' . $this->start_date;
        $visitor_num = $analysisModel->rawQuery("SELECT count(distinct(user_id)) as visitor_num,city FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $condition_str) GROUP BY city");


        //商品浏览量
        $where['create_time'] = $this->create_time;
        $where['link_id'] = 1;
        $where = 'city is not null';
        $goods_view_num = $analysisModel->field( "count(id) as goods_view_num,city" )
            ->where( $where )
            ->group( 'city' )
            ->select();


        //商品访客数
        $where_str = 'city is not null AND link_id = 1 AND create_time between ' . $this->end_date . ' AND ' . $this->start_date;
        $goods_visitor_num = $analysisModel->rawQuery("SELECT count(distinct(user_id)) as goods_visitor_num,city FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $where_str) GROUP BY city");



        $list = array_map(function($view_num, $visitor_num, $goods_view_num, $goods_visitor_num)
        {
            return([
                'city' => $view_num['city'],
                'visitor_num' => $view_num['view_num'],
                'view_num' => $visitor_num['visitor_num'],
                'goods_view_num' => $goods_view_num['goods_view_num'],
                'goods_visitor_num' => $goods_visitor_num['goods_visitor_num']
            ]);
        }, $view_num, $visitor_num, $goods_view_num, $goods_visitor_num);

        $this->send( Code::success, [
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
        $analysisModel = \App\Model\Analysis;
        $condition['create_time'] = $this->create_time;
        //浏览量
        $view_num = $analysisModel->field( "count(id) as view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
                                           ->where( $condition )
                                           ->group( 'date_time' )
                                           ->select();


        //访客数
        $condition_str = 'create_time between ' . $this->end_date . ' AND ' . $this->start_date;
        $visitor_num = $analysisModel->rawQuery("SELECT count(distinct(user_id)) as visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $condition_str) GROUP BY date_time");


        //商品浏览量
        $where['create_time'] = $this->create_time;
        $where['link_id'] = 1;
        $goods_view_num = $analysisModel->field( "count(id) as goods_view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
                                            ->where( $where )
                                            ->group( 'date_time' )
                                            ->select();


        //商品访客数
        $where_str = 'link_id = 1 AND create_time between ' . $this->end_date . ' AND ' . $this->start_date;
        $goods_visitor_num = $analysisModel->rawQuery("SELECT count(distinct(user_id)) as goods_visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $where_str) GROUP BY date_time");


        $list = array_map(function($view_num, $visitor_num, $goods_view_num, $goods_visitor_num)
        {
            return([
                'date_time' => $visitor_num['date_time'],
                'visitor_num' => $visitor_num['visitor_num'],
                'view_num' => $view_num['view_num'],
                'goods_view_num' => $goods_view_num['goods_view_num'],
                'goods_visitor_num' => $goods_visitor_num['goods_visitor_num']
            ]);
        }, $view_num, $visitor_num, $goods_view_num, $goods_visitor_num);


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
        $analysisModel = \App\Model\Analysis;
        $condition['create_time'] = $this->create_time;
        //浏览量
        $view_num = $analysisModel->field( "count(id) as view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
            ->where( $condition )
            ->group( 'date_time' )
            ->select();


        //访客数
        $condition_str = 'create_time between ' . $this->end_date . ' AND ' . $this->start_date;
        $visitor_num = $analysisModel->rawQuery("SELECT count(distinct(user_id)) as visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $condition_str) GROUP BY date_time");


        //商品浏览量
        $where['create_time'] = $this->create_time;
        $where['link_id'] = 1;
        $goods_view_num = $analysisModel->field( "count(id) as goods_view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
                                                    ->where( $where )
                                                    ->group( 'date_time' )
                                                    ->select();


        //商品访客数
        $where_str = 'link_id = 1 AND create_time between ' . $this->end_date . ' AND ' . $this->start_date;
        $goods_visitor_num = $analysisModel->rawQuery("SELECT count(distinct(user_id)) as goods_visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $where_str) GROUP BY date_time");



        //分享访问次数
        $where['create_time'] = $this->create_time;
        $where['relation_user_id'] = ['>', 0];
        $share_num = $analysisModel->field( "count(id) as share_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
                                                ->where( $where )
                                                ->group( 'date_time' )
                                                ->select();


        //分享访问人数
        $where_str = 'relation_user_id > 1 AND create_time between ' . $this->end_date . ' AND ' . $this->start_date;
        $share_visit_people_num = $analysisModel->rawQuery("SELECT count(distinct(relation_user_id)) as share_visit_people_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $where_str) GROUP BY date_time");




        $list = array_map(function($view_num, $visitor_num, $goods_view_num, $goods_visitor_num, $share_num, $share_visit_people_num)
        {
            return([
                'date_time' => $visitor_num['date_time'],
                'visitor_num' => $visitor_num['visitor_num'],
                'view_num' => $view_num['view_num'],
                'goods_view_num' => $goods_view_num['goods_view_num'],
                'goods_visitor_num' => $goods_visitor_num['goods_visitor_num'],
                'share_num' => $share_num['share_num'],
                'share_visit_people_num' => $share_visit_people_num['share_visit_people_num'],
            ]);
        }, $view_num, $visitor_num, $goods_view_num, $goods_visitor_num, $share_num, $share_visit_people_num);


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
//    public function goodsWhole()
//    {
//        $goods_where['is_on_sale'] = 1;
//        //在架商品数(不能根据时间条件查询在家商品数，只能查当前时间)
//        $goods_num = \App\Model\goods::init()->field( "count(id) as goods_num" )->where( $condition )
//            ->count();
//
//
//        //被访问商品数
//        $goods_visitor_where['create_time'] = $this->create_time;
//        $goods_visitor_where['link_id'] = 1;
//        $goods_visitor_num = \App\Model\Analysis::init()->where( $goods_visitor_where )->count( 'DISTINCT user_id' );
//
//
//
//
//        //动销商品数
//        $goods_where['is_on_sale'] = 1;
//        $goods_movable_num = \App\Model\Goods::init()->join('order_goods', 'goods.id = order_goods.goods_id', 'LEFT')
//                                                    ->where( $goods_where )
//                                                    ->count();
//        return $this->send( Code::success, [
//            'list' => $goods_movable_num,
//        ] );
//
//        //商品曝光数
//        $where_str = 'link_id = 1 AND create_time between ' . $this->end_date . ' AND ' . $this->start_date;
//        $goods_visitor_num = \App\Model\Analysis::init()->rawQuery("SELECT count(distinct(user_id)) as goods_visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $where_str) GROUP BY date_time");
//
//
//
//        //商品浏览量
//        $where['create_time'] = $this->create_time;
//        $where['relation_user_id'] = ['>', 0];
//        $share_num = \App\Model\Analysis::init()->field( "count(id) as share_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
//            ->where( $where )
//            ->group( 'date_time' )
//            ->select();
//
//
//        //商品访客数
//        $where_str = 'relation_user_id > 1 AND create_time between ' . $this->end_date . ' AND ' . $this->start_date;
//        $share_visit_people_num = \App\Model\Analysis::init()->rawQuery("SELECT count(distinct(relation_user_id)) as share_visit_people_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $where_str) GROUP BY date_time");
//
//
//        //加购件数
//
//
//        //下单件数
//
//        //支付件数
//
//        $list = array_map(function($view_num, $visitor_num, $goods_view_num, $goods_visitor_num, $share_num, $share_visit_people_num)
//        {
//            return([
//                'date_time' => $visitor_num['date_time'],
//                'visitor_num' => $visitor_num['visitor_num'],
//                'view_num' => $view_num['view_num'],
//                'goods_view_num' => $goods_view_num['goods_view_num'],
//                'goods_visitor_num' => $goods_visitor_num['goods_visitor_num'],
//                'share_num' => $share_num['share_num'],
//                'share_visit_people_num' => $share_visit_people_num['share_visit_people_num'],
//            ]);
//        }, $view_num, $visitor_num, $goods_view_num, $goods_visitor_num, $share_num, $share_visit_people_num);
//
//
//        $this->send( Code::success, [
//            'list' => $list,
//        ] );
//    }




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
        //计算时间差
        $days = ceil(($this->start_date - $this->end_date) / 86400);

        //获取前一日或前一个月的开始时间，结束时间用前端传过来的开始时间作为结束时间
        $front_time =  $this->start_date - ((60 * 60 * 24) * $days);

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
        $where['create_time'] = ['between', [$this->end_date, $this->start_date]];
        //访客数
        $front_visitor_num = $analysisModel->where( $condition )->count( 'DISTINCT user_id' );
        $front_visitor_num = $front_visitor_num ? $front_visitor_num : 20;

        //下单人数
        $front_people_num = $orderModel->where( $condition )->count( 'DISTINCT user_id' );

        //下单笔数
        $front_order_num = $orderModel->where( $condition )->count();

        //下单金额
        $front_order_total_price = $orderModel->where( $condition )->sum( 'amount' );

        //支付人数
        $where['payment_time'] = ['>', 0];
        $front_payment_people_num = $orderModel->where( $condition )->count( 'DISTINCT user_id' );

        //支付订单数
        $front_payment_order_num = $orderModel->where( $condition )->count();

        //支付金额
        $front_payment_total_price = $orderModel->where( $condition )->count( 'amount' );

        //支付件数
        $front_payment_num = $orderModel->where( $condition )->count( 'goods_num' );

        //客单价
        $front_unit_price = ceil($order_total_price / $visitor_num);

        //访客数和下单的转化率
        $people_visitor_current = round( $people_num / $visitor_num, 2);

        //下单和付款的转化率
        $payment_people_current = round(  $front_payment_people_num / $people_num, 2);

        //访客和付款的转化率
        $visitor_payment_people_current = round(  $front_payment_people_num / $visitor_num, 2);

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
//        $condition['create_time'] = $this->create_time;
        $condition['payment_time'] = ['>', 0];
        //支付金额
        $payment_total_price = $orderModel->field( "sum(amount) as total_price, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
            ->where( $condition )
            ->group( 'date_time' )
            ->select();

        //支付人数
        $payment_people_num = $orderModel->field( "count(distinct(user_id)) as people_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
            ->where( $condition )
            ->group( 'date_time' )
            ->select();


        //支付件数
        $payment_piece_num = $orderModel->field( "sum(goods_num) as piece_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
            ->where( $condition )
            ->group( 'date_time' )
            ->select();


        //访问数
        //$where['create_time'] = $this->create_time;
        $where = [];
        $visitor_num = $analysisModel->field( "count(id) as total_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $where )->group('date_time')->select();

        //下单笔数
        $order_num = $orderModel->field( "count(id) as total_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $where )->group('date_time')->select();

        //支付数
        $where['payment_time'] = ['>', 0];
        $payment_num = $orderModel->field( "count(id) as total_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )->where( $where )->group('date_time')->select();

        //访问下单的转化率
        //$visitor_order_conversion = conversion($visitor_num, $order_num);//函数加载不进来，先注释使用下面的循环
        $visitor_order_conversion = [];
        if(!empty($order_num)){
            foreach($order_num as $key => $val){
                foreach($visitor_num as $k => $v){
                    if($val['date_time'] == $v['date_time']){
                        $order_num[$key]['conversion'] = round($v['total_num'] / $val['total_num'], 2) * 100;
                    }else{
                        if(empty($order_num[$key]['conversion'])){
                            $order_num[$key]['conversion'] = 0;
                        }
                    }
                }
            }
            $visitor_order_conversion = $order_num;
        }


        //下单和付款的转化率
        //$people_visitor_conversion = conversion($visitor_num, $order_num);//函数加载不进来，先注释使用下面的循环
        $payment_order_current = [];
        if(!empty($payment_num)){
            foreach($payment_num as $key => $val){
                foreach($order_num as $k => $v){
                    if($val['date_time'] == $v['date_time']){
                        $payment_num[$key]['conversion'] = round($v['total_num'] / $val['total_num'], 2) * 100;
                    }else{
                        if(empty($payment_num[$key]['conversion'])){
                            $payment_num[$key]['conversion'] = 0;
                        }
                    }
                }
            }
            $payment_order_current = $payment_num;
        }
//
//      //访客和付款的转化率
        //$people_visitor_conversion = conversion($visitor_num, $order_num);//函数加载不进来，先注释使用下面的循环
        $people_visitor_conversion = [];
        if(!empty($payment_num)){
            foreach($payment_num as $key => $val){
                foreach($visitor_num as $k => $v){
                    if($val['date_time'] == $v['date_time']){
                        $payment_num[$key]['conversion'] = round($v['total_num'] / $val['total_num'], 2) * 100;
                    }else{
                        if(empty($payment_num[$key]['conversion'])){
                            $payment_num[$key]['conversion'] = 0;
                        }
                    }
                }
            }
            $people_visitor_conversion = $payment_num;
        }

        return $this->send( Code::success, [
            'payment_total_price' => $payment_total_price,
            'payment_people_num' => $payment_people_num,
            'payment_piece_num' => $payment_piece_num,
            'visitor_order_conversion' => $visitor_order_conversion,
            'payment_order_current' => $payment_order_current,
            'people_visitor_conversion' => $people_visitor_conversion,
        ] );
//
//
//        //访客数
//        $condition_str = 'create_time between ' . $this->end_date . ' AND ' . $this->start_date;
//        $visitor_num = $analysisModel->rawQuery("SELECT count(distinct(user_id)) as visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $condition_str) GROUP BY date_time");
//
//
//        //商品浏览量
//        $where['create_time'] = $this->create_time;
//        $where['link_id'] = 1;
//        $goods_view_num = $analysisModel->field( "count(id) as goods_view_num, FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time" )
//            ->where( $where )
//            ->group( 'date_time' )
//            ->select();
//
//
//        //商品访客数
//        $where_str = 'link_id = 1 AND create_time between ' . $this->end_date . ' AND ' . $this->start_date;
//        $goods_visitor_num = $analysisModel->rawQuery("SELECT count(distinct(user_id)) as goods_visitor_num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date_time FROM fa_analysis WHERE create_time IN (SELECT create_time FROM fa_analysis where $where_str) GROUP BY date_time");
//
//
//        $list = array_map(function($view_num, $visitor_num, $goods_view_num, $goods_visitor_num)
//        {
//            return([
//                'date_time' => $visitor_num['date_time'],
//                'visitor_num' => $visitor_num['visitor_num'],
//                'view_num' => $view_num['view_num'],
//                'goods_view_num' => $goods_view_num['goods_view_num'],
//                'goods_visitor_num' => $goods_visitor_num['goods_visitor_num']
//            ]);
//        }, $view_num, $visitor_num, $goods_view_num, $goods_visitor_num);
//

        $this->send( Code::success, [
            'list' => $view_num,
        ] );
    }



}

?>