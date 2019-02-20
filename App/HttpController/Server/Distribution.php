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
        return $this->send(Code::success, ['info' => $info]);
    }

}
