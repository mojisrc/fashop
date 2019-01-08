<?php
/**
 *
 * 拼团活动
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
 * 拼团活动
 * Class Group
 * @package App\HttpController\Admin
 */
class Group extends Admin
{
    /**
     * 拼团活动列表
     * @method GET
     * @param string $keywords 关键词 活动名称
     * @param int $state 状态 0未开始 10已开始未生效 20已开始生效中 30已过期未生效 40已过期生效中
     */
    public function list()
    {
        $get           = $this->get;
        $time          = time();
        $condition_str = '';
        $condition     = [];
        if (isset($get['keywords'])) {
            $condition['title'] = ['like', '%' . $get['keywords'] . '%'];
        }
        if (isset($get['state']) && $get['state'] >= 0) {

            switch ($get['state']) {
                case 0:
                    $condition['start_time'] = ['gt', $time];
                    break;
                case 10:
                    $condition['start_time'] = ['elt', $time];
                    $condition['end_time']   = ['egt', $time];
                    $condition['is_show']    = 0;
                    break;
                case 20:
                    $condition['start_time'] = ['elt', $time];
                    $condition['end_time']   = ['egt', $time];
                    $condition['is_show']    = 1;
                    break;
                case 30:
                    $condition['end_time'] = ['lt', $time];
                    $condition['is_show']  = 0;
                    break;
                case 40:
                    $condition['end_time'] = ['lt', $time];
                    $condition['is_show']  = 1;
                    break;
            }
        }

        $group_model = model('Group');
        $count       = $group_model->getGroupCount($condition, $condition_str);
        $list        = $group_model->getGroupList($condition, $condition_str, '*', 'id desc', $this->getPageLimit(), '');
        $this->send(Code::success, [
            'total_number' => $count,
            'list'         => $list,
        ]);
    }

