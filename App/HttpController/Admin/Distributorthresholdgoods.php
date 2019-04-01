<?php
/**
 *
 * 分销员加入门槛需购买商品
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

/**
 *
 * Class DistributorThresholdGoods
 * @package App\HttpController\Admin
 */
class Distributorthresholdgoods extends Admin
{

    /**
     * 可选择商品列表
     * @method GET
     * @param string title          商品名称
     * @param array  category_ids   分类id 数组格式
     */
    public function selectableGoods()
    {
        $get                               = $this->get;
        $distributor_threshold_goods_model = new \App\Model\DistributorThresholdGoods;
        $goods_ids                         = $distributor_threshold_goods_model->getDistributorThresholdGoodsColumn([], 'goods_id');

        if ($goods_ids) {
            $param['not_in_ids'] = $goods_ids;
        }

        $param['is_on_sale'] = 1;
        $param['stock']      = 1; //查询库存大于0
        if (isset($get['title'])) {
            $param['title'] = $get['title'];
        }

        if (isset($get['category_ids'])) {
            $param['category_ids'] = $get['category_ids'];
        }

        $param['page'] = $this->getPageLimit();
        $goodsLogic    = new \App\Biz\GoodsSearch($param);
        return $this->send(Code::success, [
            'total_number' => $goodsLogic->count(),
            'list'         => $goodsLogic->list(),
        ]);
    }

    /**
     * 已选择商品列表
     * @method GET
     * @param string title          商品名称
     * @param array  category_ids   分类id 数组格式
     */
    public function goodsList()
    {
        $get                               = $this->get;
        $distributor_threshold_goods_model = new \App\Model\DistributorThresholdGoods;
        $distributor_threshold_goods_list  = $distributor_threshold_goods_model->getDistributorThresholdGoodsList([], '*', 'id desc', '');
        if (!$distributor_threshold_goods_list) {
            return $this->send(Code::success, [
                'total_number' => 0,
                'list'         => [],
            ]);
        }

        $param['ids'] = array_column($distributor_threshold_goods_list, 'goods_id');;

        if (isset($get['title'])) {
            $param['title'] = $get['title'];
        }

        if (isset($get['category_ids'])) {
            $param['category_ids'] = $get['category_ids'];
        }

        $param['page'] = $this->getPageLimit();
        $goodsLogic    = new \App\Biz\GoodsSearch($param);
        return $this->send(Code::success, [
            'total_number' => $goodsLogic->count(),
            'list'         => $goodsLogic->list(),
        ]);
    }

    /**
     * 添加
     * @method POST
     * @param array goods_ids 商品id数组
     */
    public function add()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/DistributorThresholdGoods.add');
        if ($error !== true) {
            $this->send(Code::error, [], $error);
        } else {
            $distributor_threshold_goods_model = new \App\Model\DistributorThresholdGoods;

            $have_goods_ids = $distributor_threshold_goods_model->getDistributorThresholdGoodsColumn([], 'goods_id');
            if ($have_goods_ids) {
                $goods_ids = array_diff($post['goods_ids'], $have_goods_ids);
                if (!$goods_ids) {
                    return $this->send(Code::param_error, [], '所选商品全部已存在');
                }

            } else {
                $goods_ids = $post['goods_ids'];
            }


            foreach ($goods_ids as $key => $value) {
                $insert_data[$key]['goods_ids']   = $value;
                $insert_data[$key]['create_time'] = time();
            }

            $result = $distributor_threshold_goods_model->insertAllDistributorThresholdGoods($insert_data);
            if ($result) {
                $this->send(Code::success);
            } else {
                $this->send(Code::error);
            }
        }
    }

    /**
     * 删除
     * @method POST
     * @param array ids          数据id数组
     */
    public function del()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/DistributorThresholdGoods.del');
        if ($error !== true) {
            $this->send(Code::error, [], $error);
        } else {
            $distributor_threshold_goods_model = new \App\Model\DistributorThresholdGoods;
            $condition['id']                   = ['in', $post['ids']];
            $result                            = $distributor_threshold_goods_model->delDistributorThresholdGoods($condition);
            if ($result) {
                $this->send(Code::success);
            } else {
                $this->send(Code::error);
            }
        }
    }

}