<?php
/**
 * 拼团模块
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

use App\Logic\Order as OrderLogic;
use App\Utils\Code;

class Group extends Server
{

    /**
     * 商品列表
     * @method GET
     * @author 孙泉
     */
    public function list()
    {
        $param                   = $this->get;
        $group_model             = model('Group');
        $group_goods_model       = model('GroupGoods');
        $condition               = [];
        $condition['is_show']    = 1;
        $condition['start_time'] = ['elt', time()];

        //查询活动
        $group_data = $group_model->getGroupInfo($condition);
        if (!$group_data) {
            $this->send(Code::success, [
                'total_number' => 0,
                'list'         => [],
            ]);
        } else {
            //查询活动商品ids
            $goods_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $group_data['id']], '', 'goods_id');
            if ($goods_ids) {
                $online_goods_ids = model('Goods')->getGoodsColumn(['id' => ['in', $goods_ids], 'is_on_sale' => 1], 'id');

                //返回出现在第一个数组中但其他数组中没有的值 [将要删除的商品]
                $difference_goods_del_ids = array_diff($goods_ids, $online_goods_ids);

                if ($difference_goods_del_ids) {
                    //删除活动下失效商品
                    $group_goods_result = $group_goods_model->delGroupGoods(['group_id' => $group_data['id'], 'goods_id' => array('in', $difference_goods_del_ids)]);
                    if (!$group_goods_result) {
                        return $this->send(Code::param_error, [], '删除活动下失效商品失败');

                    }
                }
            }

            //查询活动商品sku ids
            $goods_sku_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $group_data['id']], '', 'goods_sku_id');

            if ($goods_sku_ids) {
                $online_goods_sku_ids = model('GoodsSku')->getGoodsSkuColumn(['id' => ['in', $goods_sku_ids]], 'id');

                //返回出现在第一个数组中但其他数组中没有的值 [将要删除的sku]
                $difference_goods_sku_del_ids = array_diff($goods_sku_ids, $online_goods_sku_ids);

                if ($difference_goods_sku_del_ids) {
                    //删除活动下失效商品sku
                    $group_goods_result = $group_goods_model->delGroupGoods(['group_id' => $group_data['id'], 'goods_sku_id' => array('in', $difference_goods_sku_del_ids)]);
                    if (!$group_goods_result) {
                        return $this->send(Code::param_error, [], '删除活动下失效商品sku失败');

                    }
                }
            }

            $group_goods_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $group_data['id']], '', 'goods_id');

            if (!$group_goods_ids) {
                $this->send(Code::success, [
                    'total_number' => 0,
                    'list'         => [],
                ]);
            } else {
                $min_group_price = $group_goods_model->getGroupGoodsValue(['group_id' => $group_data['id'], 'goods_id' => ['in', $group_goods_ids]], '', 'min(group_price)');

                $param['ids']  = $group_goods_ids;
                $param['page'] = $this->getPageLimit();
                $goodsLogic    = new \App\Logic\GoodsSearch($param);
                $goods_count   = $goodsLogic->count();
                $goods_list    = $goodsLogic->list();
                foreach ($goods_list as $key => $value) {
                    $goods_list[$key]['group_price'] = $min_group_price;
                }
                $this->send(Code::success, [
                    'info'         => ['group_id' => $group_data['id'], 'limit_buy_num' => $group_data['limit_buy_num']],
                    'total_number' => $goods_count,
                    'list'         => $goods_list,
                ]);
            }

        }

    }
