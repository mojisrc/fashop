<?php
/**
 * 拼团模块
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
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
        $condition               = [];
        $time                    = time();
        $condition['start_time'] = ['<=', $time];
        $condition['end_time']   = ['>=', $time];
        $condition['is_show']    = 1;

        //查询正在进行的拼团
        $group_list = \App\Model\Group::init()->getGroupList($condition, '', '*', 'id desc', '', '');
        if (!$group_list) {
            $this->send(Code::success, [
                'total_number' => 0,
                'list'         => [],
            ]);
        } else {
            $group_ids                   = array_column($group_list, 'id');
            $group_goods_ids             = array_column($group_list, 'goods_id');
            $map                         = [];
            $map['group_goods.group_id'] = ['in', $group_ids];
//            $map_str                     = 'group_goods.group_price<goods_sku.price';
            $min_group_price = \App\Model\GroupGoods::alias('group_goods')->join('__GOODS_SKU__ goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT')->where($map)->group('goods_id')->column('group_goods.goods_id,min(group_goods.group_price)');

            $param['ids']  = $group_goods_ids;
            $param['page'] = $this->getPageLimit();
            $goodsLogic    = new \App\Logic\GoodsSearch($param);
            $goods_count   = $goodsLogic->count();
            $goods_list    = $goodsLogic->list();

            foreach ($goods_list as $key => $value) {
                $goods_list[$key]['group_price'] = $min_group_price[$value['id']];
                foreach ($group_list as $k => $v) {
                    if ($value['id'] == $v['goods_id']) {
                        $goods_list[$key]['limit_buy_num'] = $v['limit_buy_num'];
                    }
                }

            }
            $this->send(Code::success, [
                'total_number' => $goods_count,
                'list'         => $goods_list,
            ]);
        }
    }

    /**
     * 拼团商品信息
     * @method GET
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function info()
    {
        $get = $this->get;

        if ($this->validator($get, 'Server/Group.info') !== true) {
            $this->send(Code::param_error, [], $this->getValidator()->getError());
        } else {
            $time                    = time();
            $condition['start_time'] = ['<=', $time];
            $condition['end_time']   = ['>=', $time];
            $condition['is_show']    = 1;
            $condition['goods_id']   = $get['goods_id'];
            $group_data              = \App\Model\Group::getGroupInfo($condition, '', '*');
            if (!$group_data) {
                return $this->send(Code::error, [], '参数错误');
            }

            $goods_id            = $get['goods_id'];
            $goods_info          = \App\Model\Goods::getGoodsInfo(['id' => $goods_id]);
            $goods_info['skus']  = \App\Model\GoodsSku::getGoodsSkuList(['goods_id' => $goods_id], '*', 'id desc', [1,100]);
            $goods_info['group'] = $group_data;

            $this->send(Code::success, ['info' => $goods_info]);
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

        if ($this->validator($get, 'Server/Group.skuInfo') !== true) {
            $this->send(Code::param_error, [], $this->getValidator()->getError());
        } else {
            $group_id            = $get['group_id'];
            $goods_id            = $get['goods_id'];
            $group_goods['skus'] = \App\Model\GroupGoods::getGroupGoodsList(['group_id' => $group_id, 'goods_id' => $goods_id], '', 'goods_sku_id,group_price,captain_price', 'goods_sku_id desc', [1,100]);

            $this->send(Code::success, ['info' => $group_goods]);
        }
    }

    /**
     * 正在拼团列表
     * @method GET
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function groupingSearch()
    {
        $get = $this->get;
        if ($this->validator($get, 'Server/Group.groupingSearch') !== true) {
            $this->send(Code::param_error, [], $this->getValidator()->getError());
        } else {
            $goods_id                          = $get['goods_id'];
            $condition['order.goods_type']     = 2; //拼团
            $condition['order.group_identity'] = 1; //团长
            $condition['order.group_state']    = 1; //正在进行 未满团
            $prefix                            = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
            $table_order_goods                 = $prefix . "order_goods";
            $condition_string                  = "order.id in (SELECT order_id FROM $table_order_goods WHERE order_id=order.id AND goods_id=$goods_id)";
            $orderLogic                        = new OrderLogic($condition, $condition_string);
            $orderLogic->page([1,1000]);
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

    /**
     * 正在拼团详情
     * @method GET
     * @param int $order_id 订单id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function groupingInfo()
    {
        $get = $this->get;
        if ($this->validator($get, 'Server/Group.groupingInfo') !== true) {
            $this->send(Code::param_error, [], $this->getValidator()->getError());
        } else {
            $order_id = $get['order_id'];
            $goods_id = $get['goods_id'];

            $condition['order.id']             = $order_id; //订单id
            $condition['order.goods_type']     = 2; //拼团
            $condition['order.group_identity'] = 1; //团长
            $condition['order.group_state']    = 1; //正在进行 未满团

            $order_goods_id    = \App\Model\OrderGoods::getOrderGoodsId(['order_id' => $order_id, 'goods_id' => $goods_id]);
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

    /**
     * 分享过来的拼团详情
     * @method GET
     * @param int $order_id 订单id
     * @param int $goods_id 拼团活动商品id
     * @author 孙泉
     */
    public function shareGroupingInfo()
    {
        $get = $this->get;
        if ($this->validator($get, 'Server/Group.shareGroupingInfo') !== true) {
            $this->send(Code::param_error, [], $this->getValidator()->getError());
        } else {
            $order_id                          = $get['order_id'];
            $goods_id                          = $get['goods_id'];
            $condition['order.id']             = $order_id; //订单id

            $condition['order.goods_type']     = 2; //拼团
            $condition['order.group_identity'] = 1; //团长
            $condition['order.group_state']    = ['in', '1,2']; //1正在进行中(待开团) 2拼团成功
            $order_goods_id                    = \App\Model\OrderGoods::getOrderGoodsId(['order_id' => $order_id, 'goods_id' => $goods_id]);
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

        if ($this->validator($get, 'Server/Group.allowOpenGroup') !== true) {
            $this->send(Code::param_error, [], $this->getValidator()->getError());
        } else {
            $time                    = time();
            $condition['start_time'] = ['<=', $time];
            $condition['end_time']   = ['>=', $time];
            $condition['is_show']    = 1;
            $condition['goods_id']   = $get['goods_id'];
            if($get['group_id']){
                $condition['id']   = $get['group_id'];
            }
            $group_data              = \App\Model\Group::getGroupInfo($condition, '', '*');
            if (!$group_data) {
                $this->send(Code::success, ['info' => ['state' => 0]]);
            }else{
                $this->send(Code::success, ['info' => ['state' => 1]]);
            }
        }
    }

    /**
     * 允许参团
     * @method GET
     * @param int $group_id 拼团活动id
     * @param int $goods_id 拼团活动商品id
     * @return int $state 1可以参团  0不可以参团
     */
    public function allowJoinGroup()
    {
        $get = $this->get;

        if ($this->validator($get, 'Server/Group.allowJoinGroup') !== true) {
            $this->send(Code::param_error, [], $this->getValidator()->getError());
        } else {
            $time                    = time();
            $condition['start_time'] = ['<=', $time];
            $condition['end_time']   = ['>=', $time];
            $condition['is_show']    = 1;
            $condition['goods_id']   = $get['goods_id'];
            if($get['group_id']){
                $condition['id']   = $get['group_id'];
            }
            $group_data              = \App\Model\Group::getGroupInfo($condition, '', '*');
            if (!$group_data) {
                $this->send(Code::success, ['info' => ['state' => 0]]);
            }else{
                $this->send(Code::success, ['info' => ['state' => 1]]);
            }
        }
    }


}
