<?php
/**
 *
 * 分销员
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
 * 分销员
 * Class Distributor
 * @package App\HttpController\Admin
 */
class Distributor extends Admin
{

    /**
     * 分销员
     * @method GET
     * @param string phone          分销员手机号
     * @param string invite_phone   邀请方手机
     * @param string state          0待审核 1审核通过 2审核拒绝
     * @param array  create_time    申请时间[开始时间,结束时间]
     * 成为分销员必须绑定手机号（如有该手机号则不用注册新账号 无该手机号需要注册新账号）
     * 分销员累计成交笔数 累计成交金额 分销员A邀请分销员B B推广客户C  C下单付款后  给B计算 和A没有关系
     * 分销员的累计成交笔数和累计成交金额都包含分销员自己购买的订单
     * 累计成交金额的话，不算退款金额。退成功后，才不含的。
     * 分销员累计成交笔数是什么意思？ 分销员累计推广成功交易笔数，成功付款之后才会计入分销员的累计成交笔数中，退款不扣除成交笔数。
     * 累计成交金额包含退款金额吗？ 累计成交金额、累计推广金、累计消费金都不含退款金额。
     * 分销员累计成交金额是指客户实付金额，还是订单的总金额？ 单笔订单的成交额=实付金额-运费； 累计成交额是单笔订单的成交额的累加。
     * 累计成交金额包含开启购买权限以后，分销员自己购买的金额吗？ 分销员自己购买的金额是包含的。
     * 分销员累计成交额是什么时间统计？ 分销员累计成交金额是在成功付款之后进行统计。
     * 不参与推广的商品，分销员推广出去会计算累计推广金和累计成交额吗？分销员跟客户绑定了关系，客户点击分销员分享的链接购买，分两种情况： 1.如果商品参与推广，那么有佣金，参与累计成交额的统计； 2.如果商品不参与推广，那么无佣金，但会参与累计成交额的统计。
     * 累计成交金额：分销员累计推广成功的实际成交金额，成功付款之后才会计入分销员的累计推广金额中。佣金未结算，退款后会扣除，佣金已结算，退款不会扣除。
     * /////这边买家申请退款的时候，是先退商品部分，再退运费部分的。比如买家申请时，申请的金额是大于商品的金额的，那么就是商品全退，剩下部分是运费。申请金额小于商品金额的话，那么就是退商品部分，运费不算。/////
     * 分销员审核信息中的累计消费金额和笔数是怎么计算的？ 展示的是申请时的订单和消费金额，付款成功就会计算了。这俩同时符合：包含退款过程中的，但是不包含退款成功的。
     */
    public function list()
    {
        $get                            = $this->get;
        $prefix                         = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
        $table_order                    = $prefix . "order";
        $condition                      = [];
        $condition['distributor.state'] = 1; //默认0 待审核 1审核通过 2审核拒绝

        if ($get['state'] != '' && in_array(intval($get['state']), [0, 1, 2])) {
            $condition['distributor.state'] = intval($get['state']); //默认0 待审核 1审核通过 2审核拒绝
        }

        $condition['distributor.is_retreat'] = 0; //默认0有效 1无效（被清退）
        if (isset($get['phone'])) {
            $condition['user.phone'] = $get['phone'];
        }

        if (isset($get['invite_phone'])) {
            $condition['invite_user.phone'] = $get['invite_phone'];
        }

        if ($get['create_time'] != '' && is_array($get['create_time'])) {
            $condition['distributor.create_time'] = ['between', $get['create_time']];
        }

        $distributor_model = model('Distributor');
        $count             = $distributor_model->getDistributorMoreCount($condition, '');
        $field             = 'distributor.*,user.phone,invite_user.phone AS invite_phone';

        //total_deal_num        累计成交笔数
        //total_deal_amount     累计成交金额
        //total_consume_num     累计消费笔数
        //total_consume_amount  累计消费金额
        $field = $field . ",
        (SELECT COUNT(id) FROM $table_order WHERE (distribution_user_id=distributor.user_id AND state>=20) OR (user_id=distributor.user_id AND state>=20)) AS total_deal_num,
        
        (SELECT CASE WHEN refund_state=0 THEN CASE WHEN revise_amount>0 THEN SUM(revise_amount-revise_freight_fee) ELSE SUM(amount-freight_fee) END WHEN refund_state=1 THEN CASE WHEN revise_amount>0 THEN CASE WHEN SUM(revise_amount-revise_freight_fee-refund_amount)>0 THEN SUM(revise_amount-revise_freight_fee-refund_amount) ELSE 0 END ELSE CASE WHEN SUM(amount-freight_fee-refund_amount)>0 THEN SUM(amount-freight_fee-refund_amount) ELSE 0 END END ELSE 0 END FROM $table_order WHERE (distribution_user_id=distributor.user_id AND state>=20) OR (user_id=distributor.user_id AND state>=20)) AS total_deal_amount,
        
        (SELECT COUNT(id) FROM $table_order WHERE user_id=distributor.user_id AND state>=20 AND CASE WHEN revise_amount>0 THEN revise_amount>refund_amount ELSE amount>refund_amount END) AS total_consume_num,
        
        (SELECT CASE WHEN refund_state=0 THEN CASE WHEN revise_amount>0 THEN SUM(revise_amount) ELSE SUM(amount) END WHEN refund_state=1 THEN CASE WHEN revise_amount>0 THEN SUM(revise_amount-refund_amount) ELSE SUM(amount-refund_amount) END ELSE 0 END FROM $table_order WHERE user_id=distributor.user_id AND state>=20) AS total_consume_amount";

        $order = 'distributor.id desc';
        $list  = $distributor_model->getDistributorMoreList($condition, '', $field, $order, $this->getPageLimit(), '');

        return $this->send(Code::success, [
            'total_number' => $count,
            'list'         => $list,
        ]);
    }

