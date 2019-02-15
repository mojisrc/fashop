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


    public function _initialize() {
        parent::_initialize();

        $param = !empty( $this->post ) ? $this->post : $this->get;
        if( isset( $param['create_time'] ) ){
            $this->create_time = [
                'between',
                $param['create_time'],
            ];
        }else{
            $start_date = time();
            $end_date = strtotime("-7days",strtotime(date('Y-m-d', $start_date)));
            $this->create_time = [
                'between',
                [$end_date, $start_date],
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
        //访客数
        $visitor_num['create_time'] = $this->create_time;
		$visitor_num = \App\Model\Analysis::init()->where( $visitor_num )->count( 'DISTINCT user_id' );

        //分享访问人数
        $share_visit_people_where['relation_user_id'] = ['>', 0];
        $share_visit_people_where['create_time'] = $this->create_time;
        $share_visit_people_num = \App\Model\Analysis::init()->where( $share_visit_people_where )->count( 'DISTINCT relation_user_id' );

        //商品访客数
        $goods_visitor_where['create_time'] = $this->create_time;
        $goods_visitor_where['link_id'] = 1;
        $goods_visitor_num = \App\Model\Analysis::init()->where( $goods_visitor_where )->count( 'DISTINCT user_id' );

        //商品曝光数
        $goods_exposure_where['create_time'] = $this->create_time;
        $goods_exposure_where['page_type'] = 2;
        $goods_exposure_num = \App\Model\Analysis::init()->where( $goods_exposure_where )->count();

        //浏览量
        $view_where['create_time'] = $this->create_time;
        $view_num = \App\Model\Analysis::init()->where( $view_where )->count();

        //分享的访问次数
        $share_visit_where['create_time'] = $this->create_time;
        $share_visit_where['relation_user_id'] = ['>', 0];
        $share_visit_num = \App\Model\Analysis::init()->where( $share_visit_where )->count();

        //商品浏览量
        $goods_view_where['create_time'] = $this->create_time;
        $goods_view_where['link_id'] = 1;
        $goods_view_num = \App\Model\Analysis::init()->where( $goods_view_where )->count();

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
        //访客数
        $condition['create_time'] = $this->create_time;
        $condition['page_type'] = ['>', 0];
        $field = 'page_type,count(page_type) as total';
        $order = 'total desc';
        $group = 'page_type';
        $list = \App\Model\Analysis::init()->getList($condition, $field, $order, $group);
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
        //访客数
        $condition['create_time'] = $this->create_time;
        $condition['source'] = ['>=', 0];
        $field = 'source,count(source) as total';
        $order = 'total desc';
        $group = 'source';
        $list = \App\Model\Analysis::init()->getList($condition, $field, $order, $group);
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
        //访客数
        $condition['create_time'] = $this->create_time;
        $list = \App\Model\Analysis::init()->field( 'page_name' )->where( $condition )->group( 'page_name' )->select();
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
        //访客数
        $condition['create_time'] = $this->create_time;
        $condition['page_depth'] = ['>', 0];
        $field = 'page_depth,count(page_depth) as visitor_num';
        $order = 'total desc';
        $group = 'page_depth';
        $list = \App\Model\Analysis::init()->getList($condition, $field, $order, $group);
        $this->send( Code::success, [
            'list' => $list,
        ] );
    }


    /**
     * 地域分布（待定sql没想好）
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function region()
    {
        //访客数
        $condition['create_time'] = $this->create_time;
        $condition['page_depth'] = ['>', 0];
        $list = \App\Model\Analysis::init()->field( 'page_depth,count(page_depth) as visitor_num' )->where( $condition )->group( 'page_depth' )->select();
        $this->send( Code::success, [
            'list' => $list,
        ] );
    }


    /*以下是每日流量*/

    /**
     * 按天流量查看（待定sql没想好）
     * @method GET | POST
     * @param array  $create_time      [开始时间,结束时间]
     */
    public function region()
    {
        //访客数
        $condition['create_time'] = $this->create_time;
        $condition['page_depth'] = ['>', 0];
        $list = \App\Model\Analysis::init()->field( 'page_depth,count(page_depth) as visitor_num' )->where( $condition )->group( 'page_depth' )->select();
        $this->send( Code::success, [
            'list' => $list,
        ] );
    }






}

?>