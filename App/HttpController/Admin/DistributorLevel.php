<?php
/**
 *
 * 分销员等级
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
 * 分销员等级
 * Class DistributorLevel
 * @package App\HttpController\Admin
 */
class DistributorLevel extends Admin
{

    /**
     * 分销员等级
     * @method GET
     */
    public function list()
    {
        $condition_str           = '';
        $condition               = [];
        $distributor_level_model = model('DistributorLevel');
        $count                   = $distributor_level_model->getDistributorLevelCount($condition, $condition_str);
        $field                   = '*';
        $order                   = 'id asc';
        $list                    = $distributor_level_model->getDistributorLevelList($condition, $condition_str, $field, $order, $this->getPageLimit(), '');
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
            $distributor_level_model = model('DistributorLevel');
            $condition               = [];
            $condition['id']         = $get['id'];
            $field                   = '*';
            $info                    = $distributor_level_model->getDistributorLevelInfo($condition, '', $field);
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
            $distributor_level_model         = model('DistributorLevel');
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
            $distributor_level_model = model('DistributorLevel');
            $condition               = [];
            $condition['id']         = $post['id'];
            $level_info              = $distributor_level_model->getDistributorLevelInfo($condition, '', '*');
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

            $distributor_model       = model('Distributor');
            $distributor_level_model = model('DistributorLevel');
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
            $distributor_level_model->startTrans();

            //删除分销等级
            $distributor_level_result = $distributor_level_model->delDistributorLevel(['id' => $post['id']]);
            if (!$distributor_level_result) {
                $distributor_level_model->rollback();
                return $this->send(Code::error);
            }

            //对应的分销员 降级
            $distributor_ids = $distributor_model->getDistributorColumn(['level' => $distributor_level_info['level']], '', 'id');
            if ($distributor_ids) {
                $distributor_result = $distributor_model->setDecDistributor(['id' => ['in', $distributor_ids]], '', 'level', 1);
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