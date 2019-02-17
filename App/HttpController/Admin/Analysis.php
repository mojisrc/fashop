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
        $field = 'count(order_goods.id) as payment_num,order_goods.goods_id';
        $order = 'payment_num desc';
        $group = 'goods_id';
        $result = $ordergoodsModel->fetchSql()->field( $field )->join( 'order', 'order_goods.order_id = order.id', 'LEFT' )->where( $where )->order( $order )->group( $group )->select();


        return $this->send( Code::success, [
            'list' => $result,
            'goods_id' => $goods_id,
            'time' => time(),
        ] );
    }









}

?>