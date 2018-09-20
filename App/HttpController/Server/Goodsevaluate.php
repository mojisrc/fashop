<?php
/**
 * 商品评价
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use App\Utils\Code;

class Goodsevaluate extends Server
{
    /**
     *订单商品评价列表
     * @method GET
     * @param int $order_id       订单id
     * @param int $evaluate_state 评价状态 0未评价，1已评价，2已追评（传un_evaluate is_evaluate）
     * @param array $ids          id数组
     * @param int $page           页数
     * @param int $rows           条数
     * @author 韩文博
     */
    public function list()
    {
        if( $this->verifyResourceRequest() !== true ){
            $this->send( Code::user_access_token_error );
        } else{
            $get                         = $this->get;

            $prefix                      = config( 'database.prefix' );
            $table_order                 = $prefix."order";
            $table_order_goods           = $prefix."order_goods";

            $condition                   = [];
            $condition['evaluate_state'] = 0;
            $condition["(SElECT state FROM $table_order where id =$table_order_goods.order_id)"] = 40;

            if( isset( $get['order_id'] ) ){
                $condition['order_id'] = $get['order_id'];
            }
            if( isset( $get['evaluate_state'] ) ){
                switch( $get['evaluate_state'] ){
                    case 'un_evaluate':
                        $condition['evaluate_state'] = 0;
                        break;
                    case 'is_evaluate':
                        $condition['evaluate_state'] = ['in', [1, 2]];
                        break;
                }
            }

            if(isset($get['ids']) && is_array($get['ids'])){
                $condition['id'] = ['in', $get['ids']];
            }

            $user                 = $this->getRequestUser();
            $condition['user_id'] = ['in', model('User')->getUserAllIds($user['id'])];
            $order_goods_model    = model( 'OrderGoods' );
            $count                = $order_goods_model->getOrderGoodsCount( $condition );

            $list                 = $order_goods_model->getOrderGoodsList( $condition, '*', 'id desc', $this->getPageLimit() );
            $this->send( Code::success, [
                'total_number' => $count,
                'list'         => $list,
            ] );
        }
    }

    /**
     * 评价详情
     * @method GET
     * @param int order_goods_id
     * @author 韩文博
     */
    public function detail()
    {
        if( $this->verifyResourceRequest() !== true ){
            $this->send( Code::user_access_token_error );
        } else{
            $get = $this->get;
            if( intval( $get['order_goods_id'] ) <= 0 ){
                $this->send( Code::param_error, [], '参数错误' );
            } else{
                $user                                 = $this->getRequestUser();
                $condition                            = [];
                $condition['evaluate.order_goods_id'] = intval( $get['order_goods_id'] );
                $condition['evaluate.user_id']        = ['in', model('User')->getUserAllIds($user['id'])];

                $goods_evaluate_model = model( 'GoodsEvaluate' );

                $data = $goods_evaluate_model->alias( 'evaluate' )->join( 'order', 'evaluate.order_id = order.id', 'LEFT' )->join( 'order_goods goods', 'evaluate.order_goods_id = goods.id' )->join( 'user', 'evaluate.user_id = user.id', 'LEFT' )->join( 'user_profile', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->field( 'evaluate.*,goods.goods_spec,user.phone,user_profile.nickname,user_profile.avatar' )->find();

                $this->send( Code::success, ['info' => $data] );

            }

        }
    }

    /**
     * 对订单商品进行评价
     * @method POST
     * @param int order_goods_id 订单商品表的id
     * @param int score 分数
     * @param array images 评价图片 数组
     * @param int is_anonymous 是否匿名 1是0否
     * @param string content 评价内容
     * @author 韩文博
     */
    public function add()
    {
        if( $this->verifyResourceRequest() !== true ){
            $this->send( Code::user_access_token_error );
        } else{
            if( $this->validate( $this->post, 'Server/GoodsEvaluate.add' ) !== true ){
                $this->send( Code::param_error, [], $this->getValidate()->getError() );
            }else{
                try{
                    $user                  = $this->getRequestUser();
                    $this->post['user_id'] = $user['id'];
                    $logic                 = new \App\Logic\Server\GoodsEvaluate( (array)$this->post );
                    $result                = $logic->create();
                    if( $result === true ){
                        $this->send( Code::success );
                    } else{
                        $this->send( Code::error );
                    }
                } catch( \Exception $e ){
                    $this->send( Code::error, [], $e->getMessage() );
                }
            }
        }
    }

    /**
     * 对订单商品进行追加评价
     * @method POST
     * @param int   order_goods_id      订单商品表的id
     * @param array additional_images   评价图片 数组
     * @param string additional_content 评价内容
     * @author 韩文博
     */
    public function append()
    {
        if( $this->verifyResourceRequest() !== true ){
            $this->send( Code::user_access_token_error );
        } else{
            if( $this->validate( $this->post, 'Server/GoodsEvaluate.append' ) !== true ){
                $this->send( Code::param_error, [], $this->getValidate()->getError() );
            }else{
                try{
                    $user                  = $this->getRequestUser();
                    $this->post['user_id'] = $user['id'];
                    $logic                 = new \App\Logic\Server\GoodsEvaluate( (array)$this->post );
                    $result                = $logic->append();
                    if( $result === true ){
                        $this->send( Code::success );
                    } else{
                        $this->send( Code::error );
                    }
                } catch( \Exception $e ){
                    $this->send( Code::error, [], $e->getMessage() );
                }
            }
        }
    }

    //
    //  /**
    //   * 当前用户的评价列表
    //   * @method GET
    //   * @author 韩文博
    //   */
    //  public function mine()
    //  {
    //      if( $this->verifyResourceRequest() !== true ){
    //          $this->send( Code::user_access_token_error );
    //      } else{
    //          $user                 = $this->getRequestUser();
    //          $goods_evaluate_model = model( 'GoodsEvaluate' );
    //          $condition['user_id'] = $user['id'];
    //          $count                = $goods_evaluate_model->where( $condition )->count();
    //          $list                 = $goods_evaluate_model->getGoodsEvaluateList( $condition, '*', 'id desc', $this->getPageLimit() );
    //          $this->send( Code::success, [
    //              'total_number' => $count,
    //              'list'         => $list,
    //          ] );
    //      }
    //  }
}