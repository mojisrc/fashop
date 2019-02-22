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
                $update_data['is_retreat'] = 0;
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


}
