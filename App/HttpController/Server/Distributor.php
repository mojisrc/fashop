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
     */
    public function inviteCustomer(){
        if ($this->verifyResourceRequest() !== true) {
            return $this->send(Code::user_access_token_error);
        } else {
            $post = $this->post;
            if ($this->validator($post, 'Server/Distributor.inviteCustomer') !== true) {
                return $this->send(Code::param_error, [], $this->getValidator()->getError());
            } else {
                $distributor_model          = new \App\Model\Distributor;
                $distributor_customer = $distributor_customer_model->getDistributorCustomerInfo(['user_id' => $value, 'state' => 0]);


        //TODO 没写完
//        distributor_user_id 分销员用户id
//        user_id 用户id
//        state 默认1 0失效 1有效
//        create_time 创建时间
//        invalid_time失效时间




//        如果您之前不是其他分销员的客户，或没有设置保护期的话 -------------扫码后会成为分销员的客户，同时后台设置有分销员保护期的话在保护期间客户关系不会因为扫其他分销员的码变更
//        我之前没有分销员 同时后台设置了分销员的保护期 结果是什么-----------正常成为分销员的用户并且享有分销员保护期
//
//        保护期是指客户关系在多久内受到保护，即使客户点了其他分销员的链接，也不会改变客户关系。您可以点此链接了解
//        https://j.youzan.com/xySygY
//
//        存在前提，已经绑定客户关系才会有保护期
//假如 客户A 绑定了分销员A  然后 他俩绑定关系失效了 客户A就可以再次绑定分销员A  分销员A看见累计客户是显示两条还是一条？-----------在的呢，您说的情况只显示1条记录的呢，显示最新的哦

            }
        }
    }



}
