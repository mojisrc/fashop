<?php
/**
 * 分销相关
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

class Distribution extends Server
{

    /**
     * 招募计划详情
     * @method GET
     * @author 孙泉
     */
    public function recruitInfo()
    {
        $distribution_recruit_model = new \App\Model\DistributionRecruit;
        $field                      = '*';
        $info                       = $distribution_recruit_model->getDistributionRecruitInfo([], $field);

        $distribution_config_model = new \App\Model\DistributionConfig;
        //分销员招募
        $distributor_recruit = $distribution_config_model->getDistributionConfigInfo(['sign' => 'distributor_recruit'], '*');

        // 分销员招募 state:0关闭  1开启[这里用于按钮状态 0不能点击 1能点击]
        if ($distributor_recruit['content']['state'] == 1) {
            $recruit_state = 1;
            $recruit_msg   = '申请成为分销员';
            $recruit_url   = 'Distributor/apply';
            $recruit_param = [];
        } else {
            $recruit_state = 0;
            $recruit_msg   = '商家未开启分销员招募';
            $recruit_url   = null;
            $recruit_param = [];
        }

        $user = $this->getRequestUser();
        if (!$user) {
            $info['apply']['state'] = 1;
            $info['apply']['msg']   = '绑定手机号，成为分销员';
            $info['apply']['url']   = 'User/login';
            $info['apply']['param'] = [];

        } else {
            $distributor_model = new \App\Model\Distributor;
            $distributor_info  = $distributor_model->getDistributorInfo(['user_id' => $user['id']]);
            if (!$distributor_info || $distributor_info['is_retreat'] == 1) {
                $info['apply']['state'] = $recruit_state;
                $info['apply']['msg']   = $recruit_msg;
                $info['apply']['url']   = $recruit_url;
                $info['apply']['param'] = $recruit_param;

            } else {
                switch ($distributor_info['state']) {
                    case 0:
                        $info['apply']['state'] = 0;
                        $info['apply']['msg']   = ($recruit_state == 0) ? $recruit_msg : '等待审核';
                        $info['apply']['url']   = null;
                        $info['apply']['param'] = [];

                        break;
                    case 1:
                        $info['apply']['state'] = 1;
                        $info['apply']['msg']   = '进入分销员中心';
                        $info['apply']['url']   = 'Distributor/info';
                        $info['apply']['param'] = [];
                        break;
                    case 2:
                        $info['apply']['state'] = $recruit_state;
                        $info['apply']['msg']   = ($recruit_state == 0) ? $recruit_msg : '审核未通过，请再次申请';
                        $info['apply']['url']   = $recruit_url;
                        $info['apply']['param'] = $recruit_param;
                        break;
                }
            }
        }

        return $this->send(Code::success, ['info' => $info]);
    }

    /**
     * 配置信息详细
     * @method GET
     * @author 孙泉
     */
    public function configInfo()
    {
        $distribution_config_model = new \App\Model\DistributionConfig;
        $list                      = $distribution_config_model->getDistributionConfigSimpleList();
        return $this->send(Code::success, ['info' => $list]);
    }
}
