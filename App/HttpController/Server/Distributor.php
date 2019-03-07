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
     * a,b都是分销员，b没有上级，b扫a的码   不会成为他的下级   是必须要普通用户才可以的 所以只有在此接口才可以绑上级
     * @method POST
     * @param int   inviter_id  邀请人用户id [必须为状态正常的分销员]
     * @param array message     申请成为分销员时，买家需填写信息，最多支持5条。 非必须 看配置要求
     * 现在普通客户A和分销员B绑定了客户关系 那么普通客户A可以申请成为分销员吗-----可以的
     *
     * 现在普通客户A和分销员B绑定了客户关系，那么A可以申请成为分销员，如果您没有开启允许分销员之间建立客户关系，那么A成了分销员以后，和B就没有客户关系了。开启了允许分销员之间建立客户关系，那么我还是B的客户 我成为了分销员
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
            $distribution_config_model = new \App\Model\DistributionConfig;

            $distributor_recruit = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_recruit'], '*');
            if ($distributor_recruit['content']['state'] == 0) {
                return $this->send(Code::error, [], '商家未开启分销员招募');
            }

            $message                   = null;
            $distributor_write_message = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_write_message'], '*');
            if ($distributor_write_message['content']['state'] == 1) {
                if (!isset($post['message'])) {
                    if (count($post['message']) > 5) {
                        return $this->apiReturn(array('errmsg' => '信息最多5条'), -1);
                    }
                    $message = $post['message'];
                } else {
                    return $this->apiReturn(array('errmsg' => '信息必须'), -1);
                }
            }

            //分销员审核 state:0关闭  1开启
            $distributor_review = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_review'], '*');
            if ($distributor_review['content']['state'] == 0) {
                $state = 1;//0 待审核 1审核通过 2审核拒绝

            } else {
                //TODO distributor_join_threshold 分销员加入门槛  差一个分销员门槛没写
                //不管自动审核还是人工审核 只要开启了分销员审核 申请时都必须验证门槛

                $distributor_join_threshold = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_join_threshold'], '*');


                //审核方式 state:0 automatic自动审核  1 artificial人工审核
                $distributor_review_mode = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_review_mode'], '*');
                if ($distributor_review_mode['content']['state'] == 0) {
                    $state = 1;//0 待审核 1审核通过 2审核拒绝
                } else {
                    $state = 1;//0 待审核 1审核通过 2审核拒绝
                }
            }

            $distributor_model = new \App\Model\Distributor;
            $inviter_id        = 0;
            if ($post['inviter_id']) {
                $invite_distributor = $distributor_model->getDistributorMoreInfo(['distributor.user_id' => $post['inviter_id'], 'distributor.state' => 1, 'distributor.is_retreat' => 0, 'user.phone IS NOT NULL'], 'distributor.*');
                if ($invite_distributor && $invite_distributor['user_phone']) {
                    $inviter_id = $invite_distributor['user_id'];
                }
            }

            $distributor_model->startTransaction();

            $condition['user_id'] = $user['id'];
            $distributor_info     = $distributor_model->getDistributorInfo($condition, '*');
            if ($distributor_info) {
                //0待审核 1审核通过 2审核拒绝
                if (in_array($distributor_info['state'], [0, 1])) {
                    return $this->send(Code::error, [], '已存在此分销员，不能重复申请');
                }

                $map['id'] = $distributor_info['id'];
                //只能有一个上级呢，如果您有上级，扫描别的邀请卡是无法更改的
                if (!$distributor_info['inviter_id']) {
                    $update_data['inviter_id'] = $inviter_id;
                }

                $update_data['state']   = $state;
                $update_data['message'] = $message;

                $result = $distributor_model->updateDistributor(['id' => $distributor_info['id']], $update_data);

            } else {
                $insert_data['user_id']     = $user['id'];
                $insert_data['nickname']    = $user['phone'];
                $insert_data['inviter_id']  = $inviter_id;
                $insert_data['state']       = $state;
                $insert_data['is_retreat']  = 0;
                $insert_data['level']       = 1;
                $insert_data['message']     = $message;
                $insert_data['create_time'] = time();
                $result                     = $distributor_model->insertDistributor($insert_data);
            }
            if (!$result) {
                $distributor_model->rollback();
                return $this->send(Code::error);
            }

            if ($state == 1) {
                //分销员自购分佣
                $distributor_purchase_commission = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_purchase_commission'], '*');

                $distributor_customer_model = new \App\Model\DistributorCustomer;
                //查询用户有没有绑定过分销员
                $distributor_customer = $distributor_customer_model->where(['user_id' => $user['id']])->field('*')->order('id desc')->find();

                //开启分销员自购后 就算开启了分销员建立客户关系，下级成为分销员的时候也会立即和自己绑定客户关系，只能自己绑自己！
                if ($distributor_purchase_commission['content']['state'] == 1) {

                    if ($distributor_customer) {
                        //设置失效
                        $update_data                   = [];
                        $update_data['state']          = 0;
                        $update_data['invalid_time']   = time();
                        $update_data['invalid_reason'] = '客户与自己绑定了客户关系';
                        $update_data['invalid_type']   = 2;

                        $result = $distributor_customer_model->updateDistributorCustomer(['id' => $distributor_customer['id']], $update_data);
                        if (!$result) {
                            $distributor_model->rollback();
                            return $this->send(Code::error);
                        }
                    }

                    //自己绑自己
                    $insert_data                        = [];
                    $insert_data['distributor_user_id'] = $distributor_info['user_id'];
                    $insert_data['user_id']             = $distributor_info['user_id'];
                    $insert_data['state']               = 1;
                    $insert_data['create_time']         = time();
                    $insert_data['update_time']         = time();
                    $result                             = $distributor_customer_model->insertDistributorCustomer($insert_data);
                    if (!$result) {
                        $distributor_model->rollback();
                        return $this->send(Code::error);
                    }

                } else {
                    //分销员建立客户关系
                    $distributor_establish_customer_relation = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_establish_customer_relation'], '*');
                    if ($distributor_establish_customer_relation['content']['state'] == 0) {
                        if ($distributor_customer) {
                            //设置失效
                            $update_data                   = [];
                            $update_data['state']          = 0;
                            $update_data['invalid_time']   = time();
                            $update_data['invalid_reason'] = '后台关闭分销员建立客户关系，客户自己成为分销员，关系失效';
                            $update_data['invalid_type']   = 4;

                            $result = $distributor_customer_model->updateDistributorCustomer(['id' => $distributor_customer['id']], $update_data);
                            if (!$result) {
                                $distributor_model->rollback();
                                return $this->send(Code::error);
                            }
                        }
                    }
                }
            }

            $distributor_model->commit();
            return $this->send(Code::success);
        }
    }

    /**
     * 分销员邀请客户成为下线[分销员---->客户]
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
     * 分销员建立客户关系 是指俩分销员之间建立客户关系
     *
     * 如果是因为和别人绑定，就会显示 已绑定其他分销员 ，过期的显示是指，没有绑定其他分销员
     * 是说客户如果本来和A绑定了，但是过了保护期和有效期，这个时候会显示已过期。  但是在过期后，又和别的分销员绑定了，A看到这个客户，就会看到已绑定其他分销员
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
                $distributor_customer = $distributor_customer_model->where(['user_id' => $post['user_id']])->field('*')->order('id desc')->find();

                $distributor_customer->startTransaction();
                if ($distributor_customer) {

                    //同一个分销员的话 如果在保护期内，客户能够持续的点击销售员的推广链接，则保护期的时间将会被顺延。
                    //过了保护期，客户点击哪个分销员的链接，也是按照最新的规则进行保护的 只不过是可能会被别人抢走而已
                    //如果是同一个分销员的话 直接改 不是的话新增一条 同时把原来的数据更新成失效
                    if ($distributor_customer['distributor_user_id'] == $post['distributor_user_id']) {
                        $update_data['state']       = 1;
                        $update_data['update_time'] = time();
                        $result                     = $distributor_customer_model->updateDistributorCustomer(['id' => $distributor_customer['id']], $update_data);
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

                        $update_data                   = [];
                        $update_data['state']          = 0;
                        $update_data['invalid_time']   = time();
                        $update_data['invalid_reason'] = '客户绑定其他分销员';
                        $update_data['invalid_type']   = 3;

                        $result = $distributor_customer_model->updateDistributorCustomer(['id' => $distributor_customer['id']], $update_data);
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
     * 成交额：  实付的金额，会剔除退款金额，剔除运费
     * 订单数量：下单的订单数，如果全额退款会剔除 未付款不会统计
     */
    public function customers()
    {
        if ($this->verifyResourceRequest() !== true) {
            $this->send(Code::user_access_token_error);
        } else {
            $user                             = $this->getRequestUser();
            $get                              = $this->get;
            $prefix                           = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
            $table_order                      = $prefix . "order";
            $table_distributor                = $prefix . "distributor";
            $table_distributor_customer       = $prefix . "distributor_customer";
            $table_user_profile               = $prefix . "user_profile";
            $distributor_customer_model       = new \App\Model\DistributorCustomer;
            $condition                        = [];
            $condition['distributor_user_id'] = $user['id'];


            $distribution_config_model = new \App\Model\DistributionConfig;

            //保护期设置
            $protect_term = $distribution_config_model->getDistributionConfigInfo(['sign' => 'protect_term'], '*');

            //有效期设置
            $valid_term = $distribution_config_model->getDistributionConfigInfo(['sign' => 'valid_term'], '*');


            if (isset($get['type']) && in_array($get['type'], [0, 1])) {
                if ($get['type'] == 0) {
                    if ($valid_term['content']['days'] == 15) {
                        $condition[] = "state=0 OR (state=1 AND DATE_SUB(CURDATE(), INTERVAL 15 DAY) > DATE(FROM_UNIXTIME(create_time, '%Y-%m-%d')))";

                    } else {
                        $condition[] = "state=0";
                    }

                } else {
                    $condition[] = "state=1 AND DATE_SUB(CURDATE(), INTERVAL 15 DAY) < DATE(FROM_UNIXTIME(create_time, '%Y-%m-%d'))";
                }
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

            //is_distributor 0不是分销员 1分销员
            //成交额：  实付的金额，会剔除退款金额，剔除运费
            //订单数量：下单的订单数，如果全额退款会剔除 未付款不会统计
            $field = '*,' . "
        (SELECT avatar FROM $table_user_profile WHERE user_id=$table_distributor_customer.user_id) AS user_avatar,

        (SELECT nickname FROM $table_user_profile WHERE user_id=$table_distributor_customer.user_id) AS user_nickname,

        IF((SELECT id FROM $table_distributor WHERE user_id=$table_distributor_customer.distributor_user_id AND state=1 AND is_retreat=0)>0,'1','0') AS is_distributor,

        (SELECT COUNT(id) FROM $table_order WHERE (refund_state=0 OR (refund_state=1 AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)) AND distribution_user_id=$table_distributor_customer.distributor_user_id AND user_id=$table_distributor_customer.user_id AND state>=20) AS total_deal_num,

        (SELECT CASE WHEN refund_state=0 THEN CASE WHEN revise_amount>0 THEN SUM(revise_amount-revise_freight_fee) ELSE SUM(amount-freight_fee) END WHEN refund_state=1 THEN CASE WHEN revise_amount>0 THEN CASE WHEN SUM(revise_amount-revise_freight_fee-refund_amount)>0 THEN SUM(revise_amount-revise_freight_fee-refund_amount) ELSE 0 END ELSE CASE WHEN SUM(amount-freight_fee-refund_amount)>0 THEN SUM(amount-freight_fee-refund_amount) ELSE 0 END END ELSE 0 END FROM $table_order WHERE distribution_user_id=$table_distributor_customer.distributor_user_id AND user_id=$table_distributor_customer.user_id AND state>=20) AS total_deal_amount";

            $list = $distributor_customer_model->withTotalCount()->getDistributorCustomerList($condition, $field, 'create_time desc');
            if ($list) {

                foreach ($list as $key => $value) {
                    $protect_term_desc = null;
                    $valid_term_desc   = null;

                    //是否失效判断
                    if ($value['state'] == 1) {
                        if ($valid_term['content']['days'] == 15 && ($valid_term['content']['days'] - sprintf("%.2f", (time() - $value['create_time']) / 86400)) <= 0) {//invalid_type 1
                            //有效期已过 动态显示客户失效
                            $list[$key]['state']          = 0;
                            $list[$key]['invalid_time']   = $value['create_time'] + 86400 * 15;
                            $list[$key]['invalid_reason'] = '推广有效期已过期';
                            $list[$key]['invalid_type']   = 1;
                        }
                    }

                    //不失效的才显示保护期和有效期
                    if ($list[$key]['state'] != 0) {

                        //保护期判断
                        if ($protect_term['content']['state'] == 0) {//保护期已关闭
                            $protect_term_desc = '允许抢客';
                        } else {
                            if ($protect_term['content']['days'] == 32000) {//保护期为永久
                                $protect_term_desc = '永久不会被抢客';
                            } else {
                                if (($protect_term['content']['days'] - sprintf("%.2f", (time() - $value['update_time']) / 86400)) <= 0) {
                                    $protect_term_desc = '允许抢客';
                                } else {
                                    $protect_term_desc = ceil($protect_term['content']['days'] - sprintf("%.2f", (time() - $value['update_time']) / 86400)) . '天内不会被抢客';//过”完“一天才减1
                                }
                            }
                        }
                        $list[$key]['protect_term_desc'] = $protect_term_desc;


                        //有效期判断
                        if ($valid_term['content']['days'] == 15) {
                            $valid_term_desc = '关系' . ceil($valid_term['content']['days'] - sprintf("%.2f", (time() - $value['create_time']) / 86400)) . '天后过期';//过”完“一天才减1
                        } else {
                            $valid_term_desc = '关系长期有效';
                        }
                        $list[$key]['valid_term_desc'] = $valid_term_desc;
                    }
                }
            }
            return $this->send(Code::success, [
                'total_number' => $distributor_customer_model->getTotalCount(),
                'list'         => $list,
            ]);
        }
    }

    /**
     * 客户详情
     * @method GET
     * @param  int customer_id 分销员客户id
     * @author 孙泉
     */
    public function customerDetail()
    {
        $get = $this->get;
        if ($this->validator($get, 'Server/Distributor.customerDetail') !== true) {
            return $this->send(Code::param_error, [], $this->getValidator()->getError());
        } else {
            $prefix                     = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
            $table_order                = $prefix . "order";
            $table_distributor          = $prefix . "distributor";
            $table_distributor_customer = $prefix . "distributor_customer";
            $table_user_profile         = $prefix . "user_profile";
            $distributor_customer_model = new \App\Model\DistributorCustomer;
            $condition                  = [];

            $distribution_config_model = new \App\Model\DistributionConfig;

            //保护期设置
            $protect_term = $distribution_config_model->getDistributionConfigInfo(['sign' => 'protect_term'], '*');

            //有效期设置
            $valid_term = $distribution_config_model->getDistributionConfigInfo(['sign' => 'valid_term'], '*');

            //is_distributor 0不是分销员 1分销员
            //成交额：  实付的金额，会剔除退款金额，剔除运费
            //订单数量：下单的订单数，如果全额退款会剔除 未付款不会统计
            $field = '*,' . "
        (SELECT avatar FROM $table_user_profile WHERE user_id=$table_distributor_customer.user_id) AS user_avatar,

        (SELECT nickname FROM $table_user_profile WHERE user_id=$table_distributor_customer.user_id) AS user_nickname,

        IF((SELECT id FROM $table_distributor WHERE user_id=$table_distributor_customer.distributor_user_id AND state=1 AND is_retreat=0)>0,'1','0') AS is_distributor,

        (SELECT COUNT(id) FROM $table_order WHERE (refund_state=0 OR (refund_state=1 AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)) AND distribution_user_id=$table_distributor_customer.distributor_user_id AND user_id=$table_distributor_customer.user_id AND state>=20) AS total_deal_num,

        (SELECT CASE WHEN refund_state=0 THEN CASE WHEN revise_amount>0 THEN SUM(revise_amount-revise_freight_fee) ELSE SUM(amount-freight_fee) END WHEN refund_state=1 THEN CASE WHEN revise_amount>0 THEN CASE WHEN SUM(revise_amount-revise_freight_fee-refund_amount)>0 THEN SUM(revise_amount-revise_freight_fee-refund_amount) ELSE 0 END ELSE CASE WHEN SUM(amount-freight_fee-refund_amount)>0 THEN SUM(amount-freight_fee-refund_amount) ELSE 0 END END ELSE 0 END FROM $table_order WHERE distribution_user_id=$table_distributor_customer.distributor_user_id AND user_id=$table_distributor_customer.user_id AND state>=20) AS total_deal_amount";

            $info = $distributor_customer_model->getDistributorCustomerInfo($condition, $field);

            if ($info) {
                $protect_term_desc = null;
                $valid_term_desc   = null;

                //是否失效判断
                if ($info['state'] == 1) {
                    if ($valid_term['content']['days'] == 15 && ($valid_term['content']['days'] - sprintf("%.2f", (time() - $info['create_time']) / 86400)) <= 0) {//invalid_type 1
                        //有效期已过 动态显示客户失效
                        $info['state']          = 0;
                        $info['invalid_time']   = $info['create_time'] + 86400 * 15;
                        $info['invalid_reason'] = '推广有效期已过期';
                        $info['invalid_type']   = 1;
                    }
                }

                //不失效的才显示保护期和有效期
                if ($info['state'] != 0) {

                    //保护期判断
                    if ($protect_term['content']['state'] == 0) {//保护期已关闭
                        $protect_term_desc = '0天';
                    } else {
                        if ($protect_term['content']['days'] == 32000) {//保护期为永久
                            $protect_term_desc = '永久';
                        } else {
                            if (($protect_term['content']['days'] - sprintf("%.2f", (time() - $info['update_time']) / 86400)) <= 0) {
                                $protect_term_desc = '0天';
                            } else {
                                $protect_term_desc = ceil($protect_term['content']['days'] - sprintf("%.2f", (time() - $info['update_time']) / 86400)) . '天';//过”完“一天才减1
                            }
                        }
                    }
                    $info['protect_term_desc'] = $protect_term_desc;

                    //有效期判断
                    if ($valid_term['content']['days'] == 15) {
                        $valid_term_desc = ceil($valid_term['content']['days'] - sprintf("%.2f", (time() - $info['create_time']) / 86400)) . '天';//过”完“一天才减1
                    } else {
                        $valid_term_desc = '关系长期有效';
                    }
                    $info['valid_term_desc'] = $valid_term_desc;
                }
            }

            return $this->send(Code::success, ['info' => $info]);
        }
    }

    /**
     * 累计邀请(已邀请的分销员)
     * @method GET
     * @author 孙泉
     * @param  string  time_type       时间类型查询 1昨天 2近七天 如果create_time不为空 time_type失效
     * @param array    create_time     [开始时间,结束时间]
     * 注释：我是分销员，点击邀请好友齐推广会显示邀请卡，之后分享其他人扫描，他扫描申请分销员，我是他上级，我的分销员中心累计邀请里会显示数字1，点击进入是显示的他
     * 只能有一个上级呢，如果您有上级，扫描别的邀请卡是无法更改的
     */
    public function distributors()
    {
        if ($this->verifyResourceRequest() !== true) {
            $this->send(Code::user_access_token_error);
        } else {
            $user                                = $this->getRequestUser();
            $user_id                             = $user['id'];
            $get                                 = $this->get;
            $prefix                              = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
            $table_order                         = $prefix . "order";
            $condition                           = [];
            $condition['distributor.state']      = 1; //默认0 待审核 1审核通过 2审核拒绝 [只有通过了 才显示]
            $condition['distributor.inviter_id'] = $user_id;

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


            $distributor_model = new \App\Model\Distributor;
            $count             = $distributor_model->getDistributorMoreCount($condition, '');
            $field             = 'distributor.*,user.phone,invite_user.phone AS invite_phone';

            //total_deal_num        累计成交笔数
            //total_deal_amount     累计成交金额
            $field = $field . ",
        (SELECT COUNT(id) FROM $table_order WHERE (distribution_user_id=distributor.user_id AND state>=20) OR (user_id=distributor.user_id AND state>=20) AND distribution_invite_user_id=$user_id) AS total_deal_num,

        (SELECT CASE WHEN refund_state=0 THEN CASE WHEN revise_amount>0 THEN SUM(revise_amount-revise_freight_fee) ELSE SUM(amount-freight_fee) END WHEN refund_state=1 THEN CASE WHEN revise_amount>0 THEN CASE WHEN SUM(revise_amount-revise_freight_fee-refund_amount)>0 THEN SUM(revise_amount-revise_freight_fee-refund_amount) ELSE 0 END ELSE CASE WHEN SUM(amount-freight_fee-refund_amount)>0 THEN SUM(amount-freight_fee-refund_amount) ELSE 0 END END ELSE 0 END FROM $table_order WHERE (distribution_user_id=distributor.user_id AND state>=20) OR (user_id=distributor.user_id AND state>=20) AND distribution_invite_user_id=$user_id) AS total_deal_amount";

            $order = 'distributor.id desc';
            $list  = $distributor_model->getDistributorMoreList($condition, $field, $order, $this->getPageLimit(), '');

            return $this->send(Code::success, [
                'total_number' => $count,
                'list'         => $list,
            ]);
        }
    }

    /**
     * 推广订单[我作为分销员推广的订单]
     * @method GET
     * @param  string  time_type        时间类型查询 1昨天 2近七天 如果create_time不为空 time_type失效
     * @param array    create_time      [开始时间,结束时间]
     * @param array    settlement_state 结算状态 0未结算 1已结算
     */
    public function promotionOrder()
    {
        if ($this->verifyResourceRequest() !== true) {
            $this->send(Code::user_access_token_error);
        } else {
            $user              = $this->getRequestUser();
            $user_id           = $user['id'];
            $get               = $this->get;
            $prefix            = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
            $table_distributor = $prefix . "distributor";
            $table_user        = $prefix . "user";
            $table_order       = $prefix . "order";
            $table_order_goods = $prefix . "order_goods";

            $condition['order.distribution_user_id'] = $user['id'];

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
                $condition['order.create_time'] = [
                    'between',
                    $get['create_time'],
                ];
            }

            if (isset($get['settlement_state']) && in_array($get['settlement_state'], [0, 1])) {
                $condition['order.distribution_settlement'] = $get['settlement_state'];
            }

            $field = 'order.*';
            //商品佣金 和 邀请奖励
            $field = $field . ",
        (SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_user_id=$user_id AND state>=20 AND pay_name='online' AND id=order.id AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)) AS goods_commission,

              (SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_invite_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_invite_ratio/100),2) END) FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_invite_user_id=$user_id AND state>=20 AND pay_name='online' AND id=order.id AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)) AS invite_amount," .
                "
        (SELECT phone FROM $table_user WHERE id=order.distribution_user_id) AS distributor_phone,

        (SELECT nickname FROM $table_distributor WHERE user_id=order.distribution_user_id) AS distributor_nickname";


            $orderLogic = new OrderLogic($condition);
            $orderLogic->page($this->getPageLimit())->extend([
                                                                 'order_goods',
                                                             ]);
            $count = $orderLogic->count();
            if ($count > 0) {
                $orderLogic->field($field);
            }
            $list = $orderLogic->list();

            if ($list) {
                $list = \App\Model\Order::distributionPromotionDesc($list);
            }

            return $this->send(Code::success, [
                'total_number' => $count,
                'list'         => $list,
            ]);
        }
    }

    /**
     * 累计客户数量 + 累计邀请数量 + 推广订单数量 + 累计收益(元) 包含待结算 + 昨日收益（元） 包含待结算 + 昨日收益（元） 包含待结算 + 可提现佣金
     * @method GET
     * @author 孙泉
     * 分销员首页 各种数量参数
     * 累计收益(元) 包含待结算：包含佣金和邀请奖励
     * 累计收益含待结算，可提现佣金里不含 除了这个不同 其他计算规则都是一样的，可提现佣金其实就是已结算金额
     */
    public function statistics()
    {
        if ($this->verifyResourceRequest() !== true) {
            $this->send(Code::user_access_token_error);
        } else {
            $prefix  = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
            $user    = $this->getRequestUser();
            $user_id = $user['id'];

            //累计客户数量
            $distributor_customer_model       = new \App\Model\DistributorCustomer;
            $condition                        = [];
            $condition['distributor_user_id'] = $user_id;
            $customers_num                    = $distributor_customer_model->where($condition)->count();

            //累计邀请数量(已邀请的分销员)
            $distributor_model       = new \App\Model\Distributor;
            $condition               = [];
            $condition['state']      = 1; //默认0 待审核 1审核通过 2审核拒绝 [只有通过了 才显示]
            $condition['inviter_id'] = $user_id;
            $distributors_num        = $distributor_model->where($condition)->count();

            //推广订单[我作为分销员推广的订单]
            $order_model                       = new \App\Model\Order;
            $condition                         = [];
            $condition['distribution_user_id'] = $user_id;
            $promotion_order_num               = $order_model->where($condition)->count();

            //昨日新增客户（人）[属于昨日的累计客户数量]
            $condition                        = [];
            $condition['distributor_user_id'] = $user_id;
            $condition[]                      = "TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(create_time, '%Y-%m-%d %H:%i:%S')) = 1";
            $yesterday_customers_num          = $distributor_customer_model->where($condition)->count();

            //累计收益(元) 包含待结算
            $table_order       = $prefix . "order";
            $table_order_goods = $prefix . "order_goods";
            $order_goods_model = new \App\Model\OrderGoods;

            $amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS total_deal_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE (distribution_user_id=$user_id OR distribution_invite_user_id=$user_id) AND state>=20 AND pay_name='online' AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");

            $unsettlement_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS unsettlement_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE (distribution_user_id=$user_id OR distribution_invite_user_id=$user_id) AND state>=20 AND pay_name='online' AND distribution_settlement=0 AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");

            $settlement_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS settlement_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE (distribution_user_id=$user_id OR distribution_invite_user_id=$user_id) AND state>=20 AND pay_name='online' AND distribution_settlement=1 AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");

            //昨日收益（元） 包含待结算
            $condition_str = "TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(create_time, '%Y-%m-%d %H:%i:%S'))=1";

            $yesterday_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS total_deal_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE (distribution_user_id=$user_id OR distribution_invite_user_id=$user_id) AND state>=20 AND pay_name='online' AND $condition_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");


            $yesterday_unsettlement_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS unsettlement_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE (distribution_user_id=$user_id OR distribution_invite_user_id=$user_id) AND state>=20 AND pay_name='online' AND distribution_settlement=0 AND $condition_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");

            $yesterday_settlement_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS settlement_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE (distribution_user_id=$user_id OR distribution_invite_user_id=$user_id) AND state>=20 AND pay_name='online' AND distribution_settlement=1 AND $condition_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");


            $info['customers_num']           = $customers_num;
            $info['distributors_num']        = $distributors_num;
            $info['promotion_order_num']     = $promotion_order_num;
            $info['yesterday_customers_num'] = $yesterday_customers_num;

            $info['amount']              = (floatval($amount[0]['total_deal_amount']) > 0) ? floatval($amount[0]['total_deal_amount']) : 0;
            $info['settlement_amount']   = (floatval($settlement_amount[0]['settlement_amount']) > 0) ? floatval($settlement_amount[0]['settlement_amount']) : 0;
            $info['unsettlement_amount'] = (floatval($unsettlement_amount[0]['unsettlement_amount']) > 0) ? floatval($unsettlement_amount[0]['unsettlement_amount']) : 0;

            $info['yesterday_amount']              = (floatval($yesterday_amount[0]['total_deal_amount']) > 0) ? floatval($yesterday_amount[0]['total_deal_amount']) : 0;
            $info['yesterday_settlement_amount']   = (floatval($yesterday_settlement_amount[0]['settlement_amount']) > 0) ? floatval($yesterday_settlement_amount[0]['settlement_amount']) : 0;
            $info['yesterday_unsettlement_amount'] = (floatval($yesterday_unsettlement_amount[0]['unsettlement_amount']) > 0) ? floatval($yesterday_unsettlement_amount[0]['unsettlement_amount']) : 0;

            return $this->send(Code::success, ['info' => $info]);
        }
    }

    /**
     * 累计客户（人） + 累计邀请（人） + 商品佣金（元） + 邀请奖励（元）
     * @method GET
     * @param  string  time_type       时间类型查询 1昨天 2近七天 如果create_time不为空 time_type失效
     * @param array    create_time     [开始时间,结束时间]
     * @author 孙泉
     * 商品佣金（元） + 邀请奖励（元）= 累计收益(元) 包含待结算（上个接口）
     * 相关名词解释：
     * 客户：和分销员绑定了客户关系的买家或分销员
     * 邀请：分销员成功邀请的下级分销员
     * 商品佣金：分销员推荐客户购买后，分销员商品获得的佣金
     * 邀请奖励：下级分销员推广商品后，上级获得的奖励
     *
     */
    public function statisticsSub()
    {
        if ($this->verifyResourceRequest() !== true) {
            $this->send(Code::user_access_token_error);
        } else {
            $get     = $this->get;
            $prefix  = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
            $user    = $this->getRequestUser();
            $user_id = $user['id'];

            $map     = [];
            $map_str = 1;
            if (isset($get['time_type']) && in_array($get['time_type'], [1, 2])) {
                switch ($get['time_type']) {
                    case 1:
                        $map_str = $map[] = "TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(create_time, '%Y-%m-%d %H:%i:%S')) = 1";

                        break;
                    case 2:
                        $map_str = $map[] = "DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE(FROM_UNIXTIME(create_time, '%Y-%m-%d'))";
                        break;
                }
            }

            if (!empty($get['create_time'])) {
                $map_str = $map['create_time'] = [
                    'between',
                    $get['create_time'],
                ];
            }

            //累计客户数量
            $distributor_customer_model       = new \App\Model\DistributorCustomer;
            $condition                        = [];
            $condition['distributor_user_id'] = $user_id;
            $customers_num                    = $distributor_customer_model->where($condition)->where($map)->count();

            //累计邀请数量(已邀请的分销员)
            $distributor_model       = new \App\Model\Distributor;
            $condition               = [];
            $condition['state']      = 1; //默认0 待审核 1审核通过 2审核拒绝 [只有通过了 才显示]
            $condition['inviter_id'] = $user_id;
            $distributors_num        = $distributor_model->where($condition)->where($map)->count();

            //商品佣金（元）
            $table_order       = $prefix . "order";
            $table_order_goods = $prefix . "order_goods";
            $order_goods_model = new \App\Model\OrderGoods;

            $goods_commission = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS total_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_user_id=$user_id AND state>=20 AND pay_name='online' AND $map_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");


            $goods_unsettlement_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS unsettlement_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_user_id=$user_id AND state>=20 AND pay_name='online' AND distribution_settlement=0 AND $map_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");

            $goods_settlement_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_ratio/100),2) END) AS settlement_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_user_id=$user_id AND state>=20 AND pay_name='online' AND distribution_settlement=1 AND $map_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");


            //邀请奖励（元）
            $invite_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_invite_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_invite_ratio/100),2) END) AS total_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_invite_user_id=$user_id AND state>=20 AND pay_name='online' AND $map_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");

            $invite_unsettlement_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_invite_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_invite_ratio/100),2) END) AS unsettlement_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_invite_user_id=$user_id AND state>=20 AND pay_name='online' AND distribution_settlement=0 AND $map_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");

            $invite_settlement_amount = $order_goods_model->rawQuery("SELECT (CASE WHEN goods_revise_price>0 THEN TRUNCATE(SUM((goods_revise_price-refund_amount)*distribution_invite_ratio/100),2) ELSE TRUNCATE(SUM((goods_pay_price-refund_amount)*distribution_invite_ratio/100),2) END) AS settlement_amount FROM $table_order_goods WHERE CASE WHEN goods_revise_price>0 THEN (goods_revise_price-refund_amount)>0 ELSE (goods_pay_price-refund_amount)>0 END AND order_id IN (SELECT group_concat(id) FROM $table_order WHERE distribution_invite_user_id=$user_id AND state>=20 AND pay_name='online' AND distribution_settlement=1 AND $map_str AND CASE WHEN revise_amount>0 THEN (revise_amount-revise_freight_fee-refund_amount)>0 ELSE (amount-freight_fee-refund_amount)>0 END)");

            $info['customers_num']    = $customers_num;
            $info['distributors_num'] = $distributors_num;


            $info['goods_commission'] = (floatval($goods_commission[0]['total_amount']) > 0) ? floatval($goods_commission[0]['total_amount']) : 0;

            $info['goods_settlement_amount'] = (floatval($goods_settlement_amount[0]['settlement_amount']) > 0) ? floatval($goods_settlement_amount[0]['settlement_amount']) : 0;

            $info['goods_unsettlement_amount'] = (floatval($goods_unsettlement_amount[0]['unsettlement_amount']) > 0) ? floatval($goods_unsettlement_amount[0]['unsettlement_amount']) : 0;


            $info['invite_amount'] = (floatval($invite_amount[0]['total_amount']) > 0) ? floatval($invite_amount[0]['total_amount']) : 0;

            $info['invite_settlement_amount'] = (floatval($invite_settlement_amount[0]['settlement_amount']) > 0) ? floatval($invite_settlement_amount[0]['settlement_amount']) : 0;

            $info['invite_unsettlement_amount'] = (floatval($invite_unsettlement_amount[0]['unsettlement_amount']) > 0) ? floatval($invite_unsettlement_amount[0]['unsettlement_amount']) : 0;

            return $this->send(Code::success, ['info' => $info]);
        }
    }

}