//    /**
//     * 单条商品信息
//     * @method GET
//     * @param int $group_id 拼团活动id
//     * @param int $goods_id 拼团活动商品id
//     * @author 孙泉
//     */
//    public function info()
//    {
//        $get = $this->get;
//
//        if ($this->validate($get, 'Server/Group.info') !== true) {
//            $this->send(Code::param_error, [], $this->getValidate()->getError());
//        } else {
//
//            $group_model             = model('Group');
//            $group_goods_model       = model('GroupGoods');
//            $condition               = [];
//            $condition['is_show']    = 1;
//            $condition['start_time'] = ['elt', time()];
//            $condition['id']         = $get['group_id'];
//
//            //查询活动
//            $group_data = $group_model->getGroupInfo($condition);
//            if (!$group_data) {
//                return $this->send(Code::param_error, [], '拼团活动失效');
//            }else{
//                $online_goods_id = model('Goods')->getGoodsValue(['id' => $get['goods_id'], 'is_on_sale' => 1], 'id');
//                if(!$online_goods_id){
//                    //删除活动下失效商品
//                    $group_goods_result = $group_goods_model->delGroupGoods(['group_id' => $group_data['id'], 'goods_id' => $goods_id]);
//                    if (!$group_goods_result) {
//                        return $this->send(Code::param_error, [], '删除活动下失效商品失败');
//
//                    }
//                }
//
//                //查询活动商品sku ids
//                $goods_sku_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $group_data['id'],'goods_id'=>$get['goods_id']], '', 'goods_sku_id');
//
//                if ($goods_sku_ids) {
//                    $online_goods_sku_ids = model('GoodsSku')->getGoodsSkuColumn(['id' => ['in', $goods_sku_ids]], 'id');
//
//                    //返回出现在第一个数组中但其他数组中没有的值 [将要删除的sku]
//                    $difference_goods_sku_del_ids = array_diff($goods_sku_ids, $online_goods_sku_ids);
//
//                    if ($difference_goods_sku_del_ids) {
//                        //删除活动下失效商品sku
//                        $group_goods_result = $group_goods_model->delGroupGoods(['group_id' => $group_data['id'], 'goods_sku_id' => array('in', $difference_goods_sku_del_ids)]);
//                        if (!$group_goods_result) {
//                            return $this->send(Code::param_error, [], '删除活动下失效商品sku失败');
//
//                        }
//                    }
//                }
//                $goods_sku_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $group_data['id'],'goods_id'=>$get['goods_id']], '', 'goods_sku_id');
//                if (!$goods_sku_ids) {
//                    return $this->send(Code::param_error, [], '没有生效的商品sku');
//                }else{
//
//                    $goods_info         = model('Goods')->getGoodsInfo(['id' => $get['goods_id']]);
//                    $goods_info['skus'] = model('GoodsSku')->getGoodsSkuList(['goods_id' => $get['goods_id'],'id'=>['in',$goods_sku_ids]], '*', 'id desc', '1,10000');
//                    //缺少拼团信息
//                    //缺少团信息
//                    $this->send(Code::success, ['info' => $goods_info]);
//                }
//
//            }
//
//        }
//    }

    /**
     * 拼团商品信息
     * @method GET
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function info()
    {
        $get = $this->get;

        if ($this->validate($get, 'Server/Group.info') !== true) {
            $this->send(Code::param_error, [], $this->getValidate()->getError());
        } else {
            $group_id     = $get['group_id'];
            $goods_id     = $get['goods_id'];
            $filter_goods = $this->filterGoods($group_id, $goods_id);
            if ($filter_goods['code'] == -1) {
                return $this->send(Code::param_error, [], $filter_goods['msg']);

            } else {
                $goods_info         = model('Goods')->getGoodsInfo(['id' => $goods_id]);
                $goods_info['skus'] = model('GoodsSku')->getGoodsSkuList(['goods_id' => $goods_id, 'id' => ['in', $filter_goods['goods_sku_ids']]], '*', 'id desc', '1,100');

                //已过期生效中：超时，不可开团，但可参团；在拼团列表中
                $goods_info['group'] = $filter_goods['group'];

                $this->send(Code::success, ['info' => $goods_info]);
            }

        }
    }

    /**
     * 拼团商品sku信息
     * @method GET
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function skuInfo()
    {
        $get = $this->get;

        if ($this->validate($get, 'Server/Group.skuInfo') !== true) {
            $this->send(Code::param_error, [], $this->getValidate()->getError());
        } else {
            $group_id     = $get['group_id'];
            $goods_id     = $get['goods_id'];
            $filter_goods = $this->filterGoods($group_id, $goods_id);
            if ($filter_goods['code'] == -1) {
                return $this->send(Code::param_error, [], $filter_goods['msg']);

            } else {
                $group_goods['skus'] = model('GroupGoods')->getGroupGoodsList(['group_id' => $group_id, 'goods_id' => $goods_id, 'goods_sku_id' => ['in', $filter_goods['goods_sku_ids']]], '', 'goods_sku_id,group_price,captain_price', 'goods_sku_id desc', '1,100');

                $this->send(Code::success, ['info' => $group_goods]);
            }

        }

    }

    /**
     * 正在拼团列表
     * @method GET
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function groupingSearch()
    {
        $get = $this->get;
        if ($this->validate($get, 'Server/Group.groupingSearch') !== true) {
            $this->send(Code::param_error, [], $this->getValidate()->getError());
        } else {
            $group_id     = $get['group_id'];
            $goods_id     = $get['goods_id'];
            $filter_goods = $this->filterGoods($group_id, $goods_id);
            if ($filter_goods['code'] == -1) {
                return $this->send(Code::param_error, [], $filter_goods['msg']);

            } else {

                $condition['order.goods_type']     = 2; //拼团
                $condition['order.group_identity'] = 1; //团长
                $condition['order.group_state']    = 1; //正在进行 未满团

                $prefix            = config('database.prefix');
                $table_order_goods = $prefix . "order_goods";
                $condition_string  = "order.id in (SELECT order_id FROM $table_order_goods WHERE order_id=order.id AND goods_id=$goods_id)";

                $orderLogic = new OrderLogic($condition, $condition_string);
                $orderLogic->page('1,1000');
                $orderLogic->extend(['user']);
                $field = 'order.*';
                $orderLogic->field($field);
                $count = $orderLogic->count();
                $list  = $orderLogic->list();

                $this->send(Code::success, [
                    'total_number' => $count,
                    'list'         => $list,
                ]);
            }

        }

    }

    /**
     * 正在拼团详情
     * @method GET
     * @param int $order_id 订单id
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function groupingInfo()
    {
        $get = $this->get;
        if ($this->validate($get, 'Server/Group.groupingInfo') !== true) {
            $this->send(Code::param_error, [], $this->getValidate()->getError());
        } else {
            $order_id     = $get['order_id'];
            $group_id     = $get['group_id'];
            $goods_id     = $get['goods_id'];
            $filter_goods = $this->filterGoods($group_id, $goods_id);
            if ($filter_goods['code'] == -1) {
                return $this->send(Code::param_error, [], $filter_goods['msg']);

            } else {
                $condition['order.id']             = $order_id; //订单id
                $condition['order.goods_type']     = 2; //拼团
                $condition['order.group_identity'] = 1; //团长
                $condition['order.group_state']    = 1; //正在进行 未满团

                $order_goods_model = model('OrderGoods');
                $order_goods_id    = $order_goods_model->getOrderGoodsId(['order_id' => $order_id, 'goods_id' => $goods_id]);
                if (!$order_goods_id) {
                    return $this->send(Code::error, [], '没有该订单');

                } else {
                    $orderLogic = new OrderLogic($condition);
                    $orderLogic->extend(['user']);
                    $field = 'order.*';
                    $orderLogic->field($field);
                    $info = $orderLogic->info();
                    if (empty($info)) {
                        return $this->send(Code::error, [], '没有该订单');
                    } else {
                        $this->send(Code::success, [
                            'info' => $info,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * 分享过来的拼团详情
     * @method GET
     * @param int $order_id 订单id
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function shareGroupingInfo()
    {
        $get = $this->get;
        if ($this->validate($get, 'Server/Group.shareGroupingInfo') !== true) {
            $this->send(Code::param_error, [], $this->getValidate()->getError());
        } else {
            $order_id     = $get['order_id'];
            $group_id     = $get['group_id'];
            $goods_id     = $get['goods_id'];
            $filter_goods = $this->filterGoods($group_id, $goods_id);
            if ($filter_goods['code'] == -1) {
                return $this->send(Code::param_error, [], $filter_goods['msg']);

            } else {
                $condition['order.id']             = $order_id; //订单id
                $condition['order.goods_type']     = 2; //拼团
                $condition['order.group_identity'] = 1; //团长
                $condition['order.group_state']    = ['in', '1,2']; //1正在进行中(待开团) 2拼团成功

                $order_goods_model = model('OrderGoods');
                $order_goods_id    = $order_goods_model->getOrderGoodsId(['order_id' => $order_id, 'goods_id' => $goods_id]);
                if (!$order_goods_id) {
                    return $this->send(Code::error, [], '没有该订单');

                } else {
                    $orderLogic = new OrderLogic($condition);
                    $orderLogic->extend(['user']);
                    $field = 'order.*';
                    $orderLogic->field($field);
                    $info = $orderLogic->info();
                    if (empty($info)) {
                        return $this->send(Code::error, [], '没有该订单');
                    } else {
                        $this->send(Code::success, [
                            'info' => $info,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * 过滤商品信息
     * @method GET
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function filterGoods($group_id, $goods_id)
    {
        $group_model             = model('Group');
        $group_goods_model       = model('GroupGoods');
        $condition               = [];
        $condition['is_show']    = 1;
        $condition['start_time'] = ['elt', time()];
        $condition['id']         = $group_id;

        //查询活动
        $group_data = $group_model->getGroupInfo($condition);
        if (!$group_data) {
            return ['code' => -1, 'msg' => '拼团活动失效'];

        } else {
            $online_goods_id = model('Goods')->getGoodsValue(['id' => $goods_id, 'is_on_sale' => 1], 'id');
            if (!$online_goods_id) {
                //删除活动下失效商品
                $have_invalid_group_goods = $group_goods_model->getGroupGoodsValue(['group_id' => $group_data['id'], 'goods_id' => $goods_id]);
                if ($have_invalid_group_goods) {
                    $group_goods_result = $group_goods_model->delGroupGoods(['group_id' => $group_data['id'], 'goods_id' => $goods_id]);
                    if (!$group_goods_result) {
                        return ['code' => -1, 'msg' => '删除活动下失效商品失败'];
                    }
                }

            }

            //查询活动商品sku ids
            $goods_sku_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $group_data['id'], 'goods_id' => $goods_id], '', 'goods_sku_id');

            if ($goods_sku_ids) {
                $online_goods_sku_ids = model('GoodsSku')->getGoodsSkuColumn(['id' => ['in', $goods_sku_ids]], 'id');

                //返回出现在第一个数组中但其他数组中没有的值 [将要删除的sku]
                $difference_goods_sku_del_ids = array_diff($goods_sku_ids, $online_goods_sku_ids);

                if ($difference_goods_sku_del_ids) {
                    //删除活动下失效商品sku
                    $group_goods_result = $group_goods_model->delGroupGoods(['group_id' => $group_data['id'], 'goods_sku_id' => array('in', $difference_goods_sku_del_ids)]);
                    if (!$group_goods_result) {
                        return ['code' => -1, 'msg' => '删除活动下失效商品sku失败'];

                    }
                }
            }
            $goods_sku_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $group_data['id'], 'goods_id' => $goods_id], '', 'goods_sku_id');

            if (!$goods_sku_ids) {
                return ['code' => -1, 'msg' => '没有生效的商品sku'];
            } else {
                return ['code' => 0, 'goods_sku_ids' => $goods_sku_ids, 'group' => $group_data];
            }
        }
    }

    /**
     * 允许开团
     * @method GET
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     * @return state 1可以开团  0不可以开团
     */
    public function allowOpenGroup()
    {
        $get = $this->get;

        if ($this->validate($get, 'Server/Group.allowOpenGroup') !== true) {
            $this->send(Code::param_error, [], $this->getValidate()->getError());
        } else {
            $group_id     = $get['group_id'];
            $goods_id     = $get['goods_id'];
            $filter_goods = $this->filterGoods($group_id, $goods_id);
            if ($filter_goods['code'] == -1) {
                return $this->send(Code::success, ['info' => ['state'=>0]]);

            } else {
                if ($filter_goods['group']['end_time'] < time()) {
                    $this->send(Code::success, ['info' => ['state'=>0]]);
                }else{
                    $this->send(Code::success, ['info' => ['state'=>1]]);
                }
            }
        }
    }

    /**
     * 允许参团
     * @method GET
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     * @return state 1可以参团  0不可以参团
     */
    public function allowJoinGroup()
    {
        $get = $this->get;

        if ($this->validate($get, 'Server/Group.allowJoinGroup') !== true) {
            $this->send(Code::param_error, [], $this->getValidate()->getError());
        } else {
            $group_id     = $get['group_id'];
            $goods_id     = $get['goods_id'];
            $filter_goods = $this->filterGoods($group_id, $goods_id);
            if ($filter_goods['code'] == -1) {
                $this->send(Code::success, ['info' => ['state'=>0]]);

            } else {
                $this->send(Code::success, ['info' => ['state'=>1]]);
            }
        }
    }


}