    /**
     * 拼团活动信息
     * @method GET
     * @param int $id
     * @author 孙泉
     */
    public function info()
    {
        $get   = $this->get;
        $error = $this->validate($get, 'Admin/Group.info');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $group_model = model('Group');
            $info        = $group_model->getGroupInfo(['id' => $get['id']]);
            $this->send(Code::success, ['info' => $info]);
        }

    }

    /**
     * 添加拼团活动
     * @method POST
     * @param string title              名称
     * @param string time_over_day      时限天数
     * @param string time_over_hour     时限小时
     * @param string time_over_minute   时限分钟
     * @param string start_time         开始时间
     * @param string end_time           结束时间
     * @param string limit_buy_num      拼团人数
     * @param string limit_group_num    每位用户可进行的团数
     * @param string limit_goods_num    用户每次参团时可购买件数
     * @param array  group_goods        数组 格式 [ ['goods_id'=>1,'goods_sku_id'=>1,'group_price'=>1,'captain_price'=>1],['goods_id'=>2,'goods_sku_id'=>2,'group_price'=>2,'captain_price'=>2...] ] 商品选择数组 可为空数组
     * 注释：
     * goods_id         商品主表id 只能选择一个商品 group_goods里goods_id必须为一样
     * goods_sku_id     商品id
     * group_price      拼团价格
     * captain_price    团长价格
     */
    public function add()
    {
        $post  = $this->post;
        $error = $this->validate($post, 'Admin/Group.add');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $data                     = [];
            $data['title']            = $post['title'];
            $data['time_over_day']    = $post['time_over_day'];
            $data['time_over_hour']   = $post['time_over_hour'];
            $data['time_over_minute'] = $post['time_over_minute'];
            $data['limit_buy_num']    = $post['limit_buy_num'];
            $data['limit_group_num']  = $post['limit_group_num'];
            $data['limit_goods_num']  = $post['limit_goods_num'];
            $data['time_over']        = ($post['time_over_day'] * 24 + $post['time_over_hour']) . ':' . $post['time_over_minute'];
            $data['start_time']       = strtotime($post['start_time']);
            $data['end_time']         = strtotime($post['end_time']);
            $data['create_time']      = time();
            $data['update_time']      = time();

            $group_model = model('Group');
            $group_model->startTrans();
            $group_id = $group_model->insertGroup($data);
            if (!$group_id) {
                $group_model->rollback();
                return $this->send(Code::error);
            }

            $group_goods_model = model('GroupGoods');
            $group_goods       = [];
            if (isset($post['group_goods']) && is_array($post['group_goods']) && $post['group_goods']) {
                $goods_id_arr = array_column($post['group_goods'], 'goods_id');
                if (count(array_unique($goods_id_arr)) != 1) {
                    return $this->send(Code::param_error, [], '只能选择一个商品');
                }
                foreach ($post['group_goods'] as $key => $value) {
                    if (intval($value['goods_id']) <= 0 || intval($value['goods_sku_id']) <= 0) {
                        return $this->send(Code::param_error, [], '必须选择商品规格');
                    }

                    if ($value['captain_price'] > $value['group_price']) {
                        return $this->send(Code::param_error, [], '团长价不能大于拼团价');
                    }
                    $group_goods[$key]['group_id']      = $group_id;
                    $group_goods[$key]['goods_id']      = $value['goods_id'];
                    $group_goods[$key]['goods_sku_id']  = $value['goods_sku_id'];
                    $group_goods[$key]['group_price']   = $value['group_price'];
                    $group_goods[$key]['captain_price'] = $value['captain_price'];
                    $group_goods[$key]['create_time']   = time();
                }
                $group_goods_result = $group_goods_model->insertAllGroupGoods($group_goods);
                if (!$group_goods_result) {
                    $group_model->rollback();
                    return $this->send(Code::error);
                }
            }

            $group_model->commit();
            return $this->send(Code::success);

        }
    }

    /**
     * 编辑拼团活动
     * @method POST
     * @param int    id                 数据id
     * @param string title              名称
     * @param string time_over_day      时限天数
     * @param string time_over_hour     时限小时
     * @param string time_over_minute   时限分钟
     * @param string start_time         开始时间
     * @param string end_time           结束时间
     * @param string limit_buy_num      拼团人数
     * @param string limit_group_num    每位用户可进行的团数
     * @param string limit_goods_num    用户每次参团时可购买件数
     * @param array  group_goods        数组 格式 [ ['goods_id'=>1,'goods_sku_id'=>1,'group_price'=>1,'captain_price'=>1],['goods_id'=>2,'goods_sku_id'=>2,'group_price'=>2,'captain_price'=>2...] ] 商品选择数组 可为空数组
     * 注释：
     * goods_id         商品主表id 只能选择一个商品 group_goods里goods_id必须为一样
     * goods_sku_id     商品id
     * group_price      拼团价格
     * captain_price    团长价格
     * 备注：如果只想改活动不想改商品的话 group_goods传递后台所有的数据源信息[上面格式的商品数据信息]，不可为空 为空代表删除所有商品
     */
    public function edit()
    {
        $post  = $this->post;
        $error = $this->validate($post, 'Admin/Group.edit');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $data                     = [];
            $data['title']            = $post['title'];
            $data['time_over_day']    = $post['time_over_day'];
            $data['time_over_hour']   = $post['time_over_hour'];
            $data['time_over_minute'] = $post['time_over_minute'];
            $data['limit_buy_num']    = $post['limit_buy_num'];
            $data['limit_group_num']  = $post['limit_group_num'];
            $data['limit_goods_num']  = $post['limit_goods_num'];
            $data['time_over']        = ($post['time_over_day'] * 24 + $post['time_over_hour']) . ':' . $post['time_over_minute'];
            $data['start_time']       = strtotime($post['start_time']);
            $data['end_time']         = strtotime($post['end_time']);
            $data['update_time']      = time();

            $condition       = [];
            $condition['id'] = $post['id'];

            $group_model = model('Group');
            $group_model->startTrans();
            $group_result = $group_model->updateGroup($condition, $data);
            if (!$group_result) {
                $group_model->rollback();
                return $this->send(Code::error);
            }

            $group_goods_model = model('GroupGoods');
            $group_goods       = [];
            $map               = [];
            $map['group_id']   = $post['id'];
            //查询活动商品sku ids
            $goods_sku_ids = $group_goods_model->getGroupGoodsIndexesColumn($map, '', 'goods_sku_id', 'id');

            if (isset($post['group_goods']) && is_array($post['group_goods']) && $post['group_goods']) {
                $goods_id_arr = array_column($post['group_goods'], 'goods_id');
                if (count(array_unique($goods_id_arr)) != 1) {
                    return $this->send(Code::param_error, [], '只能选择一个商品');
                }
                foreach ($post['group_goods'] as $key => $value) {
                    if (intval($value['goods_id']) <= 0 || intval($value['goods_sku_id']) <= 0) {
                        return $this->send(Code::param_error, [], '必须选择商品规格');
                    }

                    if ($value['captain_price'] > $value['group_price']) {
                        return $this->send(Code::param_error, [], '团长价不能大于拼团价');
                    }

                    $group_goods[$key]['group_id']      = $post['id'];
                    $group_goods[$key]['goods_id']      = $value['goods_id'];
                    $group_goods[$key]['goods_sku_id']  = $value['goods_sku_id'];
                    $group_goods[$key]['group_price']   = $value['group_price'];
                    $group_goods[$key]['captain_price'] = $value['captain_price'];
                    $group_goods[$key]['create_time']   = time();
                    $group_goods[$key]['update_time']   = time();

                }

                if ($goods_sku_ids) {

                    //提交的商品sku ids
                    $group_goods_ids = array_column($group_goods, 'goods_sku_id');

                    //交集
                    $intersection_goods_sku_ids = array_intersect($goods_sku_ids, $group_goods_ids);

                    //返回出现在第一个数组中但其他数组中没有的值 [新添加的sku]
                    $difference_goods_sku_add_ids = array_diff($group_goods_ids, $goods_sku_ids);

                    //返回出现在第一个数组中但其他数组中没有的值 [已删除的sku]
                    $difference_goods_sku_del_ids = array_diff($goods_sku_ids, $group_goods_ids);

                    //交集
                    if ($intersection_goods_sku_ids) {
                        $group_goods_updata = [];

                        foreach ($group_goods as $key => $value) {
                            if (in_array($value['goods_sku_id'], $intersection_goods_sku_ids)) {
                                unset($value['create_time']);
                                $value['id']          = array_search($value['goods_sku_id'], $intersection_goods_sku_ids);
                                $group_goods_updata[] = $value;
                            }
                        }

                        $result = [];
                        $result = $group_goods_model->updateAllGroupGoods($group_goods_updata);

                        if (!$result) {
                            $group_model->rollback();// 回滚事务
                            return $this->send(Code::error);
                        }

                    }

                    //差集 [新添加的sku]
                    if ($difference_goods_sku_add_ids) {
                        $group_goods_insert_data = [];

                        foreach ($group_goods as $key => $value) {
                            if (in_array($value['goods_sku_id'], $difference_goods_sku_add_ids)) {
                                $group_goods_insert_data[] = $value;
                            }
                        }

                        $result = [];
                        $result = $group_goods_model->insertAllGroupGoods($group_goods_insert_data);
                        if (!$result) {
                            $group_model->rollback();// 回滚事务
                            return $this->send(Code::error);
                        }
                    }

                    //差集 [已删除的sku]
                    if ($difference_goods_sku_del_ids) {
                        $map['goods_sku_id'] = ['in', $difference_goods_sku_del_ids];
                        $result              = [];
                        $result              = $group_goods_model->delGroupGoods($map);

                        if (!$result) {
                            $group_model->rollback();// 回滚事务
                            return $this->send(Code::error);
                        }

                    }

                } else {
                    $result = [];
                    $result = $group_goods_model->insertAllGroupGoods($group_goods);
                    if (!$result) {
                        $group_model->rollback();// 回滚事务
                        return $this->send(Code::error);
                    }

                }

            } else {//为空代表删除所有goods_sku,前提：该活动这之前存在商品

                if ($goods_sku_ids) {
                    //删除活动下商品
                    $group_goods_result = $group_goods_model->delGroupGoods($map);
                    if (!$group_goods_result) {
                        $group_model->rollback();// 回滚事务
                        return $this->send(Code::error);
                    }
                }

            }

            $group_model->commit();
            return $this->send(Code::success);

        }
    }

    /**
     * 拼团活动可选择商品列表
     * @method GET
     * @param string title          商品名称
     * @param array  category_ids   分类id 数组格式
     */
    public function selectableGoods()
    {

        $get   = $this->get;
        $group_model       = model('Group');
        $group_goods_model = model('GroupGoods');

        //查询活动
        $condition             = [];
        $condition['end_time'] = ['lt', time()];
        $condition['is_show']  = 0;
        $group_ids             = $group_model->getGroupColumn($condition);

        $param = [];
        if (isset($get['title'])) {
            $param['title'] = $get['title'];
        }

        if (isset($get['category_ids'])) {
            $param['category_ids'] = $get['category_ids'];
        }

        //查询活动商品ids
        if ($group_ids) {
            $goods_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => ['in', $group_ids]], '', 'goods_id');
            if ($goods_ids) {
                $param['not_in_ids'] = $goods_ids;
            }
        }

        $goodsLogic = new \App\Logic\GoodsSearch($param);
        return $this->send(Code::success, [
            'total_number' => $goodsLogic->count(),
            'list'         => $goodsLogic->list(),
        ]);


    }