    /**
     * 分销员信息
     * @method GET
     * @param int id 数据id
     * @author 孙泉
     */
    public function info()
    {
        $get   = $this->get;
        $error = $this->validator($get, 'Admin/Distributor.info');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distributor_model = model('Distributor');
            $condition         = [];
            $condition['id']   = $get['id'];
            $field             = '*';
            $info              = $distributor_model->getDistributorInfo($condition, '', $field);
            return $this->send(Code::success, ['info' => $info]);
        }
    }

    /**
     * 分销员编辑（修改昵称）
     * @method POST
     * @param int   id                  数据id
     * @param int   nickname            昵称
     */
    public function edit()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/Distributor.edit');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distributor_model = model('Distributor');
            $condition         = [];
            $condition['id']   = $post['id'];
            $info              = $distributor_model->getDistributorInfo($condition, '', '*');
            if (!$info) {
                return $this->send(Code::param_error, [], '参数错误');
            }
            $update_data             = [];
            $update_data['nickname'] = $post['nickname'];
            $result                  = $distributor_model->updateDistributor(['id' => $info['id']], $update_data);

            if ($result) {
                return $this->send(Code::success);
            } else {
                return $this->send(Code::error);
            }
        }
    }

    /**
     * 清退分销员
     * @method POST
     * @param int id 数据id
     * 分销员清退后客户关系还在吗？ 清退后该分销员的客户关系还在，但是分销员的上下级关系会失效，即分销员的累计邀请会全部失效，请谨慎操作。就是清退之后，再重新申请之后，是不会有上下级关系的。
     * 分销员清退之后，之前已经推广出去的链接，还能绑定客户关系吗？ 还可以绑定客户关系的，只是客户下单，分销员不会有佣金。
     * 将分销员清退，然后重新申请成为分销员，分销员清退之前产生的累计推广金会累计吗？ 分销员清退后，累积的推广金会被清零。
     * 分销员被清退了，之前未结算的佣金还会结算吗？ 清退之前产生的订单，就算清退了也能进行结算，结算后可以进行提现。
     * 分销员被清退后，如何重新申请成为分销员？ 商家可以发送招募链接给这个分销员，分销员可以通过点击链接，再次申请加入哦。
     */
    public function retreat()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/Distributor.retreat');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distributor_model       = model('Distributor');
            $condition               = [];
            $condition['id']         = $post['id'];
            $condition['state']      = 1; //默认0 待审核 1审核通过 2审核拒绝
            $condition['is_retreat'] = 0; //默认0有效 1无效（被清退）
            $distributor_info        = $distributor_model->getDistributorInfo($condition);
            if (!$distributor_info) {
                return $this->send(Code::param_error, [], '参数错误');
            }

            $distributor_model->startTransaction();

            //清退此分销员 和  清理此分销员的上级关系
            $distributor_result = $distributor_model->updateDistributor(['id' => $distributor_info['id']], ['is_retreat' => 1, 'inviter_id' => 0]);
            if (!$distributor_result) {
                $distributor_model->rollback();
                return $this->send(Code::error);
            }

            // 清理此分销员的下级关系
            $subordinate_result = $distributor_model->updateDistributor(['inviter_id' => $distributor_info['id']], ['inviter_id' => 0]);
            if (!$subordinate_result) {
                $distributor_model->rollback();
                return $this->send(Code::error);
            }

            $distributor_model->commit();
            return $this->send(Code::success);

        }
    }

    /**
     * 分销员审核
     * @method POST
     * @param int id    数据id
     * @param int state 状态 1审核通过 2审核拒绝
     */
    public function review()
    {
        $post  = $this->post;
        $error = $this->validator($post, 'Admin/Distributor.review');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $distributor_model       = model('Distributor');
            $condition               = [];
            $condition['id']         = $post['id'];
            $condition['state']      = 0; //默认0 待审核 1审核通过 2审核拒绝
            $condition['is_retreat'] = 0; //默认0有效 1无效（被清退）
            $distributor_info        = $distributor_model->getDistributorInfo($condition);
            if (!$distributor_info) {
                return $this->send(Code::param_error, [], '参数错误');
            }

            $distributor_result = $distributor_model->updateDistributor(['id' => $distributor_info['id']], ['state' => $post['state']]);
            if (!$distributor_result) {
                return $this->send(Code::error);
            }

            return $this->send(Code::success);

        }
    }


}