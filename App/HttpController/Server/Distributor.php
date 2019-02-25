<?php
/**
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

namespace App\HttpController\Server;

use App\Utils\Code;

class Distributor extends Server
{
    /**
     * 申请成为分销员
     * @method POST
     * @param int inviter_id 邀请人用户id [必须为撞他正常的分销员]
     */
    public function applly()
    {
        if ($this->verifyResourceRequest() !== true) {
            return $this->send(Code::user_access_token_error);
        } else {
            $post = $this->post;
            $user = $this->getRequestUser();
            if (!$user['phone']) {
                return $this->send(Code::error, [], '绑定手机号，成为分销员');
            }
            $distributor_model = new \App\Model\Distributor;
            $inviter_id        = 0;
            if ($post['inviter_id']) {
                $invite_distributor = $distributor_model->getDistributorMoreInfo(['distributor.user_id' => $post['inviter_id'], 'distributor.state' => 1, 'distributor.is_retreat' => 0, 'user.phone IS NOT NULL'], 'distributor.*');
                if ($invite_distributor && $invite_distributor['user_phone']) {
                    $inviter_id = $invite_distributor['user_id'];
                }
            }

            $condition['user_id'] = $user['id'];
            $distributor_info     = $distributor_model->getDistributorInfo($condition, '*');
            if ($distributor_info) {
                //0待审核 1审核通过 2审核拒绝
                if (in_array($distributor_info['state'], [0, 1])) {
                    return $this->send(Code::error, [], '已存在此分销员，不能重复申请');
                }

                $map['id']                 = $distributor_info['id'];
                $update_data['inviter_id'] = $inviter_id;
                $update_data['state']      = 0;
                $result                    = $distributor_model->updateDistributor(['id' => $distributor_info['id']], $update_data);

            } else {
                $insert_data['user_id']     = $user['id'];
                $insert_data['nickname']    = $user['phone'];
                $insert_data['inviter_id']  = $inviter_id;
                $insert_data['state']       = 0;
                $insert_data['is_retreat']  = 0;
                $insert_data['level']       = 1;
                $insert_data['create_time'] = time();
                $result                     = $distributor_model->insertDistributor($insert_data);
            }

            if ($result) {
                return $this->send(Code::success);
            } else {
                return $this->send(Code::error);
            }
        }
    }

    /**
     * 分销员邀请客户成为下线
     * @method GET
     * @param int distributor_user_id   分销员用户id
     * @param int user_id               用户id
     * @author 孙泉
     * 如果您之前不是其他分销员的客户，或没有设置保护期的话 -------------扫码后会成为分销员的客户，同时后台设置有分销员保护期的话在保护期间客户关系不会因为扫其他分销员的码变更
     *
     * 保护期是指客户关系在多久内受到保护，即使客户点了其他分销员的链接，也不会改变客户关系。
     *
     * 存在前提，已经绑定客户关系才会有保护期
     * 假如 客户A 绑定了分销员A  然后 他俩绑定关系失效了 客户A就可以再次绑定分销员A  分销员A看见累计客户是显示两条还是一条？-----------在的呢，您说的情况只显示1条记录的呢，显示最新的
     *
     * 是的，分销员之间绑定客户关系，也是包括自己的哦。所以自己点击自己推广链接也是可以正常绑定的哦。
     * 那我开启了分销员自购分佣 关闭了分销员建立客户关系  我自己怎么和自己绑定客户关系？
     * 分销员自己点击自己推广链接进行绑定客户关系和绑定客户是一个流程
     *
     * 您好，如1号点击了客户链接，保护期设置的是15天，将会保护到15号，在期间如客户3号又点击了分销员链接，保护期将延续到18号
     *
     * 保护期是保护在这个时间内分销员之间不进行抢客行为。A点击B的链接绑定客户关系，保护期十五天，十五天期间未再次点击B链接，十五天后保护期过了，然后再次点击B的链接保护期还是十五天
     * 还是这个逻辑  只不过是可能会被别人抢走而已？
     * 1.保护期大于有效期的时候：有效期外，允许别的分销员抢客；2.保护期小于有效期的情况下，保护期外是允许抢客的呢
     * 您好， 开启分销员自购后 分销员自己和自己绑定客户关系  ，是 后台成为分销员审核通过就绑定的哦
     */
    public function inviteCustomer()
    {
        if ($this->verifyResourceRequest() !== true) {
            return $this->send(Code::user_access_token_error);
        } else {
            $post = $this->post;
            if ($this->validator($post, 'Server/Distributor.inviteCustomer') !== true) {
                return $this->send(Code::param_error, [], $this->getValidator()->getError());
            } else {
                $distribution_config_model = new \App\Model\DistributionConfig;
                //分销员自购分佣
                $distributor_purchase_commission = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_purchase_commission'], '*');

                //分销员建立客户关系
                $distributor_establish_customer_relation = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_establish_customer_relation'], '*');

                // 判断用户是不是分销员
                //待审核和拒绝审核时还是普通的客户，是还不是分销员的哦。
                //如果分销员被清退了，那么分销员就是客户的身份了哦
                //需要通过后才算分销员，可以绑定建立可以关系。
                $distributor_model = new \App\Model\Distributor;
                $is_distributor    = $distributor_model->getDistributorInfo(['user_id' => $post['user_id'], 'state' => 1, 'is_retreat' => 0]);

                //目前的分销员逻辑规则是，您这边关闭了分销员自购后，开启了分销员之间允许建立客户关系，那么分销员就不能和自己绑定客户关系了。只能和其他分销员进行绑定客户关系的情况。
                if ($distributor_purchase_commission['content']['state'] == 0) {
                    if ($distributor_establish_customer_relation['content']['state'] == 1 && $post['distributor_user_id'] == $post['user_id']) {
                        return $this->send(Code::error, [], '后台设置：分销员不能和自己绑定客户关系');
                    }

                    if ($distributor_establish_customer_relation['content']['state'] == 0 && $is_distributor) {
                        return $this->send(Code::error, [], '后台关闭了分销员建立客户关系');
                    }
                } else {
                    //开启分销员自购后 就算开启了分销员建立客户关系，下级成为分销员的时候也会立即和自己绑定客户关系，只能自己绑自己！
                    if ($is_distributor && $post['user_id'] != $post['distributor_user_id']) {
                        return $this->send(Code::error, [], '后台设置：分销员只和自己绑定客户关系');
                    }
                }

                //保护期设置
                $protect_term = $distribution_config_model->getDistributionConfigInfo(['sign' => 'protect_term'], '*');

                //有效期设置
                $valid_term = $distribution_config_model->getDistributionConfigInfo(['sign' => 'valid_term'], '*');

                //取保护期和有效期最小的那个
                $term_days                  = ($protect_term['content']['days'] < $valid_term['content']['days']) ? $protect_term['content']['days'] : $valid_term['content']['days'];
                $distributor_customer_model = new \App\Model\DistributorCustomer;

                //查询用户有没有绑定过分销员[不区分有效无效]
                $distributor_customer = $distributor_customer_model->getDistributorCustomerInfo(['user_id' => $post['user_id']]);

                $distributor_customer->startTransaction();
                if ($distributor_customer) {

                    //同一个分销员的话 如果在保护期内，客户能够持续的点击销售员的推广链接，则保护期的时间将会被顺延。
                    //过了保护期，客户点击哪个分销员的链接，也是按照最新的规则进行保护的 只不过是可能会被别人抢走而已
                    //如果是同一个分销员的话 直接改 不是的话新增一条 同时把原来的数据更新成失效
                    if ($distributor_customer['distributor_user_id'] == $post['distributor_user_id']) {
                        $update_data['distributor_user_id'] = $post['distributor_user_id'];
                        $update_data['user_id']             = $post['user_id'];
                        $update_data['state']               = 1;
                        $update_data['update_time']         = time();
                        $result                             = $distributor_customer_model->updateDistributorCustomer(['id' => $distributor_customer['id']], $update_data);
                        if (!$result) {
                            $distributor_customer_model->rollback();
                            return $this->send(Code::error);
                        }

                    } else {

                        //客户此时的保护期（天）
                        $term = $term_days - sprintf("%.2f", (time() - $distributor_customer['update_time']) / 86400);

                        //保护期未到期 客户不能被别人抢走
                        if ($protect_term['content']['state'] == 1 && $term > 0) {
                            return $this->send(Code::error, [], '客户在保护期内，不能变更');
                        }

                        $update_data                 = [];
                        $update_data['state']        = 0;
                        $update_data['invalid_time'] = time();
                        $result                      = $distributor_customer_model->updateDistributorCustomer(['id' => $distributor_customer['id']], $update_data);
                        if (!$result) {
                            $distributor_customer_model->rollback();
                            return $this->send(Code::error);
                        }

                        $insert_data['distributor_user_id'] = $post['distributor_user_id'];
                        $insert_data['user_id']             = $post['user_id'];
                        $insert_data['state']               = 1;
                        $insert_data['create_time']         = time();
                        $insert_data['update_time']         = time();
                        $result                             = $distributor_customer_model->insertDistributorCustomer($insert_data);
                        if (!$result) {
                            $distributor_customer_model->rollback();
                            return $this->send(Code::error);
                        }
                    }

                } else {

                    $insert_data['distributor_user_id'] = $post['distributor_user_id'];
                    $insert_data['user_id']             = $post['user_id'];
                    $insert_data['state']               = 1;
                    $insert_data['create_time']         = time();
                    $insert_data['update_time']         = time();
                    $result                             = $distributor_customer_model->insertDistributorCustomer($insert_data);
                    if (!$result) {
                        $distributor_customer_model->rollback();
                        return $this->send(Code::error);
                    }
                }
            }
            $distributor_customer_model->commit();
            return $this->send(Code::success);
        }
    }

    /**
     * 累计客户
     * @method GET
     * @param  int     type            0失效 1有效
     * @param  string  time_type       时间类型查询 1昨天 2近七天 如果create_time不为空 time_type失效
     * @param array    create_time     [开始时间,结束时间]
     * @author 孙泉
     */
    public function customers()
    {
        $get                        = $this->get;
        $distributor_customer_model = new \App\Model\DistributorCustomer;
        $condition                  = [];

        if (isset($get['type']) && in_array($get['type'], [0, 1])) {
            $condition['state'] = $get['state'];
        }

        if (isset($get['time_type']) && in_array($get['time_type'], [1, 2])) {
            switch ($get['time_type']) {
                case 1:
                    $condition[] = "TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(create_time, '%Y-%m-%d %H:%i:%S')) = 1";

                    break;
                case 2:
                    $condition[] = "DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE(FROM_UNIXTIME(create_time, '%Y-%m-%d'))";
                    break;
            }
        }

        if (!empty($get['create_time'])) {
            $condition['create_time'] = [
                'between',
                $get['create_time'],
            ];
        }

        $list = $distributor_customer_model->withTotalCount()->getDistributorCustomerList($condition, '*', 'create_time desc');
        return $this->send(Code::success, [
            'total_number' => $distributor_customer_model->getTotalCount(),
            'list'         => $list,
        ]);
    }

}