//    /**
//     * 拼团活动已选择商品列表
//     * @method GET
//     * @param int     group_id 拼团活动id
//     */
//    public function selectedGoods()
//    {
//
//        $get   = $this->get;
//        $error = $this->validate($get, 'Admin/Group.selectedGoods');
//        if ($error !== true) {
//            return $this->send(Code::error, [], $error);
//        } else {
//
//            $group_model       = model('Group');
//            $group_goods_model = model('GroupGoods');
//
//            //查询活动
//            $group_data = $group_model->getGroupInfo(['id' => $get['group_id']], '', '*');
//            if (!$group_data) {
//                return $this->send(Code::param_error);
//            }
//
//            //查询活动商品ids
//            $goods_ids              = $group_goods_model->getGroupGoodsColumn(['group_id' => $get['group_id']], '', 'goods_id');
//            $intersection_goods_ids = [];
//            if ($goods_ids) {
//                $online_goods_ids = model('Goods')->getGoodsColumn(['id' => ['in', $goods_ids], 'is_on_sale' => 1], 'id');
//                //交集 group_goods表和goods表的商品交集
//                $intersection_goods_ids = array_values(array_intersect($goods_ids, $online_goods_ids));
//
//                //返回出现在第一个数组中但其他数组中没有的值 [将要删除的商品]
//                $difference_goods_del_ids = array_diff($goods_ids, $online_goods_ids);
//
//                if ($difference_goods_del_ids) {
//                    //删除活动下失效商品
//                    $group_goods_result = $group_goods_model->delGroupGoods(['group_id' => $get['group_id'], 'goods_id' => array('in', $difference_goods_del_ids)]);
//                    if (!$group_goods_result) {
//                        return $this->send(Code::error);
//                    }
//                }
//
//            }
//            $param        = [];
//            $param['ids'] = $intersection_goods_ids ? $intersection_goods_ids : [];
//            $goodsLogic   = new \App\Logic\GoodsSearch($param);
//            return $this->send(Code::success, [
//                'total_number' => $intersection_goods_ids ? $goodsLogic->count() : 0,
//                'list'         => $intersection_goods_ids ? $goodsLogic->list() : [],
//            ]);
//
//        }
//
//    }

    /**
     * 拼团活动已选择商品sku列表
     * @method GET
     * @param int    group_id 拼团活动id
     */
    public function goodsSkuList()
    {

        $get   = $this->get;
        $error = $this->validate($get, 'Admin/Group.goodsSkuList');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {

            $group_model       = model('Group');
            $group_goods_model = model('GroupGoods');

            //查询活动
            $group_data = $group_model->getGroupInfo(['id' => $get['group_id']], '', '*');
            if (!$group_data) {
                return $this->send(Code::param_error);
            }

            //查询活动商品sku ids
            $goods_sku_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $get['group_id']], '', 'goods_sku_id');

            if (!$goods_sku_ids) {
                return $this->send(Code::error);
            }

            $condition                 = [];
            $condition['goods_sku.id'] = ['in', $goods_sku_ids];

            //查询该商品下所有sku和已设置拼团活动的数据
            $goods_sku_count = $group_goods_model->getGoodsSkuMoreCount($condition);
            $goods_sku_list  = $group_goods_model->getGoodsSkuMoreList($condition, '', 'goods_sku.*,group_goods.group_id,group_price,captain_price', 'goods_sku.id asc', '');

            return $this->send(Code::success, [
                'total_number' => $goods_sku_count,
                'list'         => $goods_sku_list,
            ]);

        }

    }

    /**
     * 拼团活动设置
     * @method POST
     * @param int id 拼团活动id
     */
    public function showSet()
    {
        $post  = $this->post;
        $error = $this->validate($post, 'Admin/Group.info');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $group_model     = model('Group');
            $condition       = [];
            $condition['id'] = $post['id'];
            $info            = $group_model->getGroupInfo($condition);

            if (!$info) {
                return $this->send(Code::param_error);
            } else {

                if ($info['is_show'] == 1) {
                    $is_show = 0;
                } else {
                    if (time() >= $info['start_time'] && time() <= $info['end_time'] && $info['is_show'] == 0) {
                        $is_show_data = $group_model->getGroupInfo(['is_show' => 1]);
                        if ($is_show_data) {
                            return $this->send(Code::param_error, [], '请关闭其他生效的活动再进行操作');

                        }

                        $is_show = 1;
                    }
                }

                if (!isset($is_show)) {
                    return $this->send(Code::param_error);
                }

                $result = $group_model->updateGroup($condition, ['is_show' => $is_show]);
                if ($result) {
                    return $this->send(Code::success);
                } else {
                    return $this->send(Code::error);
                }
            }

        }
    }


    /**
     * 删除拼团活动
     * @method POST
     * @param int id 拼团活动id
     */
    public function del()
    {
        $post  = $this->post;
        $error = $this->validate($post, 'Admin/Group.del');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $group_model       = model('Group');
            $group_goods_model = model('GroupGoods');
            $condition         = [];
            $condition['id']   = $post['id'];
            $info              = $group_model->getGroupInfo($condition);

            if (!$info) {
                return $this->send(Code::param_error);
            } else {

                if ($info['is_show'] == 1) {
                    return $this->send(Code::param_error, [], '请使活动失效再进行操作');

                } else {
                    if (time() >= $info['start_time'] && time() <= $info['end_time'] && $info['is_show'] == 0) {
                        return $this->send(Code::param_error, [], '请使活动过期再进行操作');
                    }
                }
                $group_model->startTrans();
                //删除拼团活动
                $group_result = $group_model->delGroup($condition);
                if (!$group_result) {
                    $group_model->rollback();
                    return $this->send(Code::error);
                }
                //删除拼团活动商品
                $group_goods_result = $group_goods_model->delGroupGoods($condition);
                if (!$group_goods_result) {
                    $group_model->rollback();
                    return $this->send(Code::error);
                }

                $group_model->commit();
                return $this->send(Code::success);
            }

        }
    }

    /**
     * 商品列表
     * @method GET
     * @author 孙泉
     */
    public function pageGoods()
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

            $group_goods_ids = $group_goods_model->getGroupGoodsColumn(['group_id' => $group_data['id']], '', 'goods_id');

            if (!$group_goods_ids) {
                $this->send(Code::success, [
                    'total_number' => 0,
                    'list'         => [],
                ]);

            } else {
                $min_group_price = $group_goods_model->where(['group_id' => $group_data['id'], 'goods_id' => ['in', $group_goods_ids]])->group('goods_id')->column('goods_id,min(group_price)');
                $param['ids']    = $group_goods_ids;
                $param['page']   = $this->getPageLimit();
                $goodsLogic      = new \App\Logic\GoodsSearch($param);
                $goods_count     = $goodsLogic->count();
                $goods_list      = $goodsLogic->list();
                foreach ($goods_list as $key => $value) {
                    $goods_list[$key]['group_price'] = $min_group_price[$value['id']];
                }
                $this->send(Code::success, [
                    'info'         => ['group_id' => $group_data['id'], 'limit_buy_num' => $group_data['limit_buy_num']],
                    'total_number' => $goods_count,
                    'list'         => $goods_list,
                ]);
            }
        }
    }

}