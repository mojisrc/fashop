<?php
/**
 *
 * 分销员等级
 * 推广金：推广金是不包含下级分销员的推广的，是自己推广客户购买的金额哦
 * 累计推广金是在订单佣金结算后才统计到累计推广金里 运费是不算的 【不含退款金额 不含运费(不含的这俩不区分结不结算状态)】
 *
 * 消费金：结算以后开始统计，分销员累计消费金即在分销员等级开启期间，分销员累计购买的实际成交金额，不包含运费，计入时间根据分销员设置里的选项而定。若发生退款，消费金计入前退款消费金会进行相应的扣除，计入后退款的不扣除
 *
 * 按创建这个等级后统计推广金和消费金 和修改等级没关系  创建之前的历史数据不统计
 *
 * 我作为分销员：我自己买一单以后 或者 我推广一笔 才显示升级降级（不统计此时的这笔正在下的订单）
 *
 * 累计客户数、累计邀请数 这两个都会包含已失效的，只要是建立过的关系，都会计算的
 *
 * 提示：推广金、消费金在等级设置后开始统计，累计客户数、累计邀请数在成为分销员后开始统计
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 分销员等级
 * Class DistributorLevel
 * @package App\HttpController\Admin
 */
class Distributorlevel extends Admin
{

    /**
     * 分销员等级
     * @method GET
     */
    public function list()
    {
        $condition               = [];
        $distributor_level_model = new \App\Model\DistributorLevel;
        $count                   = $distributor_level_model->getDistributorLevelCount($condition);
        $field                   = '*';
        $order                   = 'id asc';
        $list                    = $distributor_level_model->getDistributorLevelList($condition, $field, $order, $this->getPageLimit(), '');
        return $this->send(Code::success, [
            'total_number' => $count,
            'list'         => $list,
        ]);
    }

    /**
     * 分销员等级信息
     * @method GET
     * @param int id 数据id
     * @author 孙泉
     */
    public function info()
    {
        $get   = $this->get;
        $error = $this->validator($get, 'Admin/DistributorLevel.info');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distributor_level_model = new \App\Model\DistributorLevel;
            $condition               = [];
            $condition['id']         = $get['id'];
            $field                   = '*';
            $info                    = $distributor_level_model->getDistributorLevelInfo($condition, $field);
            return $this->send(Code::success, ['info' => $info]);
        }

    }

    /**
     * 分销员等级添加
     * @method POST
     * @param int   title               名称
     * @param int   ratio               佣金比例
     * @param int   invite_ratio        邀请奖励佣金比例
     * @param float promotion_amount    推广金
     * @param float total_amount        总金额（推广金+消费金）
     * @param float customer_num        累计客户数
     * @param float distributor_num     累计分销员数
     * @param array upgrade_rules       升级规则 ['promotion_amount', 'total_amount', 'customer_num', 'distributor_num'] 至少一种
     */
    public function add()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/DistributorLevel.add');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distributor_level_model         = new \App\Model\DistributorLevel;
            $insert_data                     = [];
            $insert_data['title']            = $post['title'];
            $insert_data['ratio']            = floatval($post['ratio']);
            $insert_data['invite_ratio']     = floatval($post['invite_ratio']);
            $insert_data['promotion_amount'] = floatval($post['promotion_amount']);
            $insert_data['total_amount']     = floatval($post['total_amount']);
            $insert_data['customer_num']     = intval($post['customer_num']);
            $insert_data['distributor_num']  = intval($post['distributor_num']);
            $insert_data['upgrade_rules']    = $post['upgrade_rules'];
            $insert_data['level']            = $distributor_level_model->max('level') + 1;
            $insert_data['create_time']      = time();
            $insert_data['update_time']      = time();
            $result                          = $distributor_level_model->insertDistributorLevel($insert_data);

            if ($result) {
                return $this->send(Code::success);
            } else {
                return $this->send(Code::error);
            }
        }
    }

    /**
     * 分销员等级编辑
     * @method POST
     * @param int   id                  数据id
     * @param int   title               名称
     * @param int   ratio               佣金比例
     * @param int   invite_ratio        邀请奖励佣金比例
     * @param float promotion_amount    推广金
     * @param float total_amount        总金额（推广金+消费金）
     * @param float customer_num        累计客户数
     * @param float distributor_num     累计分销员数
     * @param array upgrade_rules       升级规则 ['promotion_amount', 'total_amount', 'customer_num', 'distributor_num']
     *                                  至少一种 id为1为空
     */
    public function edit()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/DistributorLevel.edit');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distributor_level_model = new \App\Model\DistributorLevel;
            $condition               = [];
            $condition['id']         = $post['id'];
            $level_info              = $distributor_level_model->getDistributorLevelInfo($condition, '*');
            if (!$level_info) {
                return $this->send(Code::param_error, [], '参数错误');
            }
            $update_data                     = [];
            $update_data['title']            = $post['title'];
            $update_data['ratio']            = floatval($post['ratio']);
            $update_data['invite_ratio']     = floatval($post['invite_ratio']);
            $update_data['promotion_amount'] = floatval($post['promotion_amount']);
            $update_data['total_amount']     = floatval($post['total_amount']);
            $update_data['customer_num']     = intval($post['customer_num']);
            $update_data['distributor_num']  = intval($post['distributor_num']);
            $update_data['upgrade_rules']    = ($level_info['id'] == 1) ? [] : $post['upgrade_rules'];
            $update_data['create_time']      = time();
            $update_data['update_time']      = time();
            $result                          = $distributor_level_model->updateDistributorLevel(['id' => $level_info['id']], $update_data);

            if ($result) {
                return $this->send(Code::success);
            } else {
                return $this->send(Code::error);
            }
        }
    }

    /**
     * 删除等级
     * @method POST
     * @param int id 数据id
     * 第一级不可以删除，只能从最高级依次删除。
     * 分销员等级被删除后，对应的分销员不会被删除，而是会自动依次降级哦。
     */
    public function del()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/DistributorLevel.del');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            if ($post['id'] == 1) {
                return $this->send(Code::param_error, [], '第一级不可以删除');
            }

            $distributor_model       = new \App\Model\Distributor;
            $distributor_level_model = new \App\Model\DistributorLevel;
            $condition               = [];
            $condition['id']         = $post['id'];
            $distributor_level_info  = $distributor_level_model->getDistributorLevelInfo($condition);
            if (!$distributor_level_info) {
                return $this->send(Code::param_error, [], '参数错误');
            }
            $max_level = $distributor_level_model->max('level');

            if ($distributor_level_info['level'] != $max_level) {
                return $this->send(Code::param_error, [], '只能从最高级依次删除');
            }
            $distributor_level_model->startTransaction();

            //删除分销等级
            $distributor_level_result = $distributor_level_model->delDistributorLevel(['id' => $post['id']]);
            if (!$distributor_level_result) {
                $distributor_level_model->rollback();
                return $this->send(Code::error);
            }

            //对应的分销员 降级
            $distributor_ids = $distributor_model->getDistributorColumn(['level' => $distributor_level_info['level']], 'id');
            if ($distributor_ids) {
                $distributor_result = $distributor_model->setDecDistributor(['id' => ['in', $distributor_ids]], 'level', 1);
                if (!$distributor_result) {
                    $distributor_level_model->rollback();
                    return $this->send(Code::error);
                }
            }

            $distributor_level_model->commit();
            return $this->send(Code::success);
        }
    }


}